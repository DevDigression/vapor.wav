<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");
	
	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($input) {
		if (isset($_POST[$input])) {
			echo $_POST[$input];
		}
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
			<p><?php echo $account->getError(Constants::$loginFailed); ?></p>
			<label for="login-username">Username</label>
			<input id="login-username" name="login-username" type="text" placeholder="username" required>
			<label for="login-password">Password</label>
			<input id="login-password" name="login-password" type="password" placeholder="password" required>
			<button type="submit" name="login-button">Login</button>
		</form>
		
		<form id="register-form" action="register.php" method="POST">
			<h2>Create a New Account</h2>
			<p><?php echo $account->getError(Constants::$usernameAlreadyExistsError); ?></p>
			<p><?php echo $account->getError(Constants::$usernameTooFewCharsError); ?></p>
			<p><?php echo $account->getError(Constants::$usernameTooManyCharsError); ?></p>
			<label for="register-username">Username</label>
			<input id="register-username" value="<?php getInputValue('register-username') ?>" name="register-username" type="text" placeholder="username" required>
			<p><?php echo $account->getError(Constants::$firstnameTooFewCharsError); ?></p>
			<p><?php echo $account->getError(Constants::$firstnameTooManyCharsError); ?></p>
			<label for="first-name">First Name</label>
			<input id="first-name" value="<?php getInputValue('first-name') ?>" name="first-name" type="text" placeholder="First Name" required>
			<p><?php echo $account->getError(Constants::$lastnameTooFewCharsError); ?></p>
			<p><?php echo $account->getError(Constants::$lastnameTooManyCharsError); ?></p>
			<label for="last-name">Last Name</label>
			<input id="last-name" value="<?php getInputValue('last-name') ?>" name="last-name" type="text" placeholder="last-name" required>
			<p><?php echo $account->getError(Constants::$emailAlreadyExistsError); ?></p>
			<p><?php echo $account->getError(Constants::$emailInvalidError); ?></p>
			<label for="email">Email</label>
			<input id="email" value="<?php getInputValue('email') ?>" name="email" type="email" placeholder="email" required>
			<p><?php echo $account->getError(Constants::$emailMatchError); ?></p>
			<label for="confirm-email">Confirm Email</label>
			<input id="confirm-email" value="<?php getInputValue('confirm-email') ?>" name="confirm-email" type="email" placeholder="email" required>
			<p><?php echo $account->getError(Constants::$passwordFormatError); ?></p>
			<p><?php echo $account->getError(Constants::$passwordTooFewCharsError); ?></p>
			<p><?php echo $account->getError(Constants::$passwordTooManyCharsError); ?></p>
			<label for="register-password">Password</label>
			<input id="register-password" value="<?php getInputValue('register-password') ?>" name="register-password" type="password" placeholder="password" required>
			<p><?php echo $account->getError(Constants::$passwordMatchError); ?></p>
			<label for="confirm-password">Confirm Password</label>
			<input id="confirm-password" value="<?php getInputValue('confirm-password') ?>" name="confirm-password" type="password" placeholder="password" required>
			<button type="submit" name="register-button">Register</button>
		</form>
	</div>
</body>
</html>