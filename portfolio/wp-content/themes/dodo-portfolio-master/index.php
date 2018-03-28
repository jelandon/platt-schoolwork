<?php get_header(); ?>

<main class="content">	

	<?php //The Loop Begins Here
	if( have_posts() ):
		while( have_posts() ):
			the_post(); 
			?>
			<article <?php post_class('clearfix'); ?>>

				<?php the_post_thumbnail( 'medium' ); ?>

				<h2 class="entry-title"> 
					<a href="<?php the_permalink(); ?>"> 
						<?php the_title(); ?> 
					</a>
				</h2>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
				<div class="postmeta">
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

<?php get_sidebar(); //include sidebar.php ?>		

<?php get_footer(); //include footer.php ?>