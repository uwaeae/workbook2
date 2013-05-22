
$(document).ready(function(){
    $('.job_overview_item_content').hide();
    $('.job_overview_item_head').click(function(){
       var id = $(this).data('toggle');
       $(this).toggleClass('active');
       $('div#'+id).slideToggle();
    });

    var loc = document.URL;
    console.log(loc);
    var result = loc.split('#');
    if(result[1]) {
        console.log(result);
        $('div#'+result[1]).parents('div.job_overview_item_content').slideDown();
        $('div#'+result[1]).slideToggle();

    }

});