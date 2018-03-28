<?php get_header(); //includes header.php ?>

<main class="content">

	<?php 
	//THE LOOP. this is the same on every template
	if( have_posts() ): 
		while( have_posts() ): the_post(); ?>
	<article class="post">
		<h2 class="entry-title"> 
			<a href="<?php the_permalink(); ?>"> 
				<?php the_title(); ?> 
			</a>
		</h2>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<div class="postmeta">
			<span class="thumbnauil"><?php the_post_thumbnail() ?></span>
			<span class="author">by: <?php the_author(); ?> </span>
			<span class="date"> <?php the_date(); ?> </span>
			<span class="num-comments"> <?php comments_number(); ?> </span>
			<span class="categories"> 
				<?php the_category(); ?>
			</span>
			<span class="tags"><?php the_tags(); ?></span>
		</div>
		<!-- end .postmeta -->
	</article>
	<!-- end .post -->

	<?php comments_template(); //show comment list and comment form ?>

<?php 
	endwhile;
else:
	echo 'Sorry, no posts found';	
endif; 
?>
</main>
<!-- end #content -->


<?php get_sidebar(); //include sidebar.php ?>

<?php get_footer(); //include footer.php ?>