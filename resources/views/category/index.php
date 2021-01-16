<?php require_once("resources/views/layouts/header.php")?>

<main class="content">

    <article>
    	<?php if(is_array($data)){ ?>
			<div class="category_articles">
		 	<?php foreach ($data  as $article) {?>

			 		<div class="category_article">

				 			<div class="cat_title">
			 				  <a href="<?php echo URL_MAIN; ?>article/<?php echo $article->id;  ?>">
			 				  	<p><?php echo $article->title;  ?></p>
			 				  </a>
			 				</div>


				 			<div class="cat_text">
				 				<p><?php echo $article->title_text; ?></p>
				 			</div>

				 			<div class="cat_image">
				 				<img class="cat_articles_images" src="<?php echo $article->image ?>">
				 			</div>

				 			<div class="article-add-info">
				 			  <a href="<?php echo URL_MAIN; ?>article/<?php echo $article->id;  ?>">
			 				  	Читать далее&#8594;
			 				  </a>
			 				  <p>Опубликовано:<?php echo $article->created_at;?></p>

				 			</div>

				 			

				 		<hr>
					    
				    </div>
	  		<?php } ?>
	 </div>

	 <p><?php echo $links; ?></p>


	<?php } ?>
    
        
    </article>

    <?php require_once("resources/views/layouts/aside.php")?>

</main>

<?php require_once("resources/views/layouts/footer.php")?>




