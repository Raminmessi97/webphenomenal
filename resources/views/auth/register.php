<!DOCTYPE html>
<html>
<head>
    <title>Welcome homme page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo URL_MAIN; ?>node_modules/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo URL_MAIN; ?>resources/css/main.css">
      <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">

</head>
<body>
<div class="login">
	
	<div class="errors">
		<?php 
		if(isset($_SESSION['user_create_errors'])){
			$errors = $_SESSION['user_create_errors'];
				if(is_array($errors)){
					foreach($_SESSION['user_create_errors'] as $error) {
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
		unset($_SESSION['user_create_errors']);
	?>


	<div class="login-register-mainpage">
		<div class="logo-of-site">
                   <a href="<?php echo URL_MAIN;?>">WebPhenomenal</a>
		</div>
	</div>

	<div class="div-register-form">
			<form action="register/create" class="register-form" method="POST">
				<h2>Sign Up</h2>
				<input type="hidden" required="required" name="csrf_token" value="<?php echo $csrf_token; ?>" >
				<label for="register_username">Username</label>
				<input  type="text" required="required" name="name" id="register_username" >
				<label for="register_email">Email address</label>
				<input type="email" required="required" name="email" id="register_email">
				<label for="register_password">Password</label>
				<input type="password" required="required"  name="password" id="register_password">
				<input type="submit" class="register-form-submit" value="Create">
				<p>Есть аккаунт? <a href="<?php echo URL_MAIN; ?>login">Авторизоваться</a></p>
			</form>
	</div>
		
</div>
	
</body>

  <script src="<?php echo URL_MAIN; ?>resources/bundle.js"></script>

</html>