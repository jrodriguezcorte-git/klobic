<?php
/**
 * Class login
 * handles the user's login and logout process
 */
class Login
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
     * you know, when you do "$login = new Login();"
     */
    public function __construct($disable = false)
    {
		if(!$disable){
	        // create/read session, absolutely necessary
	        session_start();
	        // check the possible login actions:
	        // if user tried to log out (happen when user clicks logout button)
	        if (isset($_GET["logout"])) {
	            $this->doLogout();
	        }
	        // login via post data (if user just submitted a login form)
	        elseif (isset($_POST["login"])) {
	            $this->doLogin($_POST['user_email'], $_POST['user_password']);
        
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
    public function doLogin($user_email_input, $user_password_input)
    {
    	try
	    {	
	        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
	        NoCSRF::check( 'csrf_token', $_POST, true, 60*10, true );
	        //  die(var_dump(DB_HOST.' '.DB_USER.' '.DB_PASS.' '.DB_NAME));
	        // check login form contents
	        if (empty($user_email_input)) {
	            $this->errors[] = "El email no debe ser vacío.";
	        } elseif (empty($user_password_input)) {
	            $this->errors[] = "La contraseña no debe ser vacía.";
	        } elseif (!empty($user_email_input) && !empty($user_password_input)) {
                  //   die(var_dump(DB_HOST.' '.DB_USER.' '.DB_PASS.' '.DB_NAME));   
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
	                $sql = "SELECT name, email, password_hash FROM users WHERE email=?";
                	$result_of_login_check = $this->db_connection->prepare($sql);
					$result_of_login_check->bind_param('s', $user_email);
					$result_of_login_check->execute();
					$result_of_login_check->bind_result($name, $email, $password_hash);
					$result_of_login_check->fetch();
					$result_of_login_check->close();
					
	                // if this user exists
	                if (!empty($email)) {
	
	                    // using PHP 5.5's password_verify() function to check if the provided password fits
	                    // the hash of that user's password
	                    if (password_verify($user_password_input, $password_hash)) {
	
	                        // write user data into PHP SESSION (a file on your server)
	                        $_SESSION['user_name'] = $name;
	                        $_SESSION['user_email'] = $email;
	                        $_SESSION['user_login_status'] = 1;
							                            
			                $sql = "UPDATE users SET last_login_at=? WHERE email=?";
			                $date = date("Y-m-d H:i:s");
		                	$result_of_login_check = $this->db_connection->prepare($sql);
							$result_of_login_check->bind_param('ss', $date, $user_email);
							$result_of_login_check->execute();
							$result_of_login_check->fetch();
							$result_of_login_check->close();
	
	                    } else {
	                        $this->errors[] = "Contraseña incorrecta. Intente nuevamente.";
	                    }
	                } else {
	                    $this->errors[] = "El usuario no existe.";
	                }
	            } else {
	                $this->errors[] = "Problema de conexión con la base de datos.";
	            }
	        }
	        $this->messages[] = 'CSRF pasó.';
	    }
	    catch ( Exception $e )
	    {
	        // CSRF attack detected
	        // $result = $e->getMessage(); 
	        $result = 'Token Inválido, Por favor <a href="/auth/login.php">recargar esta página</a>.';
	        $this->errors[] = $result;
			
	    }		        
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "Ha cerrado sesión.";
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
