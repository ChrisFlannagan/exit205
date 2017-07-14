<?php

/**
 * Template Name: Interactive Map of Beer Places
 */

get_header();

?>

	<div class="container">
		<div class="row">
			<div id="primary" class="content-area col-md-12">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'page' ); ?>

                        <div id="beer_map_id">

							<?php get_template_part( 'templates/content', 'map' ); ?>

                        </div>

					<?php endwhile; // end of the loop. ?>

				</main><!-- /.site-main -->
			</div><!-- /.content-area -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
<?php get_footer(); ?>