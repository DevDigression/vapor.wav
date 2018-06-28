<?php 
	class Account {

		private $errorArray;

		public function __construct() {
			$this->$errorArray = array();
		}

		public function register($registerUsername, $firstName, $lastName, $email, $confirmEmail, $registerPassword, $confirmPassword) {
			$this->validateUsername($registerUsername);
			$this->validateFirstName($firstName);
			$this->validateLastName($lastName);
			$this->validateEmails($email, $confirmEmail);
			$this->validatePasswords($registerPassword, $confirmPassword);
}
		}

		private function validateUsername($username) {
			if (strlen($username) < 5)) {
				array_push($this->errorArray, "Username must be at least 6 characters");
				return;
			}
			if (strlen($username > 25) {
				array_push($this->errorArray, "Username must be less than 25 characters");
				return;
			}

			//TODO: check if username exists
		}

		private function validateFirstName($firstName) {
			
		}

		private function validateLastName($lastName) {
			
		}

		private function validateEmails($email, $confirmEmail) {
			
		}

		private function validatePasswords($password, $confirmPassword) {
			
		}
	}

?>