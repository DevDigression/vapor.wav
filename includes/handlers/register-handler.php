<?php

function sanitizeFormUsername($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		return $inputText;
}

function sanitizeFormPassword($inputText) {
		$inputText = strip_tags($inputText);
		
		return $inputText;
}

function sanitizeFormString($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		$inputText = ucfirst(strtolower($inputText));
		return $inputText;
}

if (isset($_POST['register-button'])) {
		$registerUsername = sanitizeFormUsername($_POST['register-username']);
		$firstName = sanitizeFormString($_POST['first-name']);
		$lastName = sanitizeFormString($_POST['last-name']);
		$email = sanitizeFormString($_POST['email']);
		$confirmEmail = sanitizeFormString($_POST['confirm-email']);
		$registerPassword = sanitizeFormPassword($_POST['register-password']);
		$confirmPassword = sanitizeFormPassword($_POST['confirm-password']);

		$successfulRegister = $account->register($registerUsername, $firstName, $lastName, $email, $confirmEmail, $registerPassword, $confirmPassword);

		if ($successfulRegister) {
			$_SESSION['userLoggedIn'] = $registerUsername;
			header("Location: index.php");
		}
}

?>