<?php /* Template Name: Vote for a Video */

$include = "functions/vote-handler.php";
include($include);

get_header(); ?>

			<div class="content-area">
				<div class="main"> 
					<?php
					while (have_posts()) {
						the_post();
						get_template_part( 'content', 'page' );
					} ?>
				</div>


				<section class="videos">
						
<?php
					if ($message != null) {
?>
					<h2 class="info"><?php echo $message; ?></h2>
<?php
					}
					else {
?>
					<h2 class="info">Vote for a Video or Click the Title for More Information:</h2>
<?php
					}


					$videoloop = new WP_QUERY(array('post_type' => 'submissions', 'posts_per_page' => -1, 'orderby' =>'meta_value', 'order' => 'ASC', 'meta_key' => 'kt-form-order'));
					while ($videoloop->have_posts()) {
						$videoloop->the_post();
						$title = get_the_title();
						$videoid = get_post_meta($post->ID, 'kt-form-video', true);
						$link = $post->guid;
						$url = get_post_meta($post->ID, 'kt-form-url', true);

						$donations = intval(get_post_meta($post->ID, 'kt-form-donations', true));
						$votes = intval(get_post_meta($post->ID, 'kt-form-votes', true));

						$total = intval($votes + $donations);

?>	
					<article class="video">
						<form method="POST">
							<a href="<?php echo $link; ?>"><h3><?php echo $title; ?></h3></a>
							<iframe src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0" allowfullscreen></iframe>
							<input type="hidden" name="vote-form-video" value="<?php echo $post->ID; ?>">
							<div class ="votes">	
								<p><a href="<?php echo $url; ?>"target=_blank><span class="label">Donations: </span>$<?php echo $donations; ?></a></p>
								<p class="vote-total"><span class="label">Total: </span><span class="total"><?php echo $total; ?></span></p>
								<p><span class="label">Votes: </span><?php echo $votes; ?></p>
							</div>
							<div class="submit">
								<label for="email">E-mail Address: </label><input class="email" type="email" name="vote-form-email">
								<input type="submit" name="vote-form-submit" value="Vote for this Video">
							</div>
						</form>
					</article>

<?php 					}
?>
				</section> 



			</div>

<?php get_footer(); ?>