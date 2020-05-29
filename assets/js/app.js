// =====================================================================================================================
// PRIMARY THEME JAVASCRIPT FILE
//
// This is your public-facing, front-end Javascript. It compiles to assets/js/app.min.js in your theme directory.
//
// This is used to initialize your custom Javascript. If you would like to change how Foundation and it's plugins are
// initialized, you can. See http://foundation.zurb.com/docs/javascript.html for documentation.
// =====================================================================================================================



(function($){
     
  // Foundation JavaScript
     $(document).foundation();
 
    // Additional JS goes here
    $('[data-curtain-menu-button]').click(function(){
        $('body').toggleClass('curtain-menu-open');
      });
      $('#lu-toggle').click(function() {
        $(this).toggleClass('active');
        $('#lu-overlay').toggleClass('open');
       });
      
       //hamburger menu
       
       /**
        * forEach implementation for Objects/NodeLists/Arrays, automatic type loops and context options
        *
        * @private
        * @author Todd Motto
        * @link https://github.com/toddmotto/foreach
        * @param {Array|Object|NodeList} collection - Collection of items to iterate, could be an Array, Object or NodeList
        * @callback requestCallback      callback   - Callback function for each iteration.
        * @param {Array|Object|NodeList} scope=null - Object/NodeList/Array that forEach is iterating over, to use as the this value when executing callback.
        * @returns {}
        */
         var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};
     
         var hamburgers = document.querySelectorAll(".hamburger");
         if (hamburgers.length > 0) {
           forEach(hamburgers, function(hamburger) {
             hamburger.addEventListener("click", function() {
               this.classList.toggle("is-active");
             }, false);
           });
         }
       
})(jQuery);