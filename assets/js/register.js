document.onreadystatechange = function () {
    if (document.readyState == "interactive") {
    	
        const hideLogin = document.getElementById('hide-login');
        const hideRegister = document.getElementById('hide-register');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        
        hideLogin.addEventListener('click', function() {
        	loginForm.classList.add('hide');
        	registerForm.classList.remove('hide');
        }, false);

       	hideRegister.addEventListener('click', function() {
        	loginForm.classList.remove('hide');
        	registerForm.classList.add('hide');
        }, false);
    }
}