<aside class="sidebar">
	<section class="widget">
		<h3>Filter my Portfolio:</h3>
		<ul>
			<?php 
			//display all terms in the "work_type" taxonomy
			wp_list_categories( array(
				'taxonomy' => 'type_of_work',
				'title_li' => '',
			) ); ?>
		</ul>
	</section>

</aside>