<?php
$sortBy = $_REQUEST[ 'sort' ];
echo $sortBy;
$allDetails = TimingDetails::model()->with( 'rider' )->findAll( 'event_id=:e and duration >:d'
        , array(':e'=>$_REQUEST['event_id'], ':d'=>'0' ));

// if sort by handicap, then reorder
$reorderMap = array();
foreach ( $allDetails as $rider )
{
    $r=  TimingRider::model()->findByPk( $rider->rider_id );
    $riderGroupBy = ( !isset( $_REQUEST[ 'group' ] )
            || $_REQUEST[ 'group' ] == 'all'
            || $_REQUEST[ 'group' ] == 'undefined')
            ? 'All'
            :$rider->$_REQUEST[ 'group' ] . ' - ' . $r->attrMap['gender'];
    $riderHandicap = isset( $rider->attrMap[ 'handicap' ] ) ? $rider->attrMap[ 'handicap' ] : "00:00:00.000";
    $sortTime = ( $sortBy == 'handicap' )
        ? brUtils::calculateWithMicroSeconds( $rider->duration, 'diff', $riderHandicap )
        : $rider->duration;
    $reorderMap[ $riderGroupBy ][$sortTime][]= $rider;
}
ksort( $reorderMap );
// echo "<div id='notification'>$message</div>";
echo "<table>";
foreach ( $reorderMap as $group=>$r )
{
    echo "<tr>";
    echo "<th>Rank</th>";
    echo "<th>Race<br />Number</th>";
    echo "<th>Rider<br />Name</th>";
    echo "<th>Group</th>";
    echo "<th>Scratch<br />Time</th>";
    echo "<th>Handicap</th>";
    if ( $sortBy == 'handicap' ) echo "<th>Net<br />Time</th>";
    echo "</tr>";
    $count = 1;
    ksort( $r );
    foreach( $r as $net => $slot ){
        foreach ( $slot as $rider )
        {
            //$place = $count + 1;
            $class = $count % 2 == 0 ? 'even' : 'odd';
            echo "<tr class='$class'>";
            echo "<td>$count</td>";
            echo "<td>{$rider->rider_num}</td>";
            echo "<td>{$rider->rider->name}</td>";
            echo "<td>$group</td>";
            echo "<td>{$rider->duration}</td>";
            echo "<td>{$rider->attrMap[ 'handicap' ]}</td>";
            if ( $sortBy == 'handicap' ) echo "<td>$net</td>";
            echo "</tr>";
            $count++;
        }
    }
}
echo "</table>";
?>