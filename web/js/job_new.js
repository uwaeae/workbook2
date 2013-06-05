/**
 * Created with JetBrains PhpStorm.
 * User: uwaeae
 * Date: 29.05.13
 * Time: 11:59
 * To change this template use File | Settings | File Templates.
 */

var AddressSelect = function(){
    var id = $(this).data('id');
    $('#address').empty().html($(this).find('div').html()).show();
    $('input#wb_corebundle_jobtype_Address').val(id);
    $('#AdressSelect').slideUp();
    $('div#address address').click(function(){
        $('#address').hide();
        $('#AdressSelect').slideDown();
    })

}



$(document).ready(function(){





    $('.datetimepicker').datetimepicker({
        showOn: "focus",
        showWeek: true,
        dateFormat: 'dd.mm.yy',
        defaultDate: +7,
        timeFormat: 'HH:mm',
        stepHour: 1,
        stepMinute: 15,
        controlType: 'select',
        timeText: 'Zeit',
        hourText: 'Stunden',
        minuteText: 'Minuten',
        secondText: 'Sekunden',
        currentText: 'Jetzt',
        closeText: 'Fertig',
        onSelect :  function(datetimeText, datepickerInstance){
                       // $(this).find('input').val(datetimeText);
                        console.log($(this));
                        console.log(datepickerInstance);

                        $('#'+datepickerInstance.id).val(datetimeText);
                    },
        showTime: false
    });
    var start = new Date();

    start.setDate(start.getDate() +7);
    start.setHours(8);
    start.setMinutes(0);
    $('#wb_corebundle_jobtype_start').datetimepicker('setDate', start );
  //  $('#wb_corebundle_jobtype_start').val( start );
    var end = new Date();
    end.setDate(end.getDate()+7);
    end.setHours(16);
    end.setMinutes(0);
    $('#wb_corebundle_jobtype_end').datetimepicker('setDate', end);
  //  $('#wb_corebundle_jobtype_end').val(end);





    $( "#customersearch" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/app_dev.php/customer/search/"+request.term,
                dataType: "json",
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.company ,
                            value: item.company,
                            data: item.Address
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            //console.log(ui);
            var data = ui.item.data;

            if(data.length == 1){
                var item = data[0];
                $('input#wb_corebundle_jobtype_Address').val(item.id);
                var AdressString = '<address>'+item.street+'<br>' +
                    item.postcode+' '+item.city+' '+item.destrict+'<br>' +
                    'Tel. '+item.fon+'<br>Fax '+item.fax+'<br>' +
                    '</p>';
                $('#address').html(AdressString);

            }else{
                var list = $('<ul>');
                //console.log(data);
                $.each(data,function(key,item){
                    var AdressString = '<address>'+item.street+'<br>' +
                        item.postcode+' '+item.city+' '+(item.destrict == null?'' :item.destrict )+'<br>' +
                        'Tel. '+item.fon+'<br>'+(item.fax == null?'' :'Fax '+item.fax+'<br>' ) +
                        '</p>';
                    var i = $('<li>');
                    i.data('id',item.id);
                    i.html(item.street+' '+item.postcode+' '+item.city+' '+(item.destrict == null?'' :item.destrict ));
                    i.append($('<div>').html(AdressString).hide());
                    i.click(AddressSelect);
                    list.append(i);
                });
                var container = $('<div>').attr('id','AdressSelect').hide();
                container.append(list);

                $('#address').parent().append(container);
                $('#address').hide();
                $('#AdressSelect').slideDown();

            }


        }

    });

});