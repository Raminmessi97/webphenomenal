<?php require_once("resources/views/layouts/header.php")?>

<main class="content">

    <article>

    	<div class="nw-cats">
    			<?php foreach($new_categories as $new_category): ?>
    				<div class="nw-cat">
    					<div class="nw-cat-img">
    						<img src="<?php echo $new_category->img; ?>" class="nw-cat-inner-img">
    					</div>

    					<div class="nw-cat-name">
    						<p><?php echo $new_category->name;?></p>
    					</div>
    				</div>
		    	<?php endforeach; ?>
    	</div>

        
    </article>




    

    <?php require_once("resources/views/layouts/aside.php")?>

</main>

<?php require_once("resources/views/layouts/footer.php")?>




