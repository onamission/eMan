//$(document).ready(function() {
    var url = ( $('#results_control').value == 'events' )
    ?'/eman/index.php/timingEvents/ajax?a=eventList'
    :'/eman/index.php/timingRiders/ajax?a=riderList';
    var ac_config = {
    source: url,
    search   : function(){$('#loading_data').show().addClass('loading_class');},
    response : function(){$('#loading_data').removeClass('loading_class'); },
    focus: function( event, ui ){
        if( $('#results_control').value == 'events' )
        {
            $('#result_detail').load('/eman/index/timingDetails/ajax?a=eventResults&event_id=' + ui.item.event_id);
        }
        else
        {
            $('#result_detail').load('/eman/index/timingDetails/ajax?a=riderResults&rider_id=' + ui.item.rider_id);
        }
    }
}
$("#results_filter").autocomplete( ac_config ).focus();
//});

