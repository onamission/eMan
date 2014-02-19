function fillRiderDetails( ){
    var rider_id = '';
    $("#rider_id option:selected").each(function () {
              rider_id = $(this).selected();
    });
    $.get('../timingRider/riderDetail?rider_id='+$("#existingRiderNameInput").val()
    , function( response ){
        $('#riderDetails').html( response );
        }
    );
}

function getIdFromIdNName( id_n_name ){
    var tempList = id_n_name.split(' - ');
    return tempList[0];
}

function parseRiderJson( haystackJson, needleId ){
    $.each( haystackJson, function( obkey, ob ){
        $.each( ob, function ( obkey2, ob2 ){
            if ( obkey2 == needleId ){
                $.each( ob2, function( key, value ){
                    $('#input_' + key ).val(value);
                });
            }
        } );
    } );
}

function calculateTime( startTime, incrementBy, incrementTimes ){
    var tseconds = ( parseInt(startTime) + ( parseInt(incrementBy) * parseInt(incrementTimes) ) );
    var ampm = ' AM';
    var hours = parseInt( tseconds / 60 / 60 );
    var remaining = tseconds - ( hours * 60 * 60 );
    var mins = parseInt( remaining / 60 );
    remaining = remaining - ( mins * 60 );
    var secs = parseInt( remaining );
    if ( hours > 12 ){
        hours = hours - 12;
        ampm = ' PM';
    }
    if ( hours.toString().length < 2 ) { hours = '0' + hours.toString();};
    if ( mins.toString().length < 2 ) { mins = '0' + mins.toString(); };
    if ( secs.toString().length < 2 ) { secs = '0' + secs.toString(); };
    return hours + ':' + mins + ':' + secs + ampm;
}

function hasContent ( element ){
    return ( element !== undefined && element !== null );
}

function fillContent ( ui ){
    $("#riderName").val( ui.name );
    $("#riderFirstName").val( ui.first_name );
    $("#riderLastName").val( ui.last_name );
    $("#riderId").val( ui.id );
    if ( hasContent( ui.attributes ) ){
        if ( hasContent( ui.attributes.gender ) ){
            $("#rider_gender").val( ui.attributes.gender );
        }else{
            $("#rider_gender").val( '' );
        }
        if ( hasContent( ui.attributes.contact )
                && hasContent( ui.attributes.contact.email ) ){
              $("#rider_contact_home_email").val( ui.attributes.contact.email );
        }else{
              $("#rider_contact_home_email").val( '' );
        }
        if ( hasContent( ui.attributes.defaultClass ) ){
            $("#rider_defaultClass").val( ui.attributes.defaultClass );
        }else{
            $("#rider_defaultClass").val( '' );
        }
        if ( hasContent( ui.attributes.team ) ){
            $("#rider_team").val( ui.attributes.team );
        }else{
            $("#rider_team").val( '' );
        }
        if ( hasContent( ui.attributes.defaultCategory ) ){
            $("#rider_defaultCategory").val( ui.attributes.defaultCategory );
        }else{
            $("#rider_defaultCategory").val( '' );
        }
    }
    $.getJSON('../timingRider/ajax?a=riderData&rider_id=' + ui.id
        + '&event_id=' + $('#event_id').val(), function(result){
          rider_dets = result;
          $('#rider_handicap_stock').val(result.stock);
          $('#rider_handicap_open').val(result.open);
          $('#rider_lastRace').val(result.last_race);
          $('#rider_countOfRaces').val(result.race_count );
          $('#rider_fastestTime').val(result.fastest);
          if( result.ridesThisEvent < 1 ){
              if ( result.credit >= 1 ){
                  $('#rider_payment_div').html('<b>Paid</b>');
              }else{
                  $('#rider_payment_div').html('<select id="rider_payment" name="rider_payment_event25">\n'
                      +'<option value="">Choose One . . .</option>\n'
                      +'<option value="0">Full Season Pass</option>\n'
                      +'<option value="1">Half Season Pass</option>\n'
                      +'<option value="3">Check</option>\n'
                      +'<option value="4">Cash</option>\n'
                      +'<option value="5">Other</option></select>');
              }
          }else if (result.ridesThisEvent >= 1 ){
              if ( result.dd >= 1 ){
                  $('#rider_payment_div').html('<b>Paid</b>');
              }else{
                  $('#rider_payment_div').html('<select id="rider_payment" name="rider_payment_event25">\n'
                      +'<option value="">Double Down . . .</option>\n'
                      +'<option value="3">Check</option>\n'
                      +'<option value="4">Cash</option>\n'
                      +'<option value="5">Other</option></select>');
              }
          }
          $('#pass').show().html( result.credit);
          $('#dd').show().html( result.dd );
          $('#s_winner').html( result.scratch_winner );
          $('#h_winner').html( result.handicap_winner );
          $('#pr').html( result.personal_record );
    });
}

