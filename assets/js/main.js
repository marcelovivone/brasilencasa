// form validation
$(function(){
	'use strict';

	// add email regex method
	jQuery.validator.addMethod(
		'regex-email',
		function(value, element, regexp) {
			if (regexp.constructor != RegExp)
				regexp = new RegExp(regexp);
			else if (regexp.global)
				regexp.lastIndex = 0;
				return this.optional(element) || regexp.test(value);
		},'Please, enter a valid email address.'
	);

	// add password regex method
	jQuery.validator.addMethod(
		'regex-password',
		function(value, element, regexp) {
			if (regexp.constructor != RegExp)
				regexp = new RegExp(regexp);
			else if (regexp.global)
				regexp.lastIndex = 0;
				return this.optional(element) || regexp.test(value);
		},'Please, enter a valid password.'
	);
	
	// store/login.html file
	$('#reg-user-form').validate({
		ignore: '.ignore',
		rules: {
			'reg-email': {
				required: true,
				email: true,
				'regex-email': /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
			},
			'reg-password': {
				required: true
			}
		},
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		}
	});

	// store/login.html file
	$('#new-user-form').validate({
		ignore: '.ignore',
		rules: {
			'new-firstname': {
				required: true,
				maxlength: 30
			},
			'new-lastname': {
				required: true,
				maxlength: 90
			},
			'new-email': {
				required: true,
				email: true
			},
			'newpassword': {
				required: true,
				minlength: 8,
				maxlength: 20,
				'regex-password': /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/
/* - strong		'regex-password': /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/ */
			},
			'new-password-confirm': {
				required: true,
		      	equalTo: '#newpassword'
			},
			'title': {
				required: true
			}
		},
		errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") ) 
            {
/*
				var parentEls = $(element).parents()
				.map(function() {
					console.log(this.tagName);
					return this.tagName;
				})
				.get()
				.join( ", " );

				$(element).append( "<strong>" + parentEls + "</strong>" );
*/
                error.appendTo( element.parents('.validate') );
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
            }
         }
/*		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		}
*/	});

	// store/contact.html file
	$('#contact-form').validate({
		ignore: '.ignore',
		rules: {
			name: {
				required: true,
				maxlength: 120
			},
			email: {
				required: true,
				email: true,
				'regex-email': /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
			},
			subject: {
				required: true,
				minlength: 3,
				maxlength: 50
			},
			message: {
				required: true,
				minlength: 6,
				maxlength: 1000
			}
		},
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		}
	});

	// store/forgot.html file
	$('#forgot-form').validate({
		ignore: '.ignore',
		rules: {
			email: {
				required: true,
				email: true,
				'regex-email': /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
			}
		},
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		}
	});

	// store/forgot-reset.html file
	$('#forgot-reset-form').validate({
		ignore: '.ignore',
		rules: {
			password: {
				required: true,
				minlength: 8,
				maxlength: 20,
				'regex-password': /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/
/* - strong		'regex-password': /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/ */
			}
		},
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		}
	});
});

// store email and password checking
function checkUser(emailName, passwordName, language, newUser, callback){
	let email = jQuery.trim(document.getElementById(emailName).value);
	let password = '';

	if (passwordName !== '') password = jQuery.trim(document.getElementById(passwordName).value);

	jQuery.ajax({
		url:'/views/en/store/checkUser.php',
		type: 'POST',
		cache: false,
		data: {email: email, password: password, language: language, newUser: newUser},
		success: function(response, status, xhr)
		{
			callback(response);
		},
		error: function(xhr, status, error)
		{
			console.log('error: '+error);
		}
	});
}

function submitFinal(form, submit) {
	if (submit){
		$(form).submit();
	}

	document.getElementById('error-message').style.display = "none";
	$('#error-message').html('');
	return true
}

