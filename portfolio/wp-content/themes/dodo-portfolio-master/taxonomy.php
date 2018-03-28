<?php get_header(); ?>

<main class="content">	

	<h1 class="page-title"><?php single_cat_title(); ?></h1>

	<?php //The Loop Begins Here
	if( have_posts() ):
		while( have_posts() ):
			the_post(); 
			?>
			<article <?php post_class('clearfix'); ?>>

				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'medium' ); ?>
				</a>

				<h2 class="entry-title"> 
					<a href="<?php the_permalink(); ?>"> 
						<?php the_title(); ?> 
					</a>
				</h2>				
				
			</article>
			<!-- end .post -->

			<?php 
		endwhile;
	else:
		echo 'Sorry, there are no posts to show';
	endif; 
			//end of The Loop
	?>

	<div class="pagination">
		<?php dodo_pagination(); ?>
	</div>

	
</main>
<!-- end #content -->

<?php get_sidebar('portfolio'); //include sidebar-portfolio.php ?>		

<?php get_footer(); //include footer.php ?>