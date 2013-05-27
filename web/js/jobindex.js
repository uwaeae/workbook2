
var makeJobTable = function(table,data){

    var index = 1;
    $.each(data, function(key, val) {

        var items = [];
        items.push('<td>' + val['id'] + '</td>');
        items.push('<td>' + val['customer'] + '</td>');
        items.push('<td>' + val['address1'] + '</br>'+ val['address2']+'</td>');
        items.push('<td>' + val['description'] + '</td>');
        items.push('<td class="jobType" data-type="'+val['type']+'" >' + val['type_name'] + '</td>');
        items.push('<td class="jobDate" >' + val['from'] + '</td>');
        items.push('<td class="jobDate" >' + val['to'] + '</td>');
        items.push('<td><div class="scheduledTasks" data-jobid=" ' + val['id'] + '" ></div></td>');

        table.find('table tbody').append( $('<tr>',{
            'onclick': 'location.href="'+val['id']+'/show"',
            html: items.join('')
            })
        );
        index ++;
    });
    makeTasks(table.find('table tbody'));
    if(table.data('mark')) markTable(table.find('table tbody'));

}


var makeTasks = function(table){
    var Jobs = table.find('.scheduledTasks');

    var jobid = new Array();
    Jobs.each( function(key,item) {
        jobid.push($(item).data('jobid'));
    })


    $.post("scheduledTasks", { 'jobs[]': jobid },function(data){

        $.each(data, function(jobid, tasks) {
            var items = [];
            $.each(tasks, function(key, task) {
                items.push('<li>' + task['date'] +' '+ task['user']+ '</li>');
            });
            $('div.scheduledTasks[data-jobid="'+jobid+'"]').append( $('<ul>',{
                html: items.join('')
            })
            );
        });

    });

}

var markTable = function(table){
    var type = table.find('.jobType');
    type.each(function(key,item){
       if($(item).data('type') == 1 ) $(item).addClass('mark');
    });

    var dates = table.find('.jobDate');
    dates.each(function(key,item){
       var d =  $(item).html();
        console.log(d);
        var date = d.split('.')
        var day = date[0];
        var month = date[1];
        var date = date[2].split(' ');
        var year = date[0];
        var date = date[1].split(':');

        var end = new Date('20'+year,month-1,day,date[0],date[1],0);
        var now = new Date();
       // console.log(end.toLocaleString());

        //console.log(Math.floor(end - now));
        if(Math.floor(end - now) < 0 ) $(item).addClass('mark');
    });
}



var jobHeader = function(){


    var id = $(this).data('toggle');
    var JobBody = $('div#'+id);
    if( !JobBody.hasClass('loaded')) {
        var table = $(this).data('table');
        if(table){
            $(this).find('img').fadeIn();
            var options = {'user':id };
            $.get("table/"+table, options,function(data){
                makeJobTable(JobBody,data);
                JobBody.slideToggle()
                .addClass('loaded');
                $('img.loading').fadeOut();
            });
        }else{
            JobBody.slideToggle();

        }

    }else{
        JobBody.slideToggle();
    }

    $(this).toggleClass('active');
}

$(document).ready(function(){
    $('.job_overview_item_content').hide();
    $('.job_overview_item_head').click(jobHeader);

    var loc = document.URL;
    console.log(loc);
    var result = loc.split('#');
    if(result[1]) {
        console.log(result);
        $('div#'+result[1]).parents('div.job_overview_item_content').slideDown();
       // $('div#'+result[1]).slideDown();
        $('div#'+result[1]).parent().find('a').click();
    }


});