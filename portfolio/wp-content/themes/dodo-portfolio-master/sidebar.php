<aside class="sidebar">

	<?php 
	//display a widget area if it exists
	if( ! dynamic_sidebar( 'Blog Sidebar' ) ): ?>

	<section id="categories" class="widget">
		<h3 class="widget-title"> Categories </h3>
		<ul>
			<?php 
			//show the 15 most used categories
			wp_list_categories( array(
				'title_li' 		=> '',
				'show_count' 	=> 1,
				'orderby' 		=> 'count',
				'order'			=> 'DESC',
				'number'		=> 15,
			) ); ?>
		</ul>
	</section>
	<section id="archives" class="widget">
		<h3 class="widget-title"> Archives </h3>
		<ul>
			<?php wp_get_archives( array(
				'type' => 'yearly',
			) ); ?>
		</ul>
	</section>
	<section id="tags" class="widget">
		<h3 class="widget-title"> Tags </h3>
		
		<?php wp_tag_cloud( array(
			'smallest' => 1,
			'largest' => 1,
			'unit' => 'em',
			'format' => 'list', //flat by default
			'number' => 15,
			'orderby' => 'count',
			'order' => 'DESC',
		) ); ?>

	</section>
	<section id="meta" class="widget">
		<h3 class="widget-title"> Meta </h3>
		<ul>
			<?php wp_register(); //register button or admin button or nothing ?>
			<li><?php wp_loginout();  //login or logout ?></li>
		</ul>
	</section>

	<?php 
	endif; //end of widget area fallback ?>
</aside>
		<!-- end #sidebar -->