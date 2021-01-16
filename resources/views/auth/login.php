<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo URL_MAIN; ?>node_modules/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo URL_MAIN; ?>resources/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">

</head>
<body>
<div class="login">
	
	<div class="errors">
		<?php 
		if(isset($_SESSION['login_error'])){
			$errors = $_SESSION['login_error'];
				if(is_array($errors)){
					foreach($_SESSION['login_error'] as $error) {
						?>
						<li><?php echo $error;  ?></li>

						<?php
					}
				}
				else{?>
					<p><?php echo $errors;  ?></p>
				<?php
			}
		}
		 ?>
		  <span class="close_errors">&times;</span>
	</div>


	<?php
	unset($_SESSION['login_error']);
	 ?>

	<div class="login-register-mainpage">
		<div class="logo-of-site">
                   <a href="<?php echo URL_MAIN;?>">WebPhenomenal</a>
		</div>
	</div>

	<div class="div-register-form">
			<form action="login/check" class="register-form" method="POST">
				<h2>Sign In</h2>
				<input type="hidden" required="required" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
				<label for="login_email">Username</label>
				<input type="email" required="required" name="email" id="login_email" >
				<label for="login_password">Password</label>
				<input type="password" required="required"  name="password" id="login_password"/>
				<input type="submit" class="register-form-submit" value="Login" id="user-login"/>
				<p><a href="<?php echo URL_MAIN; ?>register">Create Account</a></p>
			</form>
	</div>
		
</div>
	
</body>

  <script src="<?php echo URL_MAIN; ?>resources/bundle.js"></script>

</html>