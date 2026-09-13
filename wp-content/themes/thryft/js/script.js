jQuery(document).ready(function(){
	
	jQuery(".navbar-toggle").click(function(){
    jQuery(".hamburger").toggleClass("is-active");
    });
	
	jQuery(window).scroll(function(){
    if (jQuery(window).scrollTop() >= 150) {
        jQuery('#navbar').addClass('sticky');
    }
    else {
        jQuery('#navbar').removeClass('sticky');
    }
});

jQuery(".view-custom-faq .views-row h4 a").click(function(){
    jQuery(this).parent().parent().next().slideToggle();
	return false;
  });
  
  jQuery('.count h4').each(function () {
    jQuery(this).prop('Counter',0).animate({
        Counter: jQuery(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            jQuery(this).text(Math.ceil(now));
        }
    });
});

/*

jQuery(".showcontent").hide();
	
jQuery(".hidebtn").click(function(){
	jQuery(".showbtn").show();
    jQuery(".showcontent").slideUp();
  });
  
  jQuery(".showbtn").click(function(){
	  jQuery(this).hide();
    jQuery(this).next().slideDown();
  });
  
  */

});