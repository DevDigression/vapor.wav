<?php
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");
	
	$account = new Account();

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");
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
			<p><?php echo $account->getError("Username must be at least 5 characters"); ?></p>
			<p><?php echo $account->getError("Username must be less than 26 characters"); ?></p>
			<label for="register-username">Username</label>
			<input id="register-username" name="register-username" type="text" placeholder="username" required>
			<p><?php echo $account->getError("First name must be at least 2 characters"); ?></p>
			<p><?php echo $account->getError("First name must be less than 26 characters"); ?></p>
			<label for="first-name">First Name</label>
			<input id="first-name" name="first-name" type="text" placeholder="First Name" required>
			<p><?php echo $account->getError("Last name must be at least 2 characters"); ?></p>
			<p><?php echo $account->getError("Last name must be less than 26 characters"); ?></p>
			<label for="last-name">Last Name</label>
			<input id="last-name" name="last-name" type="text" placeholder="last-name" required>
			<p><?php echo $account->getError("Invalid email"); ?></p>
			<label for="email">Email</label>
			<input id="email" name="email" type="email" placeholder="email" required>
			<p><?php echo $account->getError("Emails do not match"); ?></p>
			<label for="confirm-email">Confirm Email</label>
			<input id="confirm-email" name="confirm-email" type="email" placeholder="email" required>
			<p><?php echo $account->getError("Invalid password. Password can only contain letters and numbers"); ?></p>
			<p><?php echo $account->getError("Password must be at least 5 characters"); ?></p>
			<p><?php echo $account->getError("Password must be no more than 30 characters"); ?></p>
			<label for="register-password">Password</label>
			<input id="register-password" name="register-password" type="password" placeholder="password" required>
			<p><?php echo $account->getError("Passwords do not match"); ?></p>
			<label for="confirm-password">Confirm Password</label>
			<input id="confirm-password" name="confirm-password" type="password" placeholder="password" required>
			<button type="submit" name="register-button">Register</button>
		</form>
	</div>
</body>
</html>