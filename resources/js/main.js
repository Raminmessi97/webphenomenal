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

// alert(localStorage.getItem("login"))
 
// var ram = 0;
// localStorage.setItem("login", false);
// var login_check = (function() {
//     return function() {
//     	if(localStorage.getItem("login")=="true"){
//     		location.reload();

// 			localStorage.setItem("login", false)
// 		}
// 	}
// })();


// let loginTime = setInterval(login_check, 1000);

// setTimeout(loginTime, 1);


// $('#user-login').on('click',function(e){
// 	localStorage.setItem("login", true);
// });


// if (window.localStorage){
//      $('a#user-logout').on('click', function(){
//         localStorage.setItem("app-logout", 'logout' + Math.random());
//         return true;
//      });

//      $('test-localstorage').on('click',function(){
//      	localStorage.setItem("name", "ramin");
//      	return true;
//      })
//  }
 
// window.addEventListener('storage', function(event){
//   if (event.key == "app-logout") {
//     window.location = $('a#user-logout').attr('href');
//   }
//     if (event.key == "name") {
//     	console.log('name'+localStorage.getItem("name"));
//   }
// }, false);



});
