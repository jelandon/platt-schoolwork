<?php get_header(); //include header.php ?>

		<main class="content">
			<?php //The Loop begins here
				if( have_posts() ):
					while( have_posts() ):
						the_post();
			 ?>
			<article class="post">
				<h2 class="entry-title"> 
					<a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a>
				</h2>
				<div class="entry-content"><?php the_content(); ?>
				</div>
				<!-- end .postmeta -->
			</article>
			<!-- end .post -->


		<?php
			endwhile;
			else:
				echo 'Sorry, there are no posts to show';
			endif; //end of The Loop
		?>
		</main>
		<!-- end #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>