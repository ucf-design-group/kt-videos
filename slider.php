<?php
//WHILE LOOP - GET VIDEOID -- GET HREF
$videoloop = new WP_QUERY(array('post_type' => 'submissions', 'posts_per_page' => -1, 'orderby' =>'meta_value', 'order' => 'ASC', 'meta_key' => 'kt-form-order'));
while ($videoloop->have_posts()) {
$videoloop->the_post();
$videoid = get_post_meta($post->ID, 'kt-form-video', true);
$link = $post->guid;
?>
<script type="text/javascript">
	var videoSrcID = "<?php echo $videoid; ?>";
	var gallery = document.getElementById('gallery-ul');
	var li = document.createElement('li');
	var a = document.createElement('a');
	var img = document.createElement('img');
	li.className = "gallery-li";
	a.href = "<?php echo $link; ?>";
	img.className = "gallery-image";
	img.src = "http://img.youtube.com/vi/"+videoSrcID+"/0.jpg";
	a.appendChild(img);
	li.appendChild(a);
	gallery.appendChild(li);
</script>
<?php
}
?>

<script type="text/javascript">
var numImages = 0;
var currentImage = 1;
var totalWidth= 0;

function moveRight(){

	if(currentImage<numImages-2){
		$('#gallery-ul').animate({'marginLeft':'-=162.5px'} , 1000 , 'swing' );
		currentImage++;
	}
}

function moveLeft(){

	if(currentImage>1){
		$('#gallery-ul').animate({'marginLeft':'+=162.5px'} , 1000 , 'swing' );
		currentImage--;
	}
}

$('.gallery-li').each(function(){
	numImages++;
	totalWidth += 325;
});

$('#gallery-ul').css('width',totalWidth + 'px');

$('.rightbtn').click(function(){
	moveRight();
});

$('.leftbtn').click(function(){
	moveLeft();
});
</script>