$(document).ready(function(){
      if (  $('#riderId' ).val() !== '' &&  $('#riderId' ).val() !== null ){
        $.getJSON('../timingRider/ajax?a=riderList&id=' + $('#riderId').val() + '&event_id=' + $('#event_id').val()
            , function (ui){ fillContent( ui ); } );
      };
      var rider_dets = null;
      var ac_config = {
          source: '../timingRider/ajax?a=riderList&event_id=' + $('#event_id').val(),
          search   : function(){$('#loading_data').show().addClass('loading_class');},
          response : function(){$('#loading_data').removeClass('loading_class'); },
          focus: function( event, ui ){
          fillContent( ui.item );},
          minLength:3
      };
      $("#existingRiderNameInput").autocomplete( ac_config ).focus();
      $("#riderRaceNumber").bind("change",function(){
          var st = $('#raceStartTime').val();
          var si = $('#raceStartInterval').val();
          if( si === '' || si < 1 ){ si = 30; }
          var rn = $('#riderRaceNumber').val();
          var fn = $('#raceFirstNumber').val();
          $('#riderStartTime').html( calculateTime( st, si, rn - fn ) ) ;
      } );
      $(".registrationForm").attr("disabled",true);
      $("#lockRiderButton").bind("click", function(){
              $(".registrationForm").attr("disabled",true);
              $("#lockRiderButton").hide();
              $("#editRiderButton").show();
      });
      $("#editRiderButton").bind("click", function(){
              $(".registrationForm").attr("disabled",false);
              $("#lockRiderButton").show();
              $("#editRiderButton").hide();
       });
       $("#submitRider").bind("click", function(){
           var rider_dets = null;
            $('#notification').css('width', function(){ return $(window).width() / 2;});
            $('#notification').css('left', function(){ return $(window).width()/ 4 ;});
            $('#notification').css('top', function(){ return $(window).height() / 3;});
           // $('#notification').css('display', 'show');
            $.getJSON('../timingDetails/ajax?a=rider-details&event_id=' + $( '#event_id' ).val() + '&rider_id=' + $('#riderId').val()
            , function ( json ){ rider_dets = json.length; } );
           if( $('#riderFirstName').val() === '' || $('#riderFirstName').val() === null ){
                $('#notification').fadeIn().addClass('warning');
                $('#notification').html( "We need a rider name!" ).fadeOut(5000, function(){
                    $('#notification').removeClass('warning');});
                $('#existingRiderNameInput').focus();
            }
            else if( $('#riderRaceNumber').val() === '' || $('#riderRaceNumber').val() === null ){
                $('#notification').fadeIn().addClass('warning');
                $('#notification').html( "Don't forget to give " + $('#riderFirstName').val()
                    + " a race number!" ).fadeOut(5000, function(){ $('#notification').removeClass('warning');});
                $('#riderRaceNumber').focus();
            }else if( $('#rider_payment').val() === '' &&
                    ( ( rider_dets.ridesThisEvent < 1 && rider_dets.credit < 1 )
                    || rider_dets.ridesThisEvent > 0 && rider_dets.dd_credit < 1 ) ){
                $('#notification').fadeIn().addClass('warning');
                $('#notification').html( $('#riderFirstName').val() + " needs to pay"
                    ).fadeOut(5000, function(){ $('#notification').removeClass('warning');});
                $('#rider_payment').focus();
            } else{
                $.getJSON('../timingRider/ajax?a=numberUnique&event_id=' + $('#event_id').val()
                    + '&rider_num=' + $('#riderRaceNumber').val(), function(result) {
                    if( result==='unique' ){
                        $(".registrationForm").attr("disabled", false );
                        $('#notification').fadeIn().addClass('success');
                        $('#notification').html(  $('#riderFirstName').val()
                            + " is registered with number " + $('#riderRaceNumber').val()  ).fadeOut(2500, function(){
                            $('#notification').removeClass('success');
                            $('#registrationForm').submit();});
                    } else {
                        $('#notification').fadeIn().addClass('error');
                        $('#notification').html( 'Number ' + $('#riderRaceNumber').val()
                            + ' has been used. \n\nPlease use a different number for each rider' ).fadeOut(5000, function(){
                            $('#notification').removeClass('error');
                        });
                       // alert ();
                    }
              });
            }
       });
});