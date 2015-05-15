(function() {
   'use strict';
   
   $('.combobox').change(function (event) {
       $(event.target).closest('form').submit();
   });
}())