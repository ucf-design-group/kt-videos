<?php /* Template Name: Home */

get_header(); ?>

			<div class="content-area">
				<div class="main"> 
					<?php
					while (have_posts()) {
						the_post();
						get_template_part( 'content', 'page' );
					} ?>
				</div>
				<div class="main2">
					<div class="image"></div>
				</div>
			</div>
			<!-- Complete credit for the beautiful timer: http://codepen.io/mel/details/nleBw -->
			<div class="countdown-timer">
				<div id="days"></div>
				<div id="hours"></div>
				<div id="minutes"></div>
				<div id="seconds"></div>
				<h1>Until Knight-Thon</h1>
			</div>
<?php get_footer(); ?>