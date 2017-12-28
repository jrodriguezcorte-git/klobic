<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

require ROOT_FOLDER . 'vendor/autoload.php';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

/**
 * Class login
 * handles the user's login and logout process
 */
class Forgot
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$forgot = new Forgot();"
     */
    public function __construct($disable = false)
    {
		if(!$disable){
	        // forgot via post data (if user just submitted a login form)
	        if (isset($_POST["forgot"])) {
	            $this->doForgotPassword($_POST['user_email']);
        
		        // if ($this->messages || $this->errors) {
			    $jsondata = array('errors'=>$this->errors, 'messages'=>$this->messages);
	        	header('Content-type: application/json');
				echo json_encode($jsondata);
				die();
		        // }
	        }
		}
    }

    /**
     * log in with post data
     */
    public function doForgotPassword($user_email_input)
    {
    	try
	    {	
	        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
	        NoCSRF::check( 'csrf_token', $_POST, true, 60*10, true );
	            
	        // check login form contents
	        if (empty($user_email_input)) {
	            $this->errors[] = "Email field was empty.";
	        } elseif (!empty($user_email_input)) {
	
	            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
	            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	            // change character set to utf8 and check it
	            if (!$this->db_connection->set_charset("utf8")) {
	                $this->errors[] = $this->db_connection->error;
	            }
	
	            // if no connection errors (= working database connection)
	            if (!$this->db_connection->connect_errno) {
	
	                // escape the POST stuff
	                $user_email = $this->db_connection->real_escape_string($user_email_input);
	
	                // database query, getting all the info of the selected user (allows login via email address in the
	                // username field)
	                $sql = "SELECT id, name, email FROM users WHERE email=?";
                	$result_of_login_check = $this->db_connection->prepare($sql);
					$result_of_login_check->bind_param('s', $user_email);
					$result_of_login_check->execute();
					$result_of_login_check->bind_result($user_id, $name, $email);
					$result_of_login_check->fetch();
					$result_of_login_check->close();
					
	                // if this user exists
	                if (!empty($email)) {
	                    $tokenInfo = array('id'=>$user_id, 'time'=> time());
	                    
						$encrypt = encrypt_decrypt('encrypt', json_encode($tokenInfo));
						$url = DOMAIN_NAME .'account.php?tk='.$encrypt.'&action=reset';
	                    // https://api.klobic.com/mailers/forgot.php?t=abcdef&name=Jonathan&email=rockjonathan18@gmail.com&url=https://klobic.com
                    
						// Get cURL resource
						$curl = curl_init();
						// Set some options - we are passing in a useragent too here
						curl_setopt_array($curl, array(
						    CURLOPT_RETURNTRANSFER => 1,
						    CURLOPT_URL => 'https://api.klobic.com/mailers/forgot.php',
						    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5',
						    CURLOPT_POST => 1,
						    CURLOPT_POSTFIELDS => array(
						        "t" => HTTP_API_TOKEN,
						        "name" => $name,
						        "email" => $email,
						        "url" => $url
						    )
						));
						
						if(!curl_exec($curl))
							$this->errors[] = "Message could not be sent. Try again.";
						else
							$this->messages[] = 'We have sent an email with the details to reset your password.';
					    
						// Close request to clear up some resources
						curl_close($curl);
	                } else {
	                    $this->errors[] = "This user does not exist.";
	                }
	            } else {
	                $this->errors[] = "Database connection problem.";
	            }
	        }
	        $this->messages[] = 'CSRF check passed. Form parsed.';
	    }
	    catch ( Exception $e )
	    {
	        // CSRF attack detected
	        // $result = $e->getMessage(); 
	        $result = 'Invalid token. Please <a href="/auth/forgot.php">reload this page</a>.';
	        $this->errors[] = $result;
			
	    }		        
    }
}
