
$(function(){
   'use strict';

   $('[placeholder]').focus(function(){
       $(this).attr('data-text', $(this).attr('placeholder'));
       $(this).attr('placeholder','');
   }).blur(function(){
       $(this).attr('placeholder',$(this).attr('data-text'));
   });
  
   //add asterisk on required field
   $('input').each(function(){
       if($(this).attr('required')==='required'){
           $(this).after('<span class="asterisk">*</span>');
       }
   });

   var passField =$('.password');

   $('.show-pass').hover(function(){

    passField.attr('type' , 'text');

   }, function(){

    passField.attr('type' , 'password');

   });
   $(".confirm").click(function(){
       return confirm('Are you sure?');
   })

   $(".cat h3").click(function(){
      $(this).next(".full-view").fadeToggle(200);
   })

   $(".ordering .first").click(function(){
       $(this).addClass("active");
       $(".ordering .second").removeClass('active');
       $(".full-view").hide(200);
   })
   $(".ordering .second").click(function(){
    $(this).addClass("active");
    $(".ordering .first").removeClass('active');
    $(".full-view").show(200);
})


$(".toggle-info").click(function(){
    $(this).find(".card-body").toggleClass("dis")
})
});