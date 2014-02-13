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
						<h2 class="info"><?php echo $message; ?></h2>
<?php
						}
						else {
?>
						<h2 class="info">Vote for a Video:</h2>
<?php
						}


						while (have_posts()) {
							the_post();
							$title = get_the_title();
							$videoid = get_post_meta($post->ID, 'kt-form-video', true);
							$link = $post->guid;
							$url = get_post_meta($post->ID, 'kt-form-url', true);
							$donations = intval(get_post_meta($post->ID, 'kt-form-donations', true));
							$votes = intval(get_post_meta($post->ID, 'kt-form-votes', true));

							$total = intval($votes + $donations / 10);

?>	
						<script type="text/javascript">
							var shareURL = window.location.href;
							var shareURL = "https://www.facebook.com/sharer/sharer.php?u="+shareURL;
							var desiredText = "Share on Facebook";
						</script>

						<article class="video">
							<div class="video-container">
								<iframe src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0" allowfullscreen></iframe>
								<input type="hidden" name="vote-form-video" value="<?php echo $post->ID; ?>" checked>
								<div class="votes">
									<p><a href="<?php echo $url; ?>"target=_blank><span class="label">Donations: </span>$<?php echo $donations; ?></a></p>
									<p class="vote-total"><span class="label">Total: </span><span class="total"><?php echo $total; ?></span></p>
									<p><span class="label">Votes: </span><?php echo $votes; ?></p>
								</div>
							</div>
							<div class="video-content">
								<div class="video-info">
									<h3><?php echo $title; ?></h3>
									<p><?php echo get_the_content(); ?></p>
								</div>
								<div class="submit">
									<label for="email">E-mail Address: </label><input class="email" type="email" name="vote-form-email">
									<input type="submit" name="vote-form-submit" value="Vote">
									<script type="text/javascript">
										document.write('<a target="_blank" href="'+shareURL+'">'+desiredText+'</a>');
									</script>
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