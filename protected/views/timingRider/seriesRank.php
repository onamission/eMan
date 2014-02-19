<style>
    .grouphead{
        border-top: 2px #222 solid;
        background-color: orange;

    }
</style>

<?php
$isGender = ( isset( $_REQUEST['group'] ) && $_REQUEST['group']==='gender' )
    ? "checked='checked'"
    :'';
$isClass = ( isset( $_REQUEST['group'] ) && $_REQUEST['group']==='class' )
    ? "checked='checked'"
    :'';
$isCategory = ( isset( $_REQUEST['group'] ) && $_REQUEST['group']==='cat' )
    ? "checked='checked'"
    :'';
$isAll = ( $isGender == '' && $isClass == '' && $isCategory == '' )
    ? "checked='checked'"
    :'';
?>

<form id="form" name="form">
	<table ><tr>
	<th width='100px' style="text-align: right">Group By: </th>
    <td width="300px"><input type='radio' value='gender' onclick='document.forms["form"].submit();' name='group' <?php echo $isGender;?>> Gender |
        <input type='radio' value='cat' name='group' onclick='document.forms["form"].submit();' <?php echo $isCategory;?>> Category |
        <input type='radio' value='class' name='group' onclick='document.forms["form"].submit();' <?php echo $isClass;?>> Class |
        <input type="radio" name="group" value="all" onclick='document.forms["form"].submit();'  <?php echo $isAll;?>>  All Riders</td></tr>
    </tr>
    <!-- <tr><td colspan="2" style="text-align: center"><input type="submit" value="Group" /></td></tr> -->
	</table>
</form>

<?php
/*	$sql = <<<EOD
	SELECT
	    te.name
	  , tr.id
	  , tr.first_name
	  , tr.last_name
	  , td.duration
	  , td.rider_category AS Category
	  , td.rider_class AS Class
	  , ta.value AS Gender
	  , @fastest:=(SELECT MIN( duration ) FROM timing_details WHERE event_id = td.event_id and td.duration > '0' ) AS fastest
	  , @fastest_sec := ((substring( @fastest, 4,2) * 60 ) + substring( @fastest, 7)) as fast_sec
	  , @duration_sec:=(substring( td.duration, 4,2) * 60 ) + substring( td.duration, 7) as seconds
	  , ( @fastest_sec - (@duration_sec - @fastest_sec) ) / @fastest_sec  * 100 as percent
	FROM timing_rider tr
	    INNER JOIN timing_details td ON ( td.rider_id = tr.id )
	    INNER JOIN timing_events te ON ( td.event_id = te.id )
	    INNER JOIN timing_attributes ta ON ( ta.parent_id = tr.id AND ta.parent = 'TimingRider' AND ta.name='gender' )
	WHERE event_id > 24
	ORDER BY event_id, duration
	LIMIT 100000

EOD;*/

	$sql = <<<EOD
	SELECT
	    te.name
	  , tr.id
	  , tr.first_name
	  , tr.last_name
	  , td.duration
	  , td.rider_category AS Category
	  , td.rider_class AS Class
	  , ta.value AS Gender
	  , @fastest:=(SELECT MIN( duration ) FROM timing_details WHERE event_id = td.event_id and td.duration > '0' ) AS fastest
	  , @fastest_sec := ((substring( @fastest, 4,2) * 60 ) + substring( @fastest, 7)) as fast_sec
	  , @duration_sec:=(substring( td.duration, 4,2) * 60 ) + substring( td.duration, 7) as seconds
	  , ( @fastest_sec / @duration_sec ) * 100 as percent
	FROM timing_rider tr
	    INNER JOIN timing_details td ON ( td.rider_id = tr.id )
	    INNER JOIN timing_events te ON ( td.event_id = te.id )
	    INNER JOIN timing_attributes ta ON ( ta.parent_id = tr.id AND ta.parent = 'TimingRider' AND ta.name='gender' )
	WHERE event_id > 24
	ORDER BY event_id, duration
	LIMIT 100000
EOD;
$command = Yii::app()->db->createCommand($sql);
$results = $command->queryAll();
$resultMap = array();
$eventNameList = array();
foreach ( $results as $record )
{
	$fullName = $record[ 'first_name' ] . "<br />" . $record[ 'last_name' ];
	if ( !isset( $resultMap[ $fullName ][ 'overall' ] ) )
		$resultMap[ $fullName ][ 'overall' ] = 0;
	$resultMap[ $fullName ][ 'overall' ] += $record[ 'percent' ];
	if ( !isset( $resultMap[ $fullName ][ 'raceCount' ] ) )
		$resultMap[ $fullName ][ 'raceCount' ] = 0;
	$resultMap[ $fullName ][ 'raceCount' ]++;
	if( !in_array( $record[ 'name' ], $eventNameList ) ) array_push( $eventNameList, $record[ 'name' ] );
	$eventName = isset( $resultMap[ $fullName ][ $record[ 'name' ] ] )? $record[ 'name' ] . 'dd':$record[ 'name' ] ;
	$resultMap[ $fullName ][ $eventName ]['percent'] = $record[ 'percent' ];
	$resultMap[ $fullName ][ $eventName ][ 'class' ] = $record[ 'Class' ];
	if ( !isset( $resultMap[ $fullName ][ 'defaultClass' ] ) ) $resultMap[ $fullName ][ 'defaultClass' ] = 'S';
    $resultMap[ $fullName ][ 'defaultClass' ] = $record[ 'Class' ] !== 'S' ? $record[ 'Class' ] : $resultMap[ $fullName ][ 'defaultClass' ] ;
	$resultMap[ $fullName ][ 'cat' ] = $record[ 'Gender' ] . " | " . $record[ 'Category' ];
	$resultMap[ $fullName ][ 'gender' ] = $record[ 'Gender' ];
	$resultMap[ $fullName ][ 'all' ] = 'All';
}

