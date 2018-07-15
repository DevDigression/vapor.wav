<?php 
	class Account {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}

		public function login($username, $password) {
			$password = md5($password);
			$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username' AND password='$password'");

			if (mysqli_num_rows($query) == 1) {
				return true;
			} else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function register($registerUsername, $firstName, $lastName, $email, $confirmEmail, $registerPassword, $confirmPassword) {
			$this->validateUsername($registerUsername);
			$this->validateFirstName($firstName);
			$this->validateLastName($lastName);
			$this->validateEmails($email, $confirmEmail);
			$this->validatePasswords($registerPassword, $confirmPassword);

			if (empty($this->errorArray) == true) {
				// Insert into db
				return $this->insertUserDetails($registerUsername, $firstName, $lastName, $email, $registerPassword);
			} else {
				return false;
			}
		}

		public function getError($error) {
			if (!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='error-message'>$error</span>";
		}

		private function insertUserDetails($registerUsername, $firstName, $lastName, $email, $registerPassword) {
			$encryptedPassword = md5($registerPassword);
			$profilePhoto = "assets/images/profile-photos/floral_shop.png";
			$date = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$registerUsername', '$firstName', '$lastName', '$email', '$encryptedPassword', '$date', '$profilePhoto')");

			return $result;
		}

		private function validateUsername($registerUsername) {
			if (strlen($registerUsername) < 5) {
				array_push($this->errorArray, Constants::$usernameTooFewCharsError);
				return;
			}
			if (strlen($registerUsername) > 25) {
				array_push($this->errorArray, Constants::$usernameTooManyCharsError);
				return;
			}

			$validateUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$registerUsername'");

			if (mysqli_num_rows($validateUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$usernameAlreadyExistsError);
			}
		}

		private function validateFirstName($firstName) {
			if (strlen($firstName) < 2) {
				array_push($this->errorArray, Constants::$firstnameTooFewCharsError);
				return;
			}
			if (strlen($firstName) > 25) {
				array_push($this->errorArray, Constants::$firstnameTooManyCharsError);
				return;
			}
		}

		private function validateLastName($lastName) {
			if (strlen($lastName) < 2) {
				array_push($this->errorArray, Constants::$lastnameTooFewCharsError);
				return;
			}
			if (strlen($lastName) > 25) {
				array_push($this->errorArray, Constants::$lastnameTooManyCharsError);
				return;
			}	
		}

		private function validateEmails($email, $confirmEmail) {
			if ($email != $confirmEmail) {
				array_push($this->errorArray, Constants::$emailMatchError);
				return;
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalidError);
				return;				
			}

			$validateEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$email'");

			if (mysqli_num_rows($validateEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailAlreadyExistsError);
			}
		}

		private function validatePasswords($password, $confirmPassword) {
			if ($password != $confirmPassword) {
				array_push($this->errorArray, Constants::$passwordMatchError);
				return;
			}	

			if (preg_match('/[^A-Za-z0-9]/', $password)) {
				array_push($this->errorArray, Constants::$passwordInvalidError);
				return;				
			}

			if (strlen($password) < 5) {
				array_push($this->errorArray, Constants::$passwordTooFewCharsError);
				return;
			}
			if (strlen($password) > 30) {
				array_push($this->errorArray, Constants::$passwordTooManyCharsError);
				return;
			}	
		}
	}

?>