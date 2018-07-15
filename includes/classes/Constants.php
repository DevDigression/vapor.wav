<?php

class Constants {
	public static $passwordMatchError = "Passwords do not match";	
	public static $passwordFormatError = "Invalid password. Password can only contain letters and numbers";
	public static $passwordTooFewCharsError = "Password must be at least 5 characters";
	public static $passwordTooManyCharsError = "Password must be no more than 30 characters";
	public static $emailAlreadyExistsError = "Email has already been used";
	public static $emailMatchError = "Emails do not match";
	public static $emailInvalidError = "Invalid email";
	public static $usernameAlreadyExistsError = "Username already exists";
	public static $usernameTooFewCharsError = "Username must be at least 5 characters";
	public static $usernameTooManyCharsError = "Username must be less than 26 characters";
	public static $firstnameTooFewCharsError = "First name must be at least 2 characters";
	public static $firstnameTooManyCharsError = "First name must be less than 26 characters";
	public static $lastnameTooFewCharsError = "Last name must be at least 2 characters";
	public static $lastnameTooManyCharsError = "Last name must be less than 26 characters";

	public static $loginFailed = "Incorrect username or password";
}

?>