$sortedArray = array();
foreach ( $resultMap as $person => $values )
{
	$sortingArray = array();
    $sortingArray[ 'top5' ] = array();
	foreach( $values as $k => $v )
	{
		if ( stristr( $k, 'tnt:' ) !== false && isset( $v['percent'] ) )
        {
            if ( is_array( $sortingArray[ $_REQUEST[ 'group' ] ] ) )
    			array_push( $sortingArray[ $_REQUEST[ 'group' ] ], $v[$_REQUEST[ 'group' ]] );
            else {
                $sortingArray[ $_REQUEST[ 'group' ] ] = array( $v[ $_REQUEST[ 'group' ] ] );
            }
            array_push( $sortingArray[ 'top5' ], $v['percent'] );
            if ( $v[ 'class' ]  && $_REQUEST[ 'group' ] === 'class' )
            {
                if ( is_array( $sortingArray[ $v[ 'class' ] ] ) )
                    array_push ( $sortingArray[ $v[ 'class' ] ], $v['percent'] );
                else
                    $sortingArray[ $v[ 'class' ] ] = array( $v['percent'] );
            }
        }
	}
    foreach( $sortingArray as $k=>$array )
    {
        rsort( $sortingArray[ $k ] );
    }
	// Get the top FIVE scores for this rider
    for ( $i = 0; $i < 5 && $i < count( $sortingArray['top5'] ); $i++ )
    {
        $resultMap[ $person ][ 'top5' ] += $sortingArray['top5'][ $i ];
    }
    $groupkey = $resultMap[ $person ][$_REQUEST['group']];
    if ( $_REQUEST[ 'group' ] === 'class' ){
        $k = $resultMap[ $person ][ 'defaultClass' ];
            if ( $k === 'O' ) $k = 'Open';
            if ( $k === 'S' ) $k = 'Stock';
            if ( $k === 'T' ) $k = 'Tandem';
            $groupkey = $resultMap[ $person ][ 'gender' ] . " - $k";
    }
    $personkey = sprintf( "%08.3f", $resultMap[ $person ][ 'top5' ] ) . $person ;
	$sortedArray[ $groupkey ][ $personkey ][ 'person' ] = $person;
	$sortedArray[ $groupkey ][ $personkey ][ 'top5' ] = sprintf( "%08.3f", $resultMap[ $person ][ 'top5' ] );
}
ksort( $sortedArray );
for ( $i = 0; $i < count( $sortedArray ); $i++ )
{
    if ( is_array( $sortedArray[ $i ]  ) ) krsort( $sortedArray[ $i ] );
}

foreach( $sortedArray as $keys=>$vals )
{
    if ( is_array( $vals ) ) krsort( $vals );
}
echo "<table><tr><th>Rank</th><th>Name</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>Top 5</th></tr>";
foreach ( $sortedArray as $group=>$data )
{
    echo "<tr class='grouphead'><td colspan='11' style='text-align:center; font-weight: bold;'>$group</td></tr>";
    $rank = 1;
    krsort( $data );
    foreach ( $data as $key => $values )
    {
        $c = ( $rank % 2 === 0 ) ? "even" : "odd" ;
     //   if ( $values[ 'top5' ] < 100 ) continue;
        echo "<tr class='$c'><td >$rank</td><td>{$values[ 'person' ]}</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-01' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-01' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-01dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-01dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-02' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-02' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-02dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-02dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-03' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-03' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-03dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-03dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-04' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-04' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-04dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-04dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-05' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-05' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-05dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-05dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-06' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-06' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-06dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-061dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-07' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-07' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-07dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-07dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-08' ]['percent'] ) )
            ? number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-08' ]['percent']  , 2). "%"
            : "&nbsp;&nbsp;--";
        echo ( isset( $resultMap[$values[ 'person' ]][ 'TnT: 2013-08dd' ]['percent'] ) )
            ? "<br />" . number_format( $resultMap[$values[ 'person' ]][ 'TnT: 2013-08dd' ]['percent'], 2). "%"
            : "";
        echo "</td>";
        echo "<td>". number_format( $values[ 'top5' ], 3) ."</td>";
        echo "</tr>";
        $rank++;
    }
}
echo "</table>";
//$p = print_r( $sortedArray, true );
//echo "<pre>$p</pre>";
?>