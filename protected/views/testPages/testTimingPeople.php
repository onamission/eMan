<?php

Yii::app()->user->setState( 'mode', 'demo' );

            $eventId = 25 ;
            $myEvent = TimingEvents::model()->findByPk( $eventId );
            echo brUtils::convertSecondsToTime('30') . "<br />";



$rider = TimingRider::model()->findByPk( 52 );
echo "{$rider->name} has handicaps: Open = {$rider->getHandicap( 'O' )} and Stock {$rider->getHandicap( 'S' )} with {$rider->getFastestTime()}";
$p = print_r( $rider , true );
echo "<pre>$p</pre>";
/*
$e = TimingEvents::model()->findByPk( 1 )
;
$rider = $e->getWinner( 'scratch' );
echo $rider->name . " id " . $rider->id;*/
//$e = TimingEvents::model()->findByPk( 1 );
//$p = print_r ( $e, true );
//echo "<pre>$p</pre>";

/*for ( $i= 257; $i < 300; $i++ )
{
    $p = TimingRider::model()->findByPk( $i );
    echo $p->name . "'s last race was " . date( 'Y-m-d', strtotime( $p->getLastRace() ) ) ;
    echo " and fastest time is " . $p->getFastestTime() ;
    echo " and handicap is " . $p->getHandicap() . "<br />";
}*/


/*$fullCount = rand( 20, 30 );
        $halfCount = rand( 10, 20 );
        $allRiders = TimingRider::model()->findAll();
        $allCount = count( $allRiders );
        die ( $allCount );
        for( $i = 0; $i < $fullCount; $i++ )
        {
            $randRider = $allRiders[ rand( 0, $allCount) ];
            $randRider->attrMap[ 'credit' ] = 8;
            $randRider->save();
            echo "<br />{$randRider->name} has a full pass";
        }

        for( $i = 0; $i < $halfCount; $i++ )
        {
            $randRider = $allRiders[ rand( 0, $allCount) ];
            $randRider->attrMap[ 'credit' ] = 4;
            $randRider->save();
            echo "<br />{$randRider->name} has a half pass";
        }

       */
//echo "<br />";
//echo $p->getFastestTime();
//$p = TimingRider::model()->findByPk( 221 );
//$d = print_r ( $p, true ) ;
//echo ( "<pre>$d</pre>" );

//testGetAllObjectData( 'TimingRider', 202 );
//testInputLogin();
//testGetLoginData(200);
//testImportRiders('string');


//loadRiderDetails();


//testGetAllObjectData( 'TimingRider', 202 );
//$r = TimingRider::model()->findByPk( 192 );
//echo "<br /> Done";
/*
$r = TimingDetails::getAttributeList ( 'TimingRider' );
$p = print_r( $r, true );
echo ( "<pre>$p</pre>");
*/


function testGetAllObjectData( $parent_object, $parent_id )
{
    $returnList = $parent_object::getAllAttributes( $parent_object, $parent_id );
    $p= print_r( $returnList, true );
    echo "<pre>$p</pre>";
}

function getAllRiders()
{
    $riders = TimingRider::model()->findAll();
        foreach ( $riders as $rider )
        {
            echo "<hr />{$rider->last_name}, {$rider->first_name}<br />";
            echo $rider->getContactElement( 'email','home')->value;
            echo "<br />".$rider->getAttributeValue( 'gender' );
            $addr=$rider->getAddress( 'home' );
            echo "<br />{$addr['street']}";
            echo "<br />{$addr['city']}";
            echo "<br />{$addr['state']}";
            echo "<br />{$addr['zip']}";
        }
}


function testGetLoginData( $user_id )
{
    //$rider = TimingRider::model()->findByPk( $user_id );
    $login = ActiveRecordWithAttributes::getLoginElement( $user_id,'username' );
    echo "username = {$login['username']} : password = {$login['password']}";
}

function testSetRiderContactData()
{
    $riderElement = $rider->getContactIdByTag( 'home' );
    $riderAddr = $rider->getAddress( 'home' );
    foreach ( $riderAddr as $addr=>$value )
    {
        echo "<br /> $addr = $value";
    }

    $rider->saveContactAttribute( "email", "work", "tim.turnquist@bluewaterbrand.com");
    $rider->saveContactAttribute( "phone", "home", "952-938-0586");
    $rider->saveContactAttribute( "phone", "cell", "952-220-1660");
    $rider->saveContactAttribute( "email", "home", "tim.turnquist@gmail.com");

    $rider->saveAddress( 'cabin', '12365 Elm Logs', 'Woodruff', 'WI');
    $rider->saveAddress( 'home', '4921 Royal Oaks Dr.', 'Minnetonka', 'MN');

    $riderElement = $rider->getContactIdByTag( 'cabin' );
    $riderAddr = $rider->getAddress( 'cabin' );
    foreach ( $riderAddr as $addr=>$value )
    {
        echo "<br /> $addr = $value";
    }
}

function testInputLogin()
{
    $rider = TimingRider::model()->findByPk(205);
    echo $rider->saveLoginAttributes( 1, 'tturnquist', 'hope4@ll' ) . "<br />";
}

function testInputEventAttributes()
{
   $event = TimingEvents::model()->findByPk( 1 );
   $event->saveClassList( "Open, Stock, Team");
   $event->saveCategoryList( "Team, <20, 20-29, 30-39, 40-49, 50-59,60+");
   echo $event->getClassList(). "<br />";
   echo $event->getCategoryList();
}