// store (with or without user and password) formularie validation
function validateForm(form, submit, emailName, passwordName, language, newUser) {

	switch (language) {
		case 'es':
			jQuery.extend(jQuery.validator.messages, {
			    required: "Este campo es requerido.",
			    remote: "Dados incorretos.",
			    email: "Introduzca un e-mail v\u00e1lido.",
			    url: "Introduzca una URL v\u00e1lida.",
			    date: "Introduzca una fecha v\u00e1lida.",
			    dateISO: "Introduzca una fecha (ISO) v\u00e1lida.",
			    number: "Introduzca un n\u00famero v\u00e1lido.",
			    digits: "Sólo introduzca n\u00fameros.",
			    creditcard: "Introduzca un n\u00famero de tarjeta v\u00e1lida.",
			    equalTo: "Introduzca la misma contrase\u00f1a de nuevo.",
			    accept: "Introduzca un valor con una extensi\u00f3n v\u00e1lida.",
			    maxlength: jQuery.validator.format("Informe al m\u00e1ximo {0} letras o n\u00fameros."),
			    minlength: jQuery.validator.format("Informe al menos {0} letras o n\u00fameros."),
			    rangelength: jQuery.validator.format("El campo debe contener entre {0} y {1} letras o n\u00fameros."),
			    range: jQuery.validator.format("Informe um valor entre {0} e {1}."),
			    max: jQuery.validator.format("Introduzca un valor menor o igual a {0}."),
			    min: jQuery.validator.format("Informe un valor mayor o igual a {0}.")
			});
			break;

		case 'pt':
			jQuery.extend(jQuery.validator.messages, {
				required: "Campo obrigat\u00f3rio!",
				remote: "Por favor, corrija este campo.",
				email: "Por favor, forne\u00e7a um endereço eletr\u00f4nico v\u00e1lido.",
				url: "Por favor, forne\u00e7a uma URL v\u00e1lida.",
				date: "Por favor, forne\u00e7a uma data v\u00e1lida.",
				dateISO: "Por favor, forne\u00e7a uma data v\u00e1lida (ISO).",
				number: "Por favor, forne\u00e7a um n\u00famero v\u00e1lido.",
				digits: "Por favor, forne\u00e7a somente d\u00edgitos.",
				creditcard: "Por favor, forne\u00e7a um cart\u00e3o de cr\u00e9dito v\u00e1lido.",
				equalTo: "Por favor, forneça o mesmo valor novamente.",
				accept: "Por favor, forneça um valor com uma extens\u00e3o v\u00e1lida.",
				maxlength: jQuery.validator.format("Por favor, forne\u00e7a n\u00e3o mais que {0} caracteres."),
				minlength: jQuery.validator.format("Por favor, forne\u00e7a ao menos {0} caracteres."),
				rangelength: jQuery.validator.format("Por favor, forne\u00e7a um valor entre {0} e {1} caracteres de comprimento."),
				range: jQuery.validator.format("Por favor, forne\u00e7a um valor entre {0} e {1}."),
				max: jQuery.validator.format("Por favor, forne\u00e7a um valor menor ou igual a {0}."),
				min: jQuery.validator.format("Por favor, forne\u00e7a um valor maior ou igual a {0}.")
			});
			break;
	}

	$(form).validate();

	if($(form).valid()){

		if (emailName !== ''){
			let msg = '';
			checkUser(emailName, passwordName, language, newUser, function(data){

				if(data === 'false' && !newUser){

					switch (language) {
						case 'en':
							if (passwordName === '') {
								msg = 'Unregistered email.';
							} else {
								msg = 'Unregistered email or incorrect password.';
							}
							break;

						case 'es':
							if (passwordName === '') {
								msg = 'E-mail no registrado.';
							} else {
								msg = 'E-mail no registrado o contrase\u00f1a incorrecta.';
							}
							break;

						case 'pt':
							if (passwordName === '') {
								msg = 'E-mail n\u00e3o cadastrado.';
							} else {
								msg = 'E-mail n\u00e3o cadastrado ou senha incorreta.';
							}
							break;
					}

					$('#error-message').html(msg);
					document.getElementById('error-message').style.display = 'block';
					document.getElementById(emailName).focus();
				}

				if(data === 'true' && newUser){

					switch (language) {
						case 'en':
							msg = 'Email already registered';
							break;

						case 'es':
							msg = 'E-mail ya registrado';
							break;

						case 'pt':
							msg = 'E-mail j\u00e1 cadastrado';
							break;
					}

					$('#error-message').html(msg);
					document.getElementById('error-message').style.display = 'block';
					document.getElementById(emailName).focus();
				}

				if (msg !== '') return false;

				return submitFinal(form, submit);
			});

		} else {
			return submitFinal(form, submit);
		}
	} else {
		return false;
	}
}

