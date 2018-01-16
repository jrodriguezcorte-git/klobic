<?php
/**
 * Class registration
 * handles the user registration
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {    	
        if (isset($_POST["register"])) {
            $this->registerNewUser();
            
        } elseif(isset($_POST["update-account"])) {
        	$this->updateUser();
        }
        
        if (isset($_POST["update-account"]) || isset($_POST["register"])) {
		    $jsondata = array('errors'=>$this->errors, 'messages'=>$this->messages);
        	header('Content-type: application/json');
			echo json_encode($jsondata);
			die();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
    	try
	    {
	        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
	        NoCSRF::check( 'csrf_token', $_POST, true, 60*10, true );		
	        if (empty($_POST['user_name'])) {
	            $this->errors[] = "Usuario Vacío";
	        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
	            $this->errors[] = "Contraseña Vacía";
	        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
	            $this->errors[] = "La contraseña y la contraseña repetida no son iguales";
	        } elseif (strlen($_POST['user_password_new']) < 6) {
	            $this->errors[] = "La contraseña debe tener un mínimo de longitud de 6 caracteres";
	        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
	            $this->errors[] = "El nombre no puede ser más corte de 2 o más largo de 64 caracteres";
	        } elseif (!preg_match('/^[a-zA-Z0-9\s]{2,64}$/i', $_POST['user_name'])) {
	            $this->errors[] = "El nombre no hace fit con el nombre del schema: únicamente a-Z y números son permitidos, 2 a 64 caracteres";
	        } elseif (empty($_POST['user_email'])) {
	            $this->errors[] = "Email no puede ser vacío";
	        } elseif (strlen($_POST['user_email']) > 64) {
	            $this->errors[] = "Email no puede ser más largo de 64 caracteres";
	        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
	            $this->errors[] = "El correo no tiene un válido formato";
	        } elseif (!empty($_POST['user_name'])
	            && strlen($_POST['user_name']) <= 64
	            && strlen($_POST['user_name']) >= 2
	            && preg_match('/^[a-zA-Z0-9\s]{2,64}$/i', $_POST['user_name'])
	            && !empty($_POST['user_email'])
	            && strlen($_POST['user_email']) <= 64
	            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
	            && !empty($_POST['user_password_new'])
	            && !empty($_POST['user_password_repeat'])
	            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
	        ) {
	            // create a database connection
	            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	            // change character set to utf8 and check it
	            if (!$this->db_connection->set_charset("utf8")) {
	                $this->errors[] = $this->db_connection->error;
	            }
	
	            // if no connection errors (= working database connection)
	            if (!$this->db_connection->connect_errno) {
	
	                // escaping, additionally removing everything that could be (html/javascript-) code
	                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
	                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));
	
	                $user_password = $_POST['user_password_new'];
	                
	                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
	                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
	                // PHP 5.3/5.4, by the password hashing compatibility library
	                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
	
	                // check if user or email address already exists
	                $sql = "SELECT email FROM users WHERE email=?";
                	$query_check_user_name = $this->db_connection->prepare($sql);
					$query_check_user_name->bind_param('s', $user_email);
					$query_check_user_name->execute();
					$query_check_user_name->bind_result($email);
					$query_check_user_name->fetch();
					$query_check_user_name->close();
	
	                if (!empty($email)) {
	                    $this->errors[] = "Disculpe, la dirección de correo ya ha sido tomada.";
	                } else {
	                    // write new user's data into database
	                    $sql = "INSERT INTO users (name, password_hash, email) VALUES (?, ?, ?)";
	                	$query_new_user_insert = $this->db_connection->prepare($sql);
						$query_new_user_insert->bind_param('sss', $user_name, $user_password_hash, $user_email);
						$query_new_user_insert->execute();
	
	                    // if user has been added successfully
	                    if ($query_new_user_insert) {
							require_once($_SERVER['DOCUMENT_ROOT'].'/php/classes/Login.php');
							require_once($_SERVER['DOCUMENT_ROOT'].'/php/helpers.php');
							
							$login = new Login(true);
							$login->doLogin($user_email, $user_password);
    						// Redirect('/', false);
	                        $this->messages[] = "Su cuenta ha sido creada exitosamente. Puede iniciar sesión";
	                        
	                    } else {
	                        $this->errors[] = "Disculpe, su registro ha fallado. Por favor retroceda e intente nuevamente.";
	                    }
	                }
	            } else {
	                $this->errors[] = "Disculpe, no hay conexión con la base de datos.";
	            }
	        } else {
	            $this->errors[] = "Un error desconocido ha ocurrido.";
	        }
	        $this->messages[] = 'CSRF check ha pasado.';
	      }
	      catch( Exception $e ){
	      	// CSRF attack detected
	        // $result = $e->getMessage() . ' Form ignored.';
	        $result = 'Token Inválido. Por favor <a href="/auth/signup.php">recarga la página</a>.';
	        $this->errors[] = $result;
	      }		  
    }
    private function updateUser()
    {
    	try
	    {
	        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
	        NoCSRF::check( 'csrf_token', $_POST, true, 60*10, true );	
	        $check = true;
	        
	        if (!empty($_POST['user_password_new']) || !empty($_POST['user_password_repeat']) || $_SESSION['need_change_password']) {
		        if (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
		            $this->errors[] = "Empty Password";
		        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
		            $this->errors[] = "La Contraseña y la contraseña repetida es la misma";
		        } elseif (strlen($_POST['user_password_new']) < 6) {
		            $this->errors[] = "La contraseña tiene un mínimo de 6 caracteres";
		        }
	        }
	        
	        if($this->errors)
	        	return;
	        
	        if(!$_SESSION['need_change_password']){
		        if (empty($_POST['user_email'])) {
		            $this->errors[] = "Email no puede ser vacío";
		            
		        } elseif (empty($_POST['user_name'])) {
		            $this->errors[] = "Usuario vacío";
		            
		        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
		    		$this->errors[] = "Nombre no puede tener menos de 2 caracteres y más de 64";
		    		
		        } elseif (!preg_match('/^[a-zA-Z\s]{2,64}$/i', $_POST['user_name'])) {
		            $this->errors[] = "Nombre no encaja con el esquema: únicamente a-Z y números son permitidos, 2 a 64 caracteres";
		        
		        } elseif (strlen($_POST['user_email']) > 64) {
		            $this->errors[] = "Email no puede ser mayor a 64 caracteres";
		        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
		            $this->errors[] = "Tu dirección de correo no se encuentra en un formato válido";
		        }
		        
	        	$check = !empty($_POST['user_email'])
	            && strlen($_POST['user_email']) <= 64
	            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
	            // && !empty($_POST['user_password_old'])
	            // && !empty($_POST['user_password_new'])
	            // && !empty($_POST['user_password_repeat'])
	            && ($_POST['user_password_new'] === $_POST['user_password_repeat']);
	        }
		        
	        if($this->errors)
	        	return;
		        
	        if ($check) {
	            // create a database connection
	            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	            // change character set to utf8 and check it
	            if (!$this->db_connection->set_charset("utf8")) {
	                $this->errors[] = $this->db_connection->error;
	            }
	
	            // if no connection errors (= working database connection)
	            if (!$this->db_connection->connect_errno) {
	            	
	                // escaping, additionally removing everything that could be (html/javascript-) code               
	                
					if($_SESSION['need_change_password']){
						$user_email = $_SESSION['user_email'];
						$user_name = $_SESSION['user_name'];
						$old_password  = null;
						
					} else {
						$user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));
						$user_name = $_POST['user_name'];
						$old_password  = $_POST['user_password_old'];
						
					}
					
	                // check if user or email address already exists
	                $sql = "SELECT email, password_hash FROM users WHERE email=?";
                	$query_check_user = $this->db_connection->prepare($sql);
					$query_check_user->bind_param('s', $_SESSION['user_email']);
					$query_check_user->execute();
					$query_check_user->bind_result($email, $password_hash);
					$query_check_user->fetch();
					$query_check_user->close();
	
	                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
	                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
	                // PHP 5.3/5.4, by the password hashing compatibility library
					if (empty($_POST['user_password_new']) && empty($_POST['user_password_repeat'])) 
						$user_password_hash = $password_hash;
					else
	                	$user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT);
	                	
					$user_password_old_hash = password_hash($old_password, PASSWORD_DEFAULT);
					
	                if (empty($email) || (!empty($email) && $email == $_SESSION['user_email'])) {
	                	if(!$_SESSION['need_change_password']){
	                		if(!password_verify($old_password, $password_hash)){
	                			$this->errors[] = "Disculpe, la contraseña antigua no coincide";
	                			return;
	                		}
	                	}
                		
	                	// write new user's data into database
	                    $sql = "UPDATE users
	                    		SET password_hash = ?, 
	                    			email = ?, 
	                    			name = ?
	                    		WHERE name <>'admin' AND email = ?";
	                    		
	                	$query_user_update = $this->db_connection->prepare($sql);
						$query_user_update->bind_param('ssss', $user_password_hash, $user_email, $user_name, $_SESSION['user_email']);
						$query_user_update->execute();
						$query_user_update->close();
	
	                    // if user has been added successfully
	                    if ($query_user_update) {
	                        $this->messages[] = "Tu cuenta ha sido actualizada de forma exitosa.";
							$_SESSION['user_email'] = $user_email;
							$_SESSION['user_name'] = $user_name;
	                        $_SESSION['need_change_password'] = 0;
	                        	
	                    } else {
	                        $this->errors[] = "Disculpe, la actualización falló. Por favor ve hacia atrás e intente nuevamente.";
	                    }
                    
	                } else {
	                    $this->errors[] = "Disculpe, el usuario / email ya ha sido tomado.";
	                }
	            } else {
	                $this->errors[] = "Disculpe, no hay conexión con la base de datos.";
	            }
	        } else {
	            $this->errors[] = "Un error desconocido ha ocurrido.";
	        }
		        
	        $this->messages[] = 'CSRF ha pasado.';
        
	    } catch( Exception $e ){
	      	// CSRF attack detected
	        // $result = $e->getMessage() . ' Form ignored.';
	        $result = 'Token Inválido por favor, <a href="/account">recargar la página</a>.';
	        $this->errors[] = $result;
	    }	
    }
}
