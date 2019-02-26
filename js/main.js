$(document).ready(function(){
	var controller = new ScrollMagic.Controller();

	var pinIntroScene = new ScrollMagic.Scene({
		triggerElement: '#blog-info',
		triggerHook: 0,
		duration: '30%'
	})
	.setPin('#blog-info > div', {pushFollowers: false})
	.addTo(controller);

	var pinIntroScene2 = new ScrollMagic.Scene({
		triggerElement: 'section',
		triggerHook: 0.45
	})
	.setPin('#blog-info > div', {pushFollowers: false})
	.addTo(controller);
	// parallax scene

	// var parallaxTl = new TimelineMax();
	// parallaxTl
	// 	.from('.content-wrapper', 0.4, {autoAlpha: 0, ease:Power0.easeNone}, 0.4)
	// 	.from('.bcg', 2, {y: '-50%', ease:Power0.easeNone}, 0)
	// 	;

	// var slideParallaxScene = new ScrollMagic.Scene({
	// 	triggerElement: '.bcg-parallax',
	// 	triggerHook: 1,
	// 	duration: '100%'
	// })
	// .setTween(parallaxTl)
	// .addTo(controller);

	$('section .content').each(function(){

		var ourScene = new ScrollMagic.Scene({
			triggerElement: this.children[0],
			triggerHook: 0.8
		})
		.setClassToggle(this, 'fade-in')
		.addTo(controller);

	});

});
window.addEventListener('scroll', function(e) {
	if(window.scrollY < 60) {
		var height = 100 - window.scrollY;
		document.getElementById("menu").style.height = height+"px";
	}
});
