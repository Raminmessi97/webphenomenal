<?php require_once("resources/views/layouts/header.php")?>

<main class="content">

    <article>
			
		<div class="errors">
		<?php 
		if(isset($_SESSION['article_create_error'])){
			$errors = $_SESSION['article_create_error'];
				if(is_array($errors)){
					foreach($_SESSION['article_create_error'] as $error) {
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
	</div>

	<div class="successes">
		<?php 
		if(isset($_SESSION['article_create_success'])){?>
			<p><?php echo $_SESSION['article_create_success'];?></p>
		<?php } ?>

	</div>

		<?php
	unset($_SESSION['article_create_success']);
	unset($_SESSION['article_create_error']);
	 ?>



	 <div id="new_article_create"></div>
	 
		<form action="<?php echo URL_MAIN ?>articles/store" method="post">
			<input type="hidden" required="required" name="csrf_token" value="<?php echo $csrf_token; ?>" >
			<input type="textarea" name="text" placeholder="Text of article" required="required">
			<input type="submit" value="Create">
		</form>

	</article>

    <?php require_once("resources/views/layouts/aside.php")?>

</main>


<?php require_once("resources/views/layouts/footer.php")?>




