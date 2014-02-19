<?php

$adminList = array( 'Events', 'Owners','Riders');
$actionList = array( 'List','Create');
foreach ( $adminList as $admin )
{
    echo "<div class='admin-section'><h2>$admin</h2>";
    echo "<ul>";
    foreach ( $actionList as $act ){
        echo "<li>";
        $pagename = $act == 'List' ? 'admin' : strtolower($act);
        echo CHtml::link($act, "../timing{$admin}/$pagename"  ) ;
        echo "</li>";
    }
    echo "</ul></div>";
}