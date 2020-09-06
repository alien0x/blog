

$(function(){
    'use strict';

    $('.ham-menu').on('click',function(){
        $('.toggle').toggleClass('open');
        $('.nav-list').toggleClass('open');
    })

 
     $('.login-page h1 span').click(function(){
         $(this).addClass('active').siblings().removeClass('active');
         $('.login-page form').hide();
         $('.'+ $(this).data('class')).fadeIn(100);
     })
 
 
     
 
 
 
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
 
   
    $(".confirm").click(function(){
        return confirm('Are you sure?');
    })
 

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

  
   $(".confirm").click(function(){
       return confirm('Are you sure?');
   })

  
   

});