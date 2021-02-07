$(document).ready(function(){

  $(".show_user_settings").on("click",function(){
	if( $('.user-settings').hasClass('modal-hidden') ) {
		$('.user-settings').removeClass('modal-hidden');
	}
	else{
		$('.user-settings').addClass('modal-hidden');
	}
	});

  

  $(".close_errors").on("click",function(){
	if( $('.errors').hasClass('modal-hidden') ) {
		$('.errors').removeClass('modal-hidden');
	}
	else{
		$('.errors').addClass('modal-hidden');
	}
	});






$(document).mouseup(function (e) {
    var container = $('.user-settings');
    if (container.has(e.target).length === 0){
  	 $('.user-settings').addClass("modal-hidden");     
    }
});

$('.close_menu').on("click",function(){
	$('.inner-hidden-menu').removeClass('show-inner-menu');
});

$('.three-line-menu').on("click",function(){
	$('.inner-hidden-menu').addClass('show-inner-menu');
});

$(document).mouseup(function (e) {
    var container = $('.inner-hidden-menu');
    if (container.has(e.target).length === 0){
  	 $('.inner-hidden-menu').removeClass('show-inner-menu');   
    }
});

$(document).on('touchstart',function (e) {
      var container = $('.inner-hidden-menu');
    if (container.has(e.target).length === 0){
  	 $('.inner-hidden-menu').removeClass('show-inner-menu');   
    }
});

// function logSubmit(event) {
//   event.preventDefault();
//   var token =  $("meta[name='csrf-token']").attr("content");
//   console.log(token)
// }

// const form = document.getElementById('formsubmit');
// form.addEventListener('submit', logSubmit);



});
