<?php require_once("resources/views/layouts/header.php")?>

<main class="content">

    <article>

    <div class="successes">
		<?php 
		if(isset($_SESSION['login_success'])){?>
			<p><?php echo $_SESSION['login_success'];?></p>
		<?php } ?>

		<?php if(isset($_SESSION['user_create_success'])){?>
			<p><?php echo $_SESSION['user_create_success'];?></p>
		<?php } ?>

		<?php if(isset($_SESSION['user_logout'])){?>
			<p><?php echo $_SESSION['user_logout'];?></p>
		<?php } ?>

	</div>

	<div class="errors">
		<?php if(isset($_SESSION['access_error'])){?>
			<p><?php echo $_SESSION['access_error'];?></p>
		<?php } ?>
	</div>

	<?php
	unset($_SESSION['login_success']);
	unset($_SESSION['user_create_success']);
	unset($_SESSION['user_logout']);
	unset($_SESSION['access_error']);
	 ?>

	 <div class="category_articles">
		 	<?php foreach ($pag_data  as $article) {?>

		 		<a href="<?php echo URL_MAIN; ?>article/<?php echo $article->id;  ?>">
			 		<div class="category_article">

			 			<div class="cat_image">
			 				<img class="cat_articles_images" src="<?php echo $article->image ?>">
			 			</div>
			 			
			 			<div class="cat_title">
			 				  <p><?php echo $article->title;  ?></p>
			 			</div>

					    
				    </div>
			    </a>
	  		<?php } ?>
	 </div>

	 <p><?php echo $pagination; ?></p>
    
        
    </article>




    

    <?php require_once("resources/views/layouts/aside.php")?>

</main>

<?php require_once("resources/views/layouts/footer.php")?>




