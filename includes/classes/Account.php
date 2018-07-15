<?php 
	class Account {

		private $errorArray;

		public function __construct() {
			$this->errorArray = array();
		}

		public function register($registerUsername, $firstName, $lastName, $email, $confirmEmail, $registerPassword, $confirmPassword) {
			$this->validateUsername($registerUsername);
			$this->validateFirstName($firstName);
			$this->validateLastName($lastName);
			$this->validateEmails($email, $confirmEmail);
			$this->validatePasswords($registerPassword, $confirmPassword);

			if (empty($this->errorArray) == true) {
				// Insert into db
				return true;
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

		private function validateUsername($registerUsername) {
			if (strlen($registerUsername) < 5) {
				array_push($this->errorArray, Constants::$usernameTooFewCharsError);
				return;
			}
			if (strlen($registerUsername) > 25) {
				array_push($this->errorArray, Constants::$usernameTooManyCharsError);
				return;
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

			//TODO check that username hasn't been used
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