function testImportRiders( $inputType )
{
    //$inputType = 'file';

    $inputString = <<<EOD
    nameLastFirst,ignore,rider_defaultCategory,rider_gender,rider_defaultClass,rider_team,rider_contact_email,
"Roddy, Mike",,30s,Male,Open,,,
"Meyer, Dan",61,60+,Male,Open,,,
Ludwigson David,57,50s,Male,Open,,,
"Knowlton, Steven",60,60+,Male,Open,Silver Cycling,,
"Turnquist, Tim",49,40s,Male,Stock,,,
"Hawes, Christopher",38,30s,Male,Open,,hawes_c@hotmail.com,
"Maki, Robert",,50s,Male,Open,Big Ring Flyers,rlmaki@sbcglobal.net,
Team RBA,,,Male,T,,,
"Fiske, Richard",41,40s,Male,Open,,,
"Lemm-Tabor, Brook",60,60+,Female,Stock,,patricialemm@yahoo.com,
"Nelson, Dale",46,40s,Male,Open,,dale.nelson@hilton.com,
"Heffernan, Dave",60,60+,Male,Open,,,
"Lyner, Mike",,50s,Male,Open,,jarlich@gmail.com,
"Snaza, Tammy",,30s,Female,Stock,,,
"Snaza, Jenna",,-20,Female,Stock,,,
"Storm, Danny",,30s,Male,Stock,,,
"Rosen, Mark",48,40s,Male,Open,,mark_rosen8863@hotmail.com,
"Snaza, Brad",38,30s,Male,Open,,snaz9000@comcast.net,
"Olson, Eric",,30s,Male,Open,,eric@processtype.com,
"Zemke, Tom",50,50s,Male,Open,,tzemke@usa.net,
"Larson, Ryan",,30s,Male,Open,,,
"Kosfeld, Bill",68,60+,Male,Open,,kosfe001@umn.edu,
"Lundquist, David",50,50s,Male,Open,Ramsey Cycle,plutodave@comcast.net,
"Keilen, Mary",,40s,Female,,,,
"Elton, David",51,50s,Male,Open,GearWest,bdelton5@comcast.net,
"Englert, Leslie",44,40s,Female,Stock,,glenglertv1@msn.com,
"Lavick, Gergory",49,40s,Male,Open,,,
"Rosetta, Vince",35,30s,Male,Open,,vrosetta@gmail.com,
"Digman, Jason",39,40s,Male,Open,,,
"Boiarsky, Lynne",45,40s,Female,Stock,,,
"Nelson, Kevin",41,40s,Male,Open,,,
"Gray, Steven",40,40s,Male,Stock,Birchwood,fsgray@mail2web.com,
"Donzella, Bonny",46,40s,Female,Open,Bianchi/Grand Performance - SPBRC,donze001@umn.edu,
"Carlson, Jey",44,40s,Male,Open,Bianchi/Grand Performance - SPBRC,,
"Kozub, Roger",50,50s,Male,Stock,,R_KOZUB@YAHOO.COM,
"Stamm, John",60,60+,Male,Open,Loon State,stamm@crccs.com,
"Hager, Anika",,-20,Female,Open,,,
"Hager, Derek",50,50s,Male,Open,,,
"Phillips, David",26,20s,Male,Open,,,
"Hoang, Carl",,50s,Male,Open,,me_xman@yahoo.com,
"Olheiser, David",38,30s,Male,Open,,doalpine@yahoo.com,
"Pasdo, Michael",,40s,Male,Open,,,
"Schonhardt, Larry",53,50s,Male,Open,,larry.schonhardt@gmail.com,
"Deering, John",,40s,Male,Open,,,
"Stoller, Diane",,50s,Female,Open,,,
"Hughes, Jill",37,30s,Female,Open,,,
"Holmberg, Robert",,20s,Male,Stock,Balance,oronograd@yahoo.com,
"Ratzlaff, Justin",,20s,Male,Stock,,jatzju01@luther.edu,
"Dolan, Brendan",,30s,Male,Open,,,
"Webster, Pete",39,30s,Male,Open,,peteweb55403@msn.com,
"Ogren, Robert",61,60+,Male,Open,Kenwood Racing,rbrtogrn@gmail.com,
"Lovaas, Brett",35,30s,Male,Open,Gear West,brettlovaas@q.com,
"Anderson, David",,50s,Male,Stock,,,
"Hansen, Boyd",42,40s,Male,Stock,Joel fix first race (last name spelling,,
"Toftoy, Andrew",,20s,Male,Open,,,
"Casper, Daniel",44,40s,Male,Open,GrandStay Hotels,dcasper8@hotmail.com,
"Toftoy, Jonathan",29,30s,Male,Open,Synergy,jontoftoy@gmail.com,
"Meyer, Desta",,30s,Female,Open,Silver Cycling,,
"Millner, Chad",35,30s,Male,Open,GearWest,,
"Walker, Tim",44,40s,Male,Open,,adrnaln4me@aol.com,
"Johnson, Sarah",,30s,Female,Open,,sarah711@usfamily.net,
"Mulrooney, Tim",45,40s,Male,Open,Synergy,mulrooney.tim@gmail.com,
"Descotte, Veronica",31,30s,Female,Open,,,
"Williams, Dustin",37,20s,Male,Stock,,,
"Shishilla, John",51,50s,Male,Open,SPBRC,shishillaj@yahoo.com,
"Dailey, Ryan",,,Male,Open,,,
"Hawkinson, Adam",49,40s,Male,Stock,IC3,,
"Wilk, Darrell",,60+,Male,Open,,,
"Boelke, Joel",39,30s,Male,Open,,,
Team Toftoy,,,Male,Open,,,
"Zemke, Jay",46,40s,Male,Open,,,
"Perleberg, Paul",46,40s,Male,Open,,paulperleberg@comcast.net,
"Roeser, Josh",33,30s,Male,Open,Nature Valley/Penn Cycle,joshroeser@yahoo.com,
"Mitchell, Carlton",,40s,Male,Open,,,
"Pettersen, Cleve",66,60+,Male,Open,Flanders,cpettersens@msn.com,
"Hilgren, Renee",45,40s,Female,Open,,r.hilgren@hotmail.com,
"Madden, Bill",49,40s,Male,Open,First Light,whmadden@gmail.com,
"Hilligoss, Jeff",47,40s,Male,Open,Silver Cycling,jeff.hilligoss@gt-cs.com,
"Cortright-Cadogan, Meg",42,40s,Female,Open,Birchwood,megcortright@gmail.com,
"Bolinske, Michael",35,30s,Male,Open,,,
"DiLuzio, Damian",,30s,Male,Open,,Diluzio123@hotmail.com,
"Peterson, Jeff",34,30s,Male,Open,,jfptrson@hotmail.com,
"Chimerakis, Nick",29,20s,Male,Open,,nchimerakis@deloitte.com,
"Oolman, Tim",58,50s,Male,Open,,toolman1954@gmail.com,
"Plant, Paula",,40s,Female,Open,,paula.plant@bsci.com,
"Kuller, Hart",60,60+,Male,Open,Grand Performance,hkuller@winthrop.com,
"Barnes, Ryan",,30s,Male,Open,,ryanb@smcduct.com,
"Scheurich, Mike",,40s,Male,Stock,,mike@scheurich.org,
"Taipale, John",,20s,Male,Open,,,
"Ruud, Christian",,-20,Male,Open,St Olaf Tri,,
"Olson, Jeff",,40s,Male,Open,,,
"Kadera, Aaron",28,30s,Male,Open,Gopher Wheelmen,xen355@hotmail.com,
"Stensrud, Mike",50,50s,Male,Stock,Flat City,,
"Helmbrecht, Jake",,30s,Male,Stock,Freewheel,,
"Ocheiser, Valerie",37,30s,Female,Stock,,,
"Bungarten, Benjamin",25,20s,Male,Stock,,,
"Thomas, Conrade",,40s,Male,Stock,,,
"Mittlesteadt, Michael",,20s,Male,Open,St Olaf Tri,,
"Lunde, David",47,40s,Male,Open,MNJRS,,
"Owen, Clifford",39,40s,Male,Open,,cliffordowen1@msn.com,
"Nilson, Lois",,20s,Female,Stock,,,
"Ingham, Jeff",41,40s,Male,Open,,,
"Windhurst, Becca",28,20s,Female,Stock,,,
"Pellicano, Danielle",32,30s,Female,Stock,,,
"Huso, Holly",48,40s,Female,Stock,,,
"Krska, Gary",54,50s,Male,Open,,,
"Voss, Jill",,40s,Female,Stock,,,
"Dolman, Timothy",58,50s,Male,Open,,,
"Stocker, Nordica",26,20s,Female,Open,,,
"Warne, Mike",41,40s,Male,Stock,,mike.warne@tec-llc.com,
"Byland, Stephanie",39,30s,Female,Open,,,
"Johannes, Brad",43,40s,Male,Stock,,,
"Kylander, Paul",73,60+,Male,Open,,,
"DeLeeuw, Nicholas",,40s,Male,Open,,,
"Grafa, Adam",,30s,Male,Open,,adamgrafa@yahoo.com,
"Schiesl, Andy",,30s,Male,Open,,,
"Vogel, Alexander",18,-20,Male,Open,,agvogel2@hotmail.com,
"Williams, Frank",60,60+,Male,Open,,,
"Collins, Bethany",55,50s,Female,Open,,,
"Peterson, David",,40s,Male,Open,,,
"Kingsley, Robert",54,50s,Male,Open,,,
"Dykes, Mark",43,40s,Male,Open,,,
"Johnson, Ben",,30s,Male,Stock,,,
"Essma, Nick",45,40s,Male,Open,,,
"Bates, Jason",35,30s,Male,Open,,,
"Sidwell, Kevin",38,30s,Male,Open,Peace Coffee,,
"Johnson, Joe",,30s,Male,Open,,,
"Christenson, Rick",,50s,Male,Open,,pamc@goldengate.net,
"Hanenberg, Amy",39,30s,Female,Open,,,
"Kline, Amy",47,40s,Female,Open,Bianchi/Grand Performance - SPBRC,amykline007@yahoo.com,
"Schinke, Ben",35,30s,Male,Open,,benschinke@gmail.com,
"Olheiser, Valerie",36,30s,Female,Stock,,,
"Aboobaker, Asad",39,30s,Male,Open,,asad137@gmail.com,
"Parker, James",,40s,Male,Open,,,
Dave Gray,50,50s,Male,Open,,,
"Cullen, Jim",43,40s,Male,Open,MBRC/Flanders,j.cullen@sbcglobal.net,
"Cullen, Jordan",15,-20,Male,Open,MBRC/Flanders,jordan.cullen@sbcglobal.net,
"Bootsma, Claire",,20s,Female,Open,,,
"Johnson, Amy",,40s,Female,Open,iIC3,,
"Johnson, Dallas",46,40s,Male,Open,,dallas@dallasjohnson.net,
"Swanson, Matt",,30s,Male,Stock,,,
"Binder, Cory",39,30s,Male,Stock,,cory.binder@gmail.com,
"Cray, Mike",52,50s,Male,Stock,,,
Michael O'Day,48,40s,Male,Stock,,,
"McCrome, Gina",50,50s,Female,Stock,,,
Townsend Tandem,,50s,T,T,,ssbt123@aol.com,
"Snyder, Robson",36,30s,Male,Stock,,robson.snyder@gmail.com,
"Delins, Andris",,-20,Male,Stock,,,
"Quealy, Micheal",64,60+,Male,Open,,,
"Anderson, Katie",23,20s,Female,Open,GT,gusty427@gmail.com,
"Finger, Suzie",26,20s,Female,Open,GearWest,suziemarie13@gmail.com,
"Knapp, Byron",,30s,Male,Stock,,trent_fragile@yahoo.com,
"Smart, Jon",50,50s,Male,Open,,jsmart@crayfish.com,
"Grady, John",44,40s,Male,Open,,john@asinglevoice.us,
"Oslin, Kit",42,40s,Female,Open,Bianchi/Grand Performance - SPBRC,kiatonda@hotmail.com,
"Weisbecker, Julia",44,40s,Female,Open,GearWest,jmwrides@gmail.com,
"Phung, Andrew",24,20s,Male,Stock,,Phung.andrew@gmail.com,
"Madden, Mike",58,50s,Male,Stock,First Light,,
"Sundberg, Laurel",32,30s,Female,Open,,,
"Richard, Weisbecker",,50s,Male,Open,,richweisbecker@yahoo.com,
"Trench, Bob",52,50s,Male,Open,,,
Ludwigson Tandem,,50s,T,T,Loon State,,
"Corty, Bill",66,60+,Male,Open,,,
"Henderson, Kristy",30,30s,Female,Open,Silver Cycling,,
"Carlson, Jacklyn",36,30s,Female,Open,Silver Cycling,,
"Henderson, Jay",40,40s,Male,Open,Silver Cycling,,
"Ross, Dan",47,40s,Male,Open,,,
"Barkema, Doug",35,30s,Male,Open,TeamFCA Endurance,,
"Sone, Linda",,30s,Female,Stock,,,
"Schmidt, Randel",49,40s,Male,Stock,,,
"Sullivan, Hannah",,30s,Female,Open,GearWest,hannah@gearwestbike.com,
"Christiaansen, Matthew",38,30s,Male,Open,Big Ring Flyers,christiaansen@hotmail.com,
"Abrahamson, Sue",,40s,Female,Open,,sueabrahamson@yahoo.com,
"Blair, Mike",,30s,Male,Open,,Mike.Blair@mchsi.com,
"Cota, Becca",,20s,Female,Open,,BeccaCota@gmail.com,
"Talbot, Mitchel",,30s,Male,Open,,,
"Callender, Don",51,50s,Male,Stock,,,
"Stensrud, Aanya",14,-20,Female,Stock,,,
"Scholz, Andreas",46,40s,Male,Stock,,,
"Warner, Dustin",45,40s,Male,Stock,,,
"Bergstrom, Eric",32,30s,Male,Open,,,
Ringvette Jim,41,40s,Male,Open,,lnilson@att.net,
"Kline, Dan",46,40s,Male,Stock,,,
"Rew, Andrew",44,40s,Male,Stock,,,
"Stiller, Shayne",45,40s,Male,Stock,,,
"Wilk, David",37,30s,Male,Stock,,,
"Nilson, Lois",,50s,Female,Open,,,
"Baker, Kristen",34,30s,Female,Stock,,,
"Linebaugh, Charis",,30s,Female,Open,,,
"Moen, Jesse",,30s,Male,Open,,,
"Guertin, Chris",,40s,Male,Open,,,
"Hoenie, Mike",,30s,Male,Open,,mstravelr@hotmail.com,
"Scholz, Jeannie",,40s,Female,Stock,,darrell.wilk@gmail.com,
"Axelson, Nancy",,40s,Female,Stock,,lileuphy@gmail.com,
"Kent, Tracie",,30s,Female,Open,,,
"Alstrand, Louis",,50s,Male,Open,,,
"Donzella, Ben",,60+,Male,Open,,,
"Donzella, Red",,60+,Female,Stock,,,
"Shupe, Jeff",,40s,Male,Open,,,
"Cravens, Todd",,50s,Male,Open,,,
"Wirt, Mark",,50s,Male,Open,,,
"Petersen, Matt",,20s,Male,Stock,,,
"Tidstrom, Kyle",,50s,Male,Open,,,
"Kermisch, Mark",,30s,Male,Open,,,
"Baker, Jeremy",`,30s,Male,Stock,,,
EOD;

/*        '"first_name", "last_name", "rider_contact_home_address", "rider_contact_home_email", "rider_contact_home_phone", "rider_gender", "rider_defaultClass", "rider_defaultCategory"'."\n"
        .'"Bob", "Fletcher", "1234 Pickles Rd, Chickenville, TN, 33445", "bob@pickles.com", "123-456-7890", "Male", "Open","30s"'."\n"
        .'"Rob", "Catch", "1234 Pickles Rd, Chickenville, TN, 33445", "rob@pickles.com", "123-456-7890", "Male", "Stock","40s"'."\n"
        .'"Bob", "Metcher", "1234 Pickles Rd, Chickenville, TN, 33445", "bob@pickles.com", "123-456-7890", "Male", "Stock","20s"'."\n"
        .'"Gob", "Dreatcher", "1234 Pickles Rd, Chickenville, TN, 33445", "gob@pickles.com", "123-456-7890", "Female", "Open","30s"'."\n"
        .'"Dob", "Munetcher", "1234 Pickles Rd, Chickenville, TN, 33445", "dob@pickles.com", "123-456-7890", "Female", "Stock",20s"'*/



    $input = ( $inputType == 'string') ?$inputString : $inputType;
    $status = TimingRider::importRiders("1", $input, $inputType );
//    echo "$status";
}

function loadRiderDetails()
{
    $week = array();
    $week[8] = <<<EOD
58,Toftoy,Jonathan,30-39,O,0:22:40
56,Toftoy,Andrew,20-29,O,0:22:51
57,Casper,Daniel,40-49,O,0:23:25
63,Mulrooney,Tim,40-49,O,0:23:53
18,Olson,Eric,30-39,O,0:24:09
27,Rosetta,Vince,30-39,O,0:24:14
38,Phillips,David,20-29,O,0:24:57
60,Millner,Chad,30-39,O,0:25:00
2,Ludwigson David,50-59,O,0:25:01
40,Olheiser,David,30-39,O,0:25:03
66,Shishilla,John,50-59,O,0:25:09
53,Lovaas,Brett,30-39,O,0:25:24
28,Digman,Jason,40-49,O,0:25:30
17,Snaza,Brad,30-39,O,0:25:31
67,Dailey,Ryan,,O,0:25:31
26,Lavick,Gergory,40-49,O,0:25:42
37,Hager,Derek,50-59,O,0:25:52
6,Maki,Robert,50-59,O,0:25:57
20,Larson,Ryan,30-39,O,0:26:11
24,Elton,David,50-59,O,0:26:25
10,Nelson,Dale,40-49,O,0:26:26
43,Deering,John,40-49,O,0:26:30
3,Knowlton,Steven,60+,O,0:26:36
0,Roddy,Mike,30-39,O,0:26:44
8,Fiske,Richard,40-49,O,0:26:52
50,Ogren,Robert,60+,O,0:26:57
30,Nelson,Kevin,40-49,O,0:27:04
41,Pasdo,Michael,40-49,O,0:27:25
48,Dolan,Brendan,30-39,O,0:27:27
33,Carlson,Jey,40-49,O,0:27:32
35,Stamm,John,60+,O,0:27:50
12,Lyner,Mike,50-59,O,0:28:06
1,Meyer,Dan,60+,O,0:28:06
42,Schonhardt,Larry,50-59,O,0:28:23
16,Rosen,Mark,40-49,O,0:28:33
61,Walker,Tim,40-49,O,0:28:34
21,Kosfeld,Bill,60+,O,0:28:38
5,Hawes,Christopher,30-39,O,0:29:14
49,Webster,Pete,30-39,O,0:29:16
19,Zemke,Tom,50-59,O,0:29:38
39,Hoang,Carl,50-59,O,0:30:53
69,Wilk,Darrell,60+,O,0:31:29
11,Heffernan,Dave,60+,O,0:33:01
32,Donzella,Bonny,40-49,O,0:26:59
22,Keilen,Mary,40-49,O,0:27:27
44,Stoller,Diane,50-59,O,0:29:29
59,Meyer,Desta,30-39,O,0:29:29
64,Descotte,Veronica,30-39,O,0:31:06
23,Keilen,Mary,40-49,O,0:30:26
45,Hughes,Jill,30-39,O,0:31:38
62,Johnson,Sarah,30-39,O,0:33:29
36,Hager,Anika,U20,O,0:35:17
25,Englert,Leslie,40-49,S,0:30:38
13,Snaza,Tammy,30-39,S,0:31:04
29,Boiarsky,Lynne,40-49,S,0:33:12
9,Lemm-Tabor,Brook,60+,S,0:34:27
14,Snaza,Jenna,_U20,S,0:41:13
46,Holmberg,Robert,20-29,S,0:26:01
55,Hansen,Boyd,40-49,S,0:27:30
4,Turnquist,Tim,40-49,S,0:27:58
47,Ratzlaff,Justin,20-29,S,0:28:11
15,Storm,Danny,30-39,S,0:29:01
68,Hawkinson,Adam,40-49,S,0:29:07
34,Kozub,Roger,50-59,S,0:29:24
31,Gray,Steven,40-49,S,0:29:24
54,Anderson,David,50-59,S,0:30:40
65,Williams,Dustin,20-29,S,0:36:26
EOD;

    $week[7] = <<<EOD
62,Roeser,Josh,30s,Open,0:23:20
25,Olson,Eric,30s,Open,0:23:58
22,Olheiser,David,30s,Open,0:24:04
55,Mulrooney,Tim,40s,Open,0:24:06
47,Rosetta,Vince,30s,Open,0:24:08
63,Shishilla,John,50s,Open,0:24:36
16,Hager,Derek,50s,Open,0:25:15
14,Ludwigson David,50s,Open,0:25:17
28,Phillips,David,20s,Open,0:25:20
58,Digman,Jason,40s,Open,0:25:26
60,Millner,Chad,30s,Open,0:25:27
26,Bolinske,Michael,30s,Open,0:25:35
46,Lavick,Gergory,40s,Open,0:25:43
20,Snaza,Brad,30s,Open,0:25:49
24,Taipale,John,20s,Open,0:25:56
33,Larson,Ryan,30s,Open,0:25:56
27,Ruud,Christian,_-20,Open,0:25:57
37,Elton,David,50s,Open,0:26:01
42,Carlson,Jey,40s,Open,0:26:16
11,Fiske,Richard,40s,Open,0:26:17
5,Kuller,Hart,60+,Open,0:26:25
21,Nelson,Dale,40s,Open,0:26:26
17,Deering,John,40s,Open,0:26:32
61,Mittlesteadt,Michael,20s,Open,0:26:33
7,Lovaas,Brett,30s,Open,0:26:47
15,Meyer,Dan,60+,Open,0:27:06
30,Stamm,John,60+,Open,0:27:29
39,Ogren,Robert,60+,Open,0:27:30
52,Lundquist,David,50s,Open,0:27:40
51,Schonhardt,Larry,50s,Open,0:27:48
56,Walker,Tim,40s,Open,0:27:55
31,Perleberg,Paul,40s,Open,0:28:02
10,Kosfeld,Bill,60+,Open,0:28:07
34,Kadera,Aaron,30s,Open,0:28:24
32,Olson,Jeff,40s,Open,0:28:40
19,Rosen,Mark,40s,Open,0:28:41
8,Barnes,Ryan,30s,Open,0:29:16
6,Hawes,Christopher,30s,Open,0:29:30
45,Hoang,Carl,50s,Open,0:29:48
1,Zemke,Tom,50s,Open,0:29:55
29,Wilk,Darrell,60+,Open,0:31:06
2,Zemke,Jay,40s,Open,0:31:45
35,Heffernan,Dave,60+,Open,0:32:35
41,Donzella,Bonny,40s,Open,0:26:48
4,Plant,Paula,40s,Open,0:28:11
59,Meyer,Desta,30s,Open,0:29:31
9,Stoller,Diane,50s,Open,0:30:20
43,Hughes,Jill,30s,Open,0:31:22
38,Johnson,Sarah,30s,Open,0:34:09
36,Stensrud,Mike,50s,Stock,0:26:49
54,Hansen,Boyd,40s,Stock,0:28:05
57,Thomas,Conrade,40s,Stock,0:28:10
44,Kozub,Roger,50s,Stock,0:28:54
53,Ratzlaff,Justin,20s,Stock,0:28:54
23,Storm,Danny,30s,Stock,0:28:57
40,Gray,Steven,40s,Stock,0:28:59
48,Helmbrecht,Jake,30s,Stock,0:29:05
50,Bungarten,Benjamin,20s,Stock,0:30:00
18,Scheurich,Mike,40s,Stock,0:30:33
12,Snaza,Tammy,30s,Stock,0:30:35
49,Ocheiser,Valerie,30s,Stock,0:31:34
3,Lemm-Tabor,Brook,60+,Stock,0:33:42
13,Snaza,Jenna,_-20,Stock,0:42:45
EOD;

$week[6] = <<<EOD
61,Roeser,Josh,30s,Open,0:23:01
5,Mulrooney,Tim,40s,Open,0:23:58
62,Shishilla,John,50s,Open,0:24:15
27,Olson,Eric,30s,Open,0:24:25
9,Rosetta,Vince,30s,Open,0:24:43
24,Hager,Derek,50s,Open,0:24:51
50,Millner,Chad,30s,Open,0:25:02
45,Lovaas,Brett,30s,Open,0:25:05
8,Lavick,Gergory,40s,Open,0:25:26
46,Hilligoss,Jeff,40s,Open,0:25:30
33,Phillips,David,20s,Open,0:25:37
54,Digman,Jason,40s,Open,0:25:44
30,Ludwigson David,50s,Open,0:25:44
47,Larson,Ryan,30s,Open,0:25:50
64,Boelke,Joel,30s,Open,0:26:06
18,Snaza,Brad,30s,Open,0:26:13
39,Elton,David,50s,Open,0:26:16
10,Nelson,Dale,40s,Open,0:26:25
56,Tidstrom,Kyle,50s,Open,0:26:48
6,Fiske,Richard,40s,Open,0:26:54
14,Chimerakis,Nick,20s,Open,0:26:55
2,Krska,Gary,50s,Open,0:26:56
11,Lunde,David,40s,Open,0:27:06
55,Younes,Michael,30s,Open,0:27:07
38,Lundquist,David,50s,Open,0:27:08
21,Carlson,Jey,40s,Open,0:27:16
35,Kadera,Aaron,20s,Open,0:27:22
48,Ogren,Robert,60+,Open,0:27:24
26,Owen,Clifford,40s,Open,0:27:26
52,Walker,Tim,40s,Open,0:27:29
31,Meyer,Dan,60+,Open,0:27:30
22,Oestreich,Christian,30s,Open,0:27:37
13,Stamm,John,60+,Open,0:27:54
43,Talbot,Mitchel,30s,Open,0:28:15
37,Schonhardt,Larry,50s,Open,0:28:32
57,Quealy,Micheal,60+,Open,0:28:33
20,Rosen,Mark,40s,Open,0:28:49
44,Barnes,Ryan,30s,Open,0:28:51
60,Williams,Frank,60+,Open,0:29:14
34,Dolan,Brendan,30s,Open,0:29:18
7,Olson,Jeff,40s,Open,0:29:24
1,Pettersen,Cleve,60+,Open,0:29:46
23,Kosfeld,Bill,60+,Open,0:30:05
41,Hoang,Carl,50s,Open,0:30:06
3,Zemke,Tom,50s,Open,0:30:20
32,Kylander,Paul,60+,Open,0:32:39
4,Zemke,Jay,40s,Open,0:33:00
29,Heffernan,Dave,60+,Open,0:34:08
19,Donzella,Bonny,40s,Open,0:27:09
59,Descotte,Veronica,30s,Open,0:30:41
49,Meyer,Desta,30s,Open,0:31:02
25,Hughes,Jill,30s,Open,0:31:57
53,Petersen,Matt,20s,Stock,0:25:30
28,Holmberg,Robert,20s,Stock,0:26:06
51,Hansen,Boyd,40s,Stock,0:28:15
16,Storm,Danny,30s,Stock,0:28:41
58,Turnquist,Tim,40s,Stock,0:29:22
42,Kozub,Roger,50s,Stock,0:29:54
15,Scheurich,Mike,40s,Stock,0:31:02
40,Anderson,David,50s,Stock,0:31:07
36,Johannes,Brad,40s,Stock,0:34:06
17,Snaza,Tammy,30s,Stock,0:30:46
12,Lemm-Tabor,Brook,60+,Stock,0:34:31
EOD;

$week[5] = <<<EOD
40,Casper,Daniel,40s,Open,0:23:07
41,Roeser,Josh,30s,Open,0:23:50
16,Olson,Eric,30s,Open,0:24:36
17,Rosetta,Vince,30s,Open,0:24:55
45,Shishilla,John,50s,Open,0:25:30
21,Olheiser,David,30s,Open,0:26:02
28,Nelson,Dale,40s,Open,0:26:11
15,Snaza,Brad,30s,Open,0:26:11
38,Lundquist,David,50s,Open,0:26:23
33,Digman,Jason,40s,Open,0:26:29
20,Deering,John,40s,Open,0:26:34
32,Elton,David,50s,Open,0:26:39
10,Larson,Ryan,30s,Open,0:26:42
36,Nelson,Kevin,40s,Open,0:26:43
5,Krska,Gary,50s,Open,0:26:44
19,Maki,Robert,50s,Open,0:26:46
7,Cravens,Todd,50s,Open,0:26:55
4,Kuller,Hart,60+,Open,0:26:58
39,Wirt,Mark,50s,Open,0:27:02
23,Rosen,Mark,40s,Open,0:28:34
6,Shupe,Jeff,40s,Open,0:28:40
18,Schonhardt,Larry,50s,Open,0:29:01
34,Oolman,Tim,50s,Open,0:29:13
43,Williams,Frank,60+,Open,0:29:49
11,Moen,Jesse,30s,Open,0:29:50
1,Pettersen,Cleve,60+,Open,0:29:58
30,Hoang,Carl,50s,Open,0:30:29
2,Zemke,Tom,50s,Open,0:30:52
8,Alstrand,Louis,50s,Open,0:32:46
12,Heffernan,Dave,60+,Open,0:32:50
26,Donzella,Ben,60+,Open,0:33:25
3,Zemke,Jay,40s,Open,0:34:17
24,Chimerakis,Nick,20s,Open,
25,Donzella,Bonny,40s,Open,0:27:58
9,Kent,Tracie,30s,Open,0:28:57
42,Descotte,Veronica,30s,Open,0:31:10
29,Kozub,Roger,50s,Stock,0:30:00
37,Hansen,Boyd,40s,Stock,0:30:07
13,Scheurich,Mike,40s,Stock,0:30:37
35,Anderson,David,50s,Stock,0:30:45
44,Baker,Jeremy,30s,Stock,0:32:53
14,Snaza,Tammy,30s,Stock,0:30:31
31,Boiarsky,Lynne,40s,Stock,0:33:52
22,Lemm-Tabor,Brook,60+,Stock,0:35:28
27,Donzella,Red,60+,Stock,0:39:42
EOD;

$week[4] = <<<EOD
65,Shishilla,John,50s,Open,0:24:24
38,Rosetta,Vince,30s,Open,0:24:37
32,Olson,Eric,30s,Open,0:24:39
27,Madden,Bill,40s,Open,0:25:03
23,Ludwigson David,50s,Open,0:25:04
58,Olheiser,David,30s,Open,0:25:13
64,Lovaas,Brett,30s,Open,0:25:13
57,Phillips,David,20s,Open,0:25:24
53,Hager,Derek,50s,Open,0:25:33
36,Snaza,Brad,30s,Open,0:25:52
48,Elton,David,50s,Open,0:26:10
24,Nelson,Dale,40s,Open,0:26:11
43,Carlson,Jey,40s,Open,0:26:12
28,Fiske,Richard,40s,Open,0:26:13
40,Larson,Ryan,30s,Open,0:26:25
34,Owen,Clifford,40s,Open,0:26:40
37,Knowlton,Steven,60+,Open,0:26:46
45,Lundquist,David,50s,Open,0:26:57
46,Lunde,David,40s,Open,0:27:08
67,Boelke,Joel,30s,Open,0:27:09
22,Meyer,Dan,60+,Open,0:27:58
31,Lyner,Mike,50s,Open,0:28:15
51,Grafa,Adam,30s,Open,0:28:15
56,Walker,Tim,40s,Open,0:28:22
60,Guertin,Chris,40s,Open,0:28:41
42,Schonhardt,Larry,50s,Open,0:28:46
63,Barnes,Ryan,30s,Open,0:29:12
21,Pettersen,Cleve,60+,Open,0:29:39
59,Williams,Frank,60+,Open,0:29:40
26,Kosfeld,Bill,60+,Open,0:29:58
44,Webster,Pete,30s,Open,0:30:19
61,Hoenie,Mike,30s,Open,0:30:22
29,Zemke,Tom,50s,Open,0:30:31
49,Hoang,Carl,50s,Open,0:30:48
55,Moen,Jesse,30s,Open,0:30:58
39,Kylander,Paul,60+,Open,0:32:36
30,Zemke,Jay,40s,Open,0:32:47
47,Krska,Gary,50s,Open,DNF
41,Donzella,Bonny,40s,Open,0:27:39
4,Stoller,Diane,50s,Open,0:29:58
3,Hilgren,Renee,40s,Open,0:30:19
12,Descotte,Veronica,30s,Open,0:30:56
2,Hughes,Jill,30s,Open,0:32:07
8,Johnson,Sarah,30s,Open,0:33:47
10,Linebaugh,Charis,30s,Open,0:34:38
7,Nilson,Lois,50s,Open,0:37:08
33,Townsend Tandem,50s,Tandem,0:25:43
50,Holmberg,Robert,20s,Stock,0:25:58
52,Conrade,Thomas,40s,Stock,0:27:55
62,Ratzlaff,Justin,20s,Stock,0:28:38
25,Kozub,Roger,50s,Stock,0:29:40
66,Snyder,Robson,30s,Stock,0:30:12
35,Scheurich,Mike,40s,Stock,0:31:11
5,Snaza,Tammy,30s,Stock,0:31:06
11,Olheiser,Valerie,30s,Stock,0:31:57
6,Windhurst,Becca,20s,Stock,0:33:23
14,Axelson,Nancy,40s,Stock,0:34:39
9,Baker,Kristen,30s,Stock,0:34:42
1,Lemm-Tabor,Brook,60+,Stock,0:35:22
13,Scholz,Jeannie,40s,Stock,0:38:05
EOD;

$week[3] = <<<EOD
71,Roeser,Josh,30s,Open,0:23:10
44,Schiesl,Andy,30s,Open,0:24:07
73,Shishilla,John,50s,Open,0:25:01
25,Lovaas,Brett,30s,Open,0:25:02
65,Olheiser,David,30s,Open,0:25:05
18,Olson,Eric,30s,Open,0:25:05
9,Rosetta,Vince,30s,Open,0:25:09
3,Ludwigson David,50s,Open,0:25:12
54,Bolinske,Michael,30s,Open,0:25:13
61,Dykes,Mark,40s,Open,0:25:44
58,Madden,Bill,50s,Open,0:25:45
64,Digman,Jason,40s,Open,0:25:46
4,Maki,Robert,50s,Open,0:25:58
11,Phillips,David,20s,Open,0:26:00
62,Hager,Derek,50s,Open,0:26:06
74,Peterson,Jeff,30s,Open,0:26:14
42,DeLeeuw,Nicholas,40s,Open,0:26:17
39,Carlson,Jey,40s,Open,0:26:18
45,Elton,David,50s,Open,0:26:20
24,Krska,Gary,50s,Open,0:26:35
70,Larson,Ryan,30s,Open,0:26:41
59,Peterson,David,40s,Open,0:26:42
75,Boelke,Joel,30s,Open,0:26:42
26,Lunde,David,40s,Open,0:26:45
12,Nelson,Dale,40s,Open,0:26:45
23,Kuller,Hart,60+,Open,0:26:49
19,Snaza,Brad,30s,Open,0:27:02
36,Owen,Clifford,40s,Open,0:27:03
16,Knowlton,Steven,60+,Open,0:27:03
55,Lundquist,David,50s,Open,0:27:19
1,Meyer,Dan,60+,Open,0:27:21
15,Mitchell,Carlton,40s,Open,0:27:46
33,Lyner,Mike,50s,Open,0:27:47
34,Ogren,Robert,60+,Open,0:27:49
72,Walker,Tim,40s,Open,0:27:54
69,Essma,Nick,40s,Open,0:28:04
52,Schonhardt,Larry,50s,Open,0:28:12
43,Grafa,Adam,30s,Open,0:28:24
2,Ingham,Jeff,40s,Open,0:28:33
20,Rosen,Mark,40s,Open,0:28:56
8,Kosfeld,Bill,60+,Open,0:29:11
28,Dolman,Timothy,50s,Open,0:29:46
17,Hawes,Christopher,30s,Open,0:30:09
48,Vogel,Alexander,_-20,Open,0:30:09
41,Zemke,Tom,50s,Open,0:30:32
60,Kingsley,Robert,50s,Open,0:30:35
40,Kylander,Paul,60+,Open,0:31:07
13,DiLuzio,Damian,30s,Open,0:31:48
50,Williams,Frank,60+,Open,0:31:52
66,Heffernan,Dave,60+,Open,0:32:11
68,Bungarten,Benjamin,20s,Open,0:32:15
37,Donzella,Bonny,40s,Open,0:27:32
22,Hanenberg,Amy,30s,Open,0:28:02
29,Stocker,Nordica,20s,Open,0:29:00
14,Plant,Paula,40s,Open,0:29:59
49,Descotte,Veronica,30s,Open,0:32:05
35,Hughes,Jill,30s,Open,0:32:17
53,Collins,Bethany,50s,Open,0:32:26
32,Byland,Stephanie,30s,Open,0:32:45
46,Holmberg,Robert,20s,Stock,0:25:42
63,Stensrud,Mike,50s,Stock,0:26:40
57,Ratzlaff,Justin,20s,Stock,0:27:43
51,Hansen,Boyd,40s,Stock,0:28:48
30,Kozub,Roger,50s,Stock,0:30:14
21,Scheurich,Mike,40s,Stock,0:30:31
31,Warne,Mike,40s,Stock,0:31:40
67,Johnson,Ben,30s,Stock,0:31:45
38,Johannes,Brad,40s,Stock,0:35:44
6,Pellicano,Danielle,30s,Stock,0:30:38
10,Snaza,Tammy,30s,Stock,0:30:47
47,Olheiser,Valerie,30s,Stock,0:32:04
27,Voss,Jill,40s,Stock,0:33:16
56,Boiarsky,Lynne,40s,Stock,0:33:36
5,Windhurst,Becca,20s,Stock,0:33:40
7,Huso,Holly,40s,Stock,0:41:27
EOD;

$week[2] = <<<EOD
1,Toftoy,Jonathan,30s,Open,0:22:34
2,Cullen,Jordan,<20,Open,0:22:36
3,Casper,Daniel,40s,Open,0:23:01
4,Roeser,Josh,30s,Open,0:23:04
5,Parker,James,40s,Open,0:23:34
6,Mulrooney,Tim,40s,Open,0:24:08
7,Dave Gray,50s,Open,0:24:12
8,Christenson,Rick,50s,Open,0:24:39
9,Millner,Chad,30s,Open,0:24:43
10,Rosetta,Vince,30s,Open,0:24:52
11,Lovaas,Brett,30s,Open,0:24:54
12,Olson,Eric,30s,Open,0:25:03
13,Johnson,Joe,30s,Open,0:25:07
14,Hilligoss,Jeff,40s,Open,0:25:15
15,Olheiser,David,30s,Open,0:25:22
16,Ludwigson David,50s,Open,0:25:23
17,Kermisch,Mark,30s,Open,0:25:24
18,Snaza,Brad,30s,Open,0:25:27
19,Schinke,Ben,30s,Open,0:25:34
20,Sidwell,Kevin,30s,Open,0:25:34
21,Cullen,Jim,40s,Open,0:25:39
22,Ingham,Jeff,40s,Open,0:25:43
23,Nelson,Kevin,40s,Open,0:25:48
24,Digman,Jason,40s,Open,0:25:52
25,Peterson,Jeff,30s,Open,0:25:56
26,Peterson,David,40s,Open,0:25:58
27,Hager,Derek,50s,Open,0:25:59
28,Knowlton,Steven,60+,Open,0:26:10
29,Carlson,Jey,40s,Open,0:26:13
30,Madden,Bill,40s,Open,0:26:13
31,Krska,Gary,50s,Open,0:26:16
32,Chimerakis,Nick,20s,Open,0:26:20
33,Fiske,Richard,40s,Open,0:26:28
34,Elton,David,50s,Open,0:26:29
35,Nelson,Dale,40s,Open,0:26:32
36,Owen,Clifford,40s,Open,0:26:33
37,Lunde,David,40s,Open,0:26:43
38,Mitchell,Carlton,40s,Open,0:26:45
39,Kuller,Hart,60+,Open,0:26:46
40,Bates,Jason,30s,Open,0:26:56
41,Lundquist,David,50s,Open,0:27:16
42,Perleberg,Paul,40s,Open,0:27:55
43,Meyer,Dan,60+,Open,0:28:00
44,Stamm,John,60+,Open,0:28:05
45,Schonhardt,Larry,50s,Open,0:28:21
46,Rosen,Mark,40s,Open,0:28:24
47,Ogren,Robert,60+,Open,0:28:24
48,Lyner,Mike,50s,Open,0:28:28
49,Pettersen,Cleve,60+,Open,0:28:47
50,Kosfeld,Bill,60+,Open,0:28:55
51,Hawes,Christopher,30s,Open,0:29:14
52,Barnes,Ryan,30s,Open,0:29:24
53,Olson,Jeff,40s,Open,0:29:26
54,Johnson,Dallas,40s,Open,0:29:32
55,Hoang,Carl,50s,Open,0:29:40
56,Zemke,Tom,50s,Open,0:30:38
57,Zemke,Jay,40s,Open,0:31:04
58,Aboobaker,Asad,30s,Open,0:32:01
59,Heffernan,Dave,60+,Open,0:32:38
60,Donzella,Bonny,40s,Open,0:27:18
61,Stocker,Nordica,20s,Open,0:27:50
62,Bootsma,Claire,20s,Open,0:28:08
63,Hanenberg,Amy,30s,Open,0:28:25
75,Kline,Amy,40s,Open,0:29:17
64,Hilgren,Renee,40s,Open,0:29:50
65,Hughes,Jill,30s,Open,0:32:05
66,Johnson,Amy,40s,Open,0:33:54
67,Holmberg,Robert,20s,Stock,0:25:35
68,Ratzlaff,Justin,20s,Stock,0:28:09
69,Hansen,Boyd,40s,Stock,0:28:15
70,Phillips,David,20s,Stock,0:28:29
71,Binder,Cory,30s,Stock,0:28:56
72,Scheurich,Mike,40s,Stock,0:30:24
73,Warne,Mike,40s,Stock,0:31:29
74,Swanson,Matt,30s,Stock,0:32:23
76,Olheiser,Valerie,30s,Stock,0:32:26
77,Voss,Jill,40s,Stock,0:33:22
78,Boiarsky,Lynne,40s,Stock,0:34:21
79,Huso,Holly,40s,Stock,0:37:33
EOD;

$week[1] = <<<EOD
1,Roeser,Josh,30s,Open,0:23:25
2,Cullen,Jordan,<20,Open,0:23:34
3,Mulrooney,Tim,40s,Open,0:24:03
4,Lovaas,Brett,30s,Open,0:25:13
5,Dave Gray,50s,Open,0:25:13
6,Olheiser,David,30s,Open,0:25:18
7,Millner,Chad,30s,Open,0:25:27
8,Olson,Eric,30s,Open,0:25:33
9,Shishilla,John,50s,Open,0:25:57
10,Peterson,David,40s,Open,0:26:03
11,Cullen,Jim,40s,Open,0:26:07
12,Ingham,Jeff,40s,Open,0:26:11
13,Rosetta,Vince,30s,Open,0:26:12
14,Krska,Gary,50s,Open,0:26:20
15,Lavick,Gergory,40s,Open,0:26:28
16,Boelke,Joel,30s,Open,0:26:33
17,Ludwigson David,50s,Open,0:26:42
18,Knowlton,Steven,60+,Open,0:26:48
19,Snaza,Brad,30s,Open,0:26:53
20,Carlson,Jey,40s,Open,0:26:57
21,Kadera,Aaron,20s,Open,0:26:58
22,Peterson,Jeff,30s,Open,0:27:01
23,Hager,Derek,50s,Open,0:27:04
24,Elton,David,50s,Open,0:27:05
25,Nelson,Kevin,40s,Open,0:27:33
26,Lundquist,David,50s,Open,0:27:51
27,Lyner,Mike,40s,Open,0:28:13
28,Walker,Tim,40s,Open,0:28:29
29,Dolan,Brendan,30s,Open,0:29:02
30,Perleberg,Paul,40s,Open,0:29:04
31,Meyer,Dan,60+,Open,0:29:06
32,Ogren,Robert,60+,Open,0:29:16
33,Pettersen,Cleve,60+,Open,0:29:26
34,Schonhardt,Larry,50s,Open,0:29:32
35,Hawes,Christopher,30s,Open,0:30:12
36,Quealy,Micheal,60+,Open,0:30:20
37,Kosfeld,Bill,60+,Open,0:30:25
38,Hoang,Carl,50s,Open,0:30:50
39,DiLuzio,Damian,30s,Open,0:30:58
40,Kingsley,Robert,50s,Open,0:31:07
41,Zemke,Tom,50s,Open,0:31:27
42,Aboobaker,Asad,30s,Open,0:31:37
43,Zemke,Jay,40s,Open,0:33:04
44,Heffernan,Dave,60+,Open,0:34:49
45,Donzella,Bonny,40s,Open,0:28:19
46,Stocker,Nordica,,Open,0:28:32
47,Hanenberg,Amy,30s,Open,0:28:51
48,Plant,Paula,40s,Open,0:29:22
49,Hilgren,Renee,40s,Open,0:31:29
50,Holmberg,Robert,20s,Stock,0:26:06
51,Nelson,Dale,40s,Stock,0:27:13
52,Phillips,David,20s,Stock,0:28:16
53,Hansen,Boyd,40s,Stock,0:28:58
54,Binder,Cory,30s,Stock,0:29:16
55,Cray,Mike,50s,Stock,0:29:35
56,Michael O'Day,40s,Stock,0:29:48
57,Johnson,Dallas,40s,Stock,0:29:55
58,Kozub,Roger,50s,Stock,0:29:56
59,Delins,Andris,<20,Stock,0:30:26
60,Warne,Mike,30s,Stock,0:31:55
61,Snyder,Robson,30s,Stock,
62,Binder-in-law,Cory,30s,Stock,
63,McCrome,Gina,50s,Stock,0:34:08
EOD;

foreach ( $week as $key => $data )
{
    $lines = explode("\n", $data);
    if ( $returnString == '' && count( $lines ) > 0 )
    {
         // the put all of the data into a huge hash to be processed
        $dataMap = array();
        $lineCounter = 0;
        foreach ( $lines as $dataLine )
        {
            $lineArray = str_getcsv( $dataLine );
            $rider = TimingRider::model()->find( 'first_name=:f and last_name=:l'
                    , array( ':f'=>$lineArray[2] , ':l'=>$lineArray[1] ) );
            if ( ! $rider ) echo " - - - - > No rider data for {$lineArray[2]} {$lineArray[1]}<br />";
            $riderDetails = new TimingDetails();
            $riderDetails->event_id = $key ;
            $riderDetails->rider_id = $rider->id;
            $riderDetails->rider_category = $lineArray[ 3 ];
            $riderDetails->rider_class = $lineArray[ 4 ];
            $riderDetails->duration =$lineArray[ 5 ];
            $riderDetails->rider_num = $lineArray[ 0 ];
            $riderDetails->save();
            echo " . . . Race saved for {$lineArray[2]} {$lineArray[1]} rider # {$rider->id} Race #{$lineArray[0]}<br />";
        }
    }
}

}
?>