//Dropdown Menus
$(".dropdown").hover(
  function () {
    $(this).addClass('open');
  }, 
  function () {
    $(this).removeClass('open');
  }
  );



//Search

  var openSearch = $('.open-search'),
    SearchForm = $('.full-search'),
    closeSearch = $('.close-search');

    openSearch.on('click', function(event){
      event.preventDefault();
      if (!SearchForm.hasClass('active')) {
        SearchForm.fadeIn(300, function(){
          SearchForm.addClass('active');
        });
      }
    });

    closeSearch.on('click', function(event){
      event.preventDefault();

      SearchForm.fadeOut(300, function(){
        SearchForm.removeClass('active');
        $(this).find('input').val('');
      });
    });


//WOW Scroll Spy
var wow = new WOW({
    //disabled for mobile
    mobile: false
});
wow.init();


//Owl Carousel
$('#clients-scroller').owlCarousel({
    items:4,
    itemsTablet:3,
    margin:90,
    stagePadding:90,
    smartSpeed:450,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,3],
    itemsTablet: [767,2],
    itemsTabletSmall: [480,2],
    itemsMobile : [479,1],
});

//Color Client
$('#color-client-scroller').owlCarousel({
    items:4,
    itemsTablet:3,
    margin:90,
    stagePadding:90,
    smartSpeed:450,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,3],
    itemsTablet: [767,2],
    itemsTabletSmall: [480,2],
    itemsMobile : [479,1],
});

//Owl Carousel
$('#testimonial-item').owlCarousel({
    autoPlay: 5000,
    items:3,
    itemsTablet:3,
    margin:90,
    stagePadding:90,
    smartSpeed:450,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,3],
    itemsTablet: [767,2],
    itemsTabletSmall: [480,2],
    itemsMobile : [479,1],
});

//Dark Testimonial Carousel
$('#testimonial-dark').owlCarousel({
    autoPlay: 5000,
    items:3,
    itemsTablet:3,
    margin:90,
    stagePadding:90,
    smartSpeed:450,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,3],
    itemsTablet: [767,2],
    itemsTabletSmall: [480,2],
    itemsMobile : [479,1],
});

// Single Testimonial
$('#single-testimonial-item').owlCarousel({
  singleItem: true,
  autoPlay: 5000,
    items: 1,
    itemsTablet: 1,
    margin:90,
    stagePadding:90,
    smartSpeed:450,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,3],
    itemsTablet: [767,2],
    itemsTabletSmall: [480,2],
    itemsMobile : [479,1],
    stopOnHover: true,
});

// Image Carousel
$("#image-carousel").owlCarousel({
  autoPlay: 3000, //Set AutoPlay to 3 seconds
  items : 4,
  itemsDesktop : [1170,3],
  itemsDesktopSmall : [1170,3]
 
});

// Slider Carousel
$("#carousel-image-slider").owlCarousel({
  navigation : false, // Show next and prev buttons
  slideSpeed : 300,
  paginationSpeed : 400,
  singleItem:true,
  pagination: false,
  autoPlay: 3000,
});


 //About owl carousel Slider
  $(document).ready(function(){
    /*=== About us ====*/
    $('#carousel-about-us').owlCarousel({   
        navigation: true, // Show next and prev buttons
        navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        slideSpeed: 800,
        paginationSpeed: 400,
        autoPlay: true,
        singleItem: true,
        pagination : false,
        items : 1,
        itemsCustom : false,
        itemsDesktop : [1199,4],
        itemsDesktopSmall : [980,3],
        itemsTablet: [768,2],
        itemsTabletSmall: false,
        itemsMobile : [479,1],
    });

});

