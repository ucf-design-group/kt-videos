<?php 
$include = "functions/vote-handler.php";
include($include);

get_header(); ?>

			<div class="content-area">
				<section class="single-video">
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
							$videoid = get_post_meta($post->ID, 'kt-form-video', true);
							$link = $post->guid;

							$donations = intval(get_post_meta($post->ID, 'kt-form-donations', true));
							$votes = intval(get_post_meta($post->ID, 'kt-form-votes', true));

							$total = intval($votes + $donations / 10);

?>	
						<article class="video">
							<div class="video-container">
								<iframe src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0" allowfullscreen></iframe>
								<input type="hidden" name="vote-form-video" value="<?php echo $post->ID; ?>" checked>
							</div>
							<div class="video-content">
								<div class="video-info">
									<a href="<?php echo $link; ?>"><h3><?php echo $title; ?></h3></a>
									<p><?php echo get_the_content(); ?></p>
								</div>
								<div class="votes">
									<p><span>Donations: </span>$<?php echo $donations; ?></p>
									<p class="vote-total"><span>Total: </span><?php echo $total; ?></p>
									<p><span>Votes: </span><?php echo $votes; ?></p>
								</div>
								<div class="submit">
									<label for="email">E-mail Address:</label><input class="email" type="email" name="vote-form-email">
									<input type="submit" name="vote-form-submit" value="Vote For This Video">
								</div>
							</div>
						</article>

<?php 					}
?>
					</form>
				</section> 
				<section class="slider">
					<div class="gallery-wrapper">
				      <div class="gallery-mask">
				        <ul id="gallery-ul">
				        </ul>
				      </div>
				      <div class="leftbtn">
				        <div class="leftbtn-inner"></div>
				      </div>
				      
				      <div class="rightbtn">
				        <div class="rightbtn-inner"></div>
				      </div>
  					</div>
  				</section>
			</div>
<?php get_footer(); ?>
<?php include 'slider.php'; ?>