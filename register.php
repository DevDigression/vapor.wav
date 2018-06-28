<?php

function sanitizeFormUsername($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		return $inputText;
}

function sanitizeFormString($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		$inputText = ucfirst(strtolower($inputText));
		return $inputText;
}

function sanitizeFormPassword($inputText) {
		$inputText = strip_tags($inputText);
		
		return $inputText;
}

if (isset($_POST['login-button'])) {
		
}

if (isset($_POST['register-button'])) {
		$registerUsername = sanitizeFormUsername($_POST['register-username']);

		$firstName = sanitizeFormString($_POST['first-name']);

		$lastName = sanitizeFormString($_POST['last-name']);

		$email = sanitizeFormString($_POST['email']);

		$confirmEmail = sanitizeFormString($_POST['confirm-email']);

		$registerPassword = sanitizeFormPassword($_POST['register-password']);

		$confirmPassword = sanitizeFormPassword($_POST['confirm-password']);
}

?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
</head>
<body>
	<div id="input-form-container">
		<form id="login-form" action="register.php" method="POST">
			<h2>Login to Your Account</h2>
			<label for="login-username">Username</label>
			<input id="login-username" name="login-username" type="text" placeholder="username" required>
			<label for="login-password">Password</label>
			<input id="login-password" name="login-password" type="password" placeholder="password" required>
			<button type="submit" name="login-button">Login</button>
		</form>
		
		<form id="register-form" action="register.php" method="POST">
			<h2>Create a New Account</h2>
			<label for="register-username">Username</label>
			<input id="register-username" name="register-username" type="text" placeholder="username" required>
			<label for="first-name">First Name</label>
			<input id="first-name" name="first-name" type="text" placeholder="First Name" required>
			<label for="last-name">Last Name</label>
			<input id="last-name" name="last-name" type="text" placeholder="last-name" required>
			<label for="email">Email</label>
			<input id="email" name="email" type="email" placeholder="email" required>
			<label for="confirm-email">Confirm Email</label>
			<input id="confirm-email" name="confirm-email" type="email" placeholder="email" required>
			<label for="register-password">Password</label>
			<input id="register-password" name="register-password" type="password" placeholder="password" required>
			<label for="confirm-password">Confirm Password</label>
			<input id="confirm-password" name="confirm-password" type="password" placeholder="password" required>
			<button type="submit" name="register-button">Register</button>
		</form>
	</div>
</body>
</html>