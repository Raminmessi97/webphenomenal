<?php require_once("resources/views/layouts/header.php")?>

<main class="content">

    <article>
				
	<div class="one_article_info">
	 		<div class="nav_to_article">
					<a href="<?php echo URL_MAIN;?>">Главная страница</a> 
					&raquo;
					<a href="<?php echo URL_MAIN; ?>category/<?php echo $article_category->route_name; ?>/">
                        <?php echo $article_category->name;?>
                    </a>
				</div>
	 </div>

	 		 
	 </div>
	 			
	 <div class="one_article">

	 	<div class="one_article_title">
	 		<p><?php echo $article->title; ?></p>
	 	</div>

	 	<div class="one_article_text ">
	 		<p><?php echo $article->text; ?></p>
	 	</div>

	 	<div class="one_article_upd_date">
	 			<p>Статья обновлена:<?php echo $article->updated_at;?></p>
	 		</div>

	 </div>

	 <div class="article_with_one_theme">
	 	
	 	<div class="read_sim_art">
	 		<p>Читайте похожие статьи</p>
	 	</div>


	 	<div class="similar_articles_body">
	 	<?php foreach($similar_articles as $similar_article){?>
	 		<a href="<?php echo URL_MAIN.'article/'.$similar_article->id;?>">
		 		<div class="similar_articles">
		 			<div class="similar_article_image">
		 				<img src="<?php echo $similar_article->image;?>"/>
		 			</div>

		 			<div class="similar_article_title">
		 				<?php echo $similar_article->title;?>
		 			</div>
		 		</div>
	 		</a>
	 	<?php } ?>
	 	</div>

	 </div>

	 <div class="one_article_comment">
	 	 <?php if(isset($_COOKIE['logged_user'])){?>
			<div id="user-add-comment"></div> 	 
	 	 <?php }else{?>
	 	 	 <a href="<?php echo URL_MAIN; ?>login" id="user-login">Чтобы оставить комментарий,Войдите</a>
	 	 <?php } ?>

	 	 <div id="show-comment"></div>
	
	 </div>
	 
		

	</article>

    <?php require_once("resources/views/layouts/aside.php")?>

</main>


<?php require_once("resources/views/layouts/footer.php")?>




