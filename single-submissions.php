<?php 
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
					<form method="POST">
						
<?php
						if ($message != null) {
?>
						<p class="info"><?php echo $message; ?></p>
<?php
						}
						else {
?>
						<p class="info">Vote for a Video:</p>
<?php
						}


						while (have_posts()) {
							the_post();
							$title = get_the_title();
							$slug = $post->post_name;
							$videoid = get_post_meta($post->ID, 'kt-form-video', true);
							$donations = get_post_meta($post->ID, 'kt-form-donations', true);
							$link = $post->guid;

?>	
						<article class="video" data-title="<?php echo $slug; ?>">
							<a href="<?php echo $link; ?>"><h3><?php echo $title; ?></h3></a>
							<iframe src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0" allowfullscreen></iframe>
							<input type="checkbox" name="vote-form-video[]" value="<?php echo $slug; ?>" id="vote-form-<?php echo $slug; ?>">
							<p>Donations: $<?php echo $donations; ?></p>
						</article>

<?php 					}
?>
						<div class="submit">
							<label for="email">E-mail Address: </label><input class="email" type="email" name="vote-form-email">
							<input type="submit" name="vote-form-submit" value="Cast Your Vote">
						</div>
					</form>
				</section> 
			</div>

<?php get_footer(); ?>