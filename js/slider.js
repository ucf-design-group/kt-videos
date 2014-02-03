var numImages = 0;

var currentImage = 1;

var totalWidth= 0;

function moveRight(){

	if(currentImage<numImages-1){
		$('.gallery-ul').animate({'marginLeft':'-=325px'} , 1000 , 'swing' );
		currentImage++;
	}
}

function moveLeft(){

	if(currentImage>1){
		$('.gallery-ul').animate({'marginLeft':'+=325px'} , 1000 , 'swing' );
		currentImage--;
	}
}

$(document).ready( function(){

	$('.gallery-li').each(function(){
		numImages++;
		totalWidth += 325;
	});



	$('.gallery-ul').css('width',totalWidth + 'px');


	$('.rightbtn').click(function(){
		moveRight();
	});


	$('.leftbtn').click(function(){
		moveLeft();
	});
});