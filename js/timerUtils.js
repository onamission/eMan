    function postTheTime()
    {
        var theTime = new Date();
        theTime = formatTime( theTime );
        var idx = 0;
        do
        {
            idx++;
            var st_idx = pad( idx, 4 );
        }while ( $('#raw_time'+st_idx).text().length !== 0 )
        $('#raw_time'+st_idx).text(theTime);
        $('#rider_input'+st_idx).focus();
    }

    function formatTime( dateObj )
    {
        var hours     = pad( dateObj.getHours(), 2 );
        var minutes   = pad(dateObj.getMinutes(), 2);
        var seconds   = pad(dateObj.getSeconds(), 2);
        var millisec  = pad(dateObj.getMilliseconds(), 3);
        return hours + ':' + minutes + ':' + seconds + '.' + millisec;
    }

    function pad(number, length)
    {
        var str = '' + number;
        while (str.length < length)
        {
            str = '0' + str;
        }

        return str;
    }

    function getRiderData(riderId, elementIdx, eventId )
    {
        // If a null rider number is passed, then clear the fields
        if ( riderId === '' )
        {
            $('#raw_time'+elementIdx).text('');
            $('#rider_name'+elementIdx).text('');
            $('#rider_duration'+elementIdx).text('');
        }else{
           setRiderData( riderId, $('#raw_time'+elementIdx).text(), elementIdx,eventId)
        }
        $('#stopButton').focus();
    }

    function setRiderData( riderNum, rawTime, riderSuffix, eventId ){
        if ( rawTime !== '' ){
            var dataSet = {  'a':'finishLineDetail'
                ,'rider_id':riderNum
                ,'time':rawTime
                ,'event_id':+eventId };

            $.ajax({
              url: '/eman/index.php/timingDetails/ajax'
            , dataType: "json"
            , async: false
            , data: dataSet
            , success: function(r){
                $('#raw_time'+riderSuffix).text( rawTime );
                $('#rider_name'+riderSuffix).text( r.riderName );
                $('#rider_duration'+riderSuffix).text( r.riderDuration );
                }
            });
        }
    }
    function setRiderNum( detailId, newNum, event_id ){
        if ( newNum !== '' ){
            var dataSet = {
                'a':'updateRiderNum',
                'id':detailId,
                'rider_num':newNum
            };
            $.ajax({
              url: '/eman/index.php/timingDetails/ajax'
            , dataType: "json"
            , async: false
            , data: dataSet
            , success: function(r){
                $('#preRaceCheck').load('/eman/index.php/timingDetails/ajax?a=getPreRaceCheck&event_id=' + event_id)
                }
            });
        }
    }

    function displayRiderStatus( event_id )
    {
        $(document).ready( function() {
            $("#activeRiderList").load("/eman/index.php/timingDetails/ajax?a=ridersLeft&event_id=" + event_id  );
            var refreshId = setInterval(function() {
               $("#activeRiderList").load('/eman/index.php/timingDetails/ajax?a=ridersLeft&event_id=' + event_id );
            }, 5000);
            $.ajaxSetup({ cache: false });
        });
    }

    function displayRiderResults( element_id, page, interval)
    {
        $(document).ready( function() {
            $('#'+element_id).load( page )
            var refreshId = setInterval(function() {
               $("#"+element_id).load( page );
            }, interval);
            $.ajaxSetup({ cache: false });
        });
    }