//MixitUp
$(function(){
	$('#portfolio-list').mixItUp();

  if ($('#navbar-nav').length) {
    var $mobile_nav = $('#navbar-nav').clone().prop({
      id: 'mobile-nav'
    });

    $mobile_nav.find('ul').attr({
      'class': '',
      'id': ''
    });

    $('body').append($mobile_nav);
    $('#header .navbar-light .container').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
    $('body').append('<div id="mobile-body-overly"></div>');
//    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

//    $(document).on('click', '.menu-has-children i', function(e) {
//      $(this).next().toggleClass('menu-item-active');
//      $(this).nextAll('ul').eq(0).slideToggle();
//      $(this).toggleClass("fa-chevron-up fa-chevron-down");
//    });

    $(document).on('click', '#mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');

      if ($('#mobile-nav-toggle i').attr('class') === 'fa fa-times') {
        $('#mobile-nav-toggle i').css('color', '#fff');
      } else {
        $('#mobile-nav-toggle i').css('color', '#0c2e8a');
      }

      $('#mobile-body-overly').toggle();
    });

    $(document).click(function(e) {
      var container = $("#mobile-nav, #mobile-nav-toggle");

      if (!container.is(e.target) && container.has(e.target).length === 0) {

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-nav-toggle i').css('color', '#0c2e8a');
          $('#mobile-body-overly').fadeOut();
        }
      }
    });

  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  }

  toggleButton();
});

window.addEventListener("resize", toggleButton);

// Show or Hide toogle button depends on the width size
function toggleButton() {

  if ($(document).width() > 768) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  } else {
    $("#mobile-nav, #mobile-nav-toggle").show();
  }
}

// Testimonial
$('testimonial-carousel').carousel();
$('a[data-slide="prev"]').click(function () {
    $('#testimonial-carousel').carousel('prev');
});

$('a[data-slide="next"]').click(function () {
    $('#testimonial-carousel').carousel('next');
});

//CounterUp
  jQuery(document).ready(function( $ ) {
      $('.counter').counterUp({
          delay: 1,
          time: 800
      });
  });

// Progress Bar
$('.skill-shortcode').appear(function() {
  $('.progress').each(function() {
    $('.progress-bar').css('width', function() {
      return ($(this).attr('data-percentage') + '%')
    });
  });
}, {
  accY: -100
});

 // Back Top Link
  var offset = 200;
  var duration = 500;

  $(window).scroll(function() {

    if ($(this).scrollTop() > offset) {
      $('.back-to-top').fadeIn(400);
    } else {
      $('.back-to-top').fadeOut(400);
    }

  });

  $('.back-to-top').click(function(event) {
    event.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 600);
    return false;
  })


/* head in front of body */
window.onscroll = function() {
  $(document).width() > 768 ? (navbarSubmenu ? vNavSubBar() : vNavMenBar()) : vNavMenBar();
};

let navbar = document.getElementById("navbar");
let sticky = navbar.offsetTop;
let navbarSubmenu = document.getElementById("navbar-submenu");
let stickySubmenu = navbarSubmenu ? navbarSubmenu.offsetTop : 0;

function vNavMenBar() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
  } else {
    navbar.classList.remove("sticky");
  }
}

function vNavSubBar() {
  if ((window.pageYOffset >= sticky) & (window.pageYOffset < stickySubmenu - 70)) {
    navbar.classList.add("sticky");
  } else if (window.pageYOffset >= stickySubmenu - 70) {
    navbarSubmenu ? navbarSubmenu.classList.add("sticky-submenu") : "";
    navbar.classList.remove("sticky");
  } else {
    navbar.classList.remove("sticky");
    navbarSubmenu ? navbarSubmenu.classList.remove("sticky-submenu") : "";
  }
}