/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function(){
   $('div.dropdownList').hide();
   $('.dropdown-button').click(function(){
       
        $(this).parents().find('div.dropdownList').slideToggle();
   });
   
});