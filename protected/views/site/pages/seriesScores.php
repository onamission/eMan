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
$isCategory = ( isset( $_REQUEST['group'] ) && $_REQUEST['group']==='category' )
    ? "checked='checked'"
    :'';
$isAll = ( $isGender == '' && $isClass == '' && $isCategory == '' )
    ? "checked='checked'"
    :'';
?>

<form>
    <input type="hidden" value="seriesScores" name="view" />
	<table ><tr>
	<th width='100px' style="text-align: right">Group By: </th>
    <td width="300px"><input type='radio' value='gender' name='group' <?php echo $isGender;?>> Gender |
        <input type='radio' value='cat' name='group' <?php echo $isCategory;?>> Category |
        <input type='radio' value='class' name='group' <?php echo $isClass;?>> Class |
        <input type="radio" name="group" value="all" <?php echo $isAll;?>>  All Riders</td></tr>
    </tr>
    <tr><td colspan="2" style="text-align: center"><input type="submit" value="Group" /></td></tr>
	</table>
</form>

<?php
$seriesScores = array();
$classList = array( );
for ( $i = 25; $i < 33; $i++ )
{
    $ride = TimingEvents::model()->find( 'id=:i', array( ':i' => $i ) );
    $scores = $ride->getFastestTimesInSecs();
    foreach( $scores as $key=>$score )
    {
        if ( is_array( $seriesScores[ $score[ 'name' ] ][ 'seriesTotal'] ) )
        {
            array_push( $seriesScores[ $score[ 'name' ] ][ 'seriesTotal'], $score[ 'score' ] );
        }else{
            $seriesScores[ $score[ 'name' ] ][ 'seriesTotal'] = array( $score[ 'score' ] );
        }
        $c = $score[ 'class' ];
        if ( $c == 'O' ) $c = 'Open';
        if ( $c == 'S' ) $c = 'Stock';
        if ( $c == 'T' ) $c = 'Tandem';
        $c = "{$score[ 'gender' ]} - $c";
        if ( !in_array( $c, $classList ) ) array_push ( $classList, $c );
        if ( is_array( $seriesScores[ $score[ 'name' ] ][ $c ] ) )
        {
            array_push( $seriesScores[ $score[ 'name' ] ][ $c ], $score[ 'score' ] );
        }else{
            $seriesScores[ $score[ 'name' ] ][ $c ] = array( $score[ 'score' ] );
        }
        if ( isset( $seriesScores[ $score[ 'name' ] ][ $ride->name ]['cat'] ) )
            $seriesScores[ $score[ 'name' ] ][ $ride->name  . '-dd']['cat']= $score[ 'cat' ];
        else
            $seriesScores[ $score[ 'name' ] ][ $ride->name ]['cat']= $score[ 'cat' ] ;

        if ( isset( $seriesScores[ $score[ 'name' ] ][ $ride->name ]['class'] ) )
            $seriesScores[ $score[ 'name' ] ][ $ride->name . '-dd' ]['class']= $c;
        else
            $seriesScores[ $score[ 'name' ] ][ $ride->name ]['class']= $c ;

        if ( isset( $seriesScores[ $score[ 'name' ] ][ $ride->name ]['gender'] ) )
            $seriesScores[ $score[ 'name' ] ][ $ride->name . '-dd' ]['gender']= $score[ 'gender' ];
        else
            $seriesScores[ $score[ 'name' ] ][ $ride->name ]['gender']= $score[ 'gender' ] ;

                if ( isset( $seriesScores[ $score[ 'name' ] ][ $ride->name ]['score'] ) )
            $seriesScores[ $score[ 'name' ] ][ $ride->name . '-dd' ]['score']= $score[ 'score' ];
        else
            $seriesScores[ $score[ 'name' ] ][ $ride->name ]['score']= $score[ 'score' ] ;
    }
}



// get top 5
foreach ( $seriesScores as $rider => $rider_scores )
{
    foreach( $rider_scores as $key => $v )
    {
        if ( stristr( $key, 'TnT' ) === false )
        {
            rsort( $v );
            ${$key} = 0;
            $counter = 1;
            foreach( $v as $s )
            {
                if ( $counter === 5 ) exit;
                if ( isset( $classList[ $key ][ $rider ] ) )
                    $classList[ $key ][ $rider ] += $s;
                else
                    $classList[ $key ][ $rider ] = $s;
                $counter++;
            }
   //echo "$rider = $key ..." .$values[ $i ] . "<br />";
        }
    }
}

foreach ( $classList as $class => $sc )
{
    if( is_array( $sc ) ) asort( $sc );
}
$p = print_r( $classList[ 'seriesScores' ], true );
echo "<pre>$p</pre>";

/*
$top5RidesList = array();


echo "<table><tr><th>Rank</th><th>Name</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>Top 5</th></tr>";
foreach ( $sortedArray as $group=>$data )
{
    echo "<tr class='grouphead'><td colspan='11' style='text-align:center; font-weight: bold;'>$group</td></tr>";
    $rank = 1;
    krsort( $data );
    foreach ( $data as $key => $values )
    {
        $c = ( $rank % 2 === 0 ) ? "even" : "odd" ;
        if ( $values[ 'top5' ] < 100 ) continue;
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


$p = print_r( $riderScores, true );
echo "<pre>$p</pre>";*/
?>
