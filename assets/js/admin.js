// ===================================================================================================================== 
// PRIMARY CUSTOM ADMIN JAVASCRIPT FILE
//
// If you need to add any custom javascript to your WordPress admin, add it here.  It compiles to assets/js/admin.min.js
// in your theme directory.
// =====================================================================================================================

jQuery(document).ready(function(){
    jQuery('.lu_options').slideUp();
     
    jQuery('.lu_section h3').click(function(){      
        if(jQuery(this).parent().next('.lu_options').css('display')==='none')
            {   jQuery(this).removeClass('inactive').addClass('active').children('img').removeClass('inactive').addClass('active');
                 
            }
        else
            {   jQuery(this).removeClass('active').addClass('inactive').children('img').removeClass('active').addClass('inactive');
            }
             
        jQuery(this).parent().next('.lu_options').slideToggle('slow');  
    });
});// jQuery( document ).ready