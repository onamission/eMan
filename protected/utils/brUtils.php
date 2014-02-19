<?php

class brUtils
{

    /**
     *  This simple function will allow a value to be incremented without knowing if it exists or not
     *
     * @param int $inputVal
     * @return int
     *
     * @assert () == 1
     * @assert (null) == 1
     * @assert (23) == 24
     * @assert (56, 5) == 61
     */
    public static function increment( $inputVal=0, $incrementBy = 1 )
    {
        if ( $inputVal == '' || $inputVal == null ) $inputVal = 0;
        return ( $incrementBy > 0 )
                ? $inputVal + $incrementBy
                : intval( $inputVal ) - intval( abs( $incrementBy )  ) ;
    }

    /**
     * Anothe simple function, this one to take a name with under-score(s) '_' and turn it into lowerCamelCase
     *
     * @param string $inputString
     * @return string
     *
     * @assert ('this_is_a_test') == 'thisIsATest'
     */
    public static function camelCase( $inputString )
    {
        $removedUnderScores = str_replace( '_', ' ', $inputString );
        $listOfWords = explode(' ', $removedUnderScores );
        $camelCase = '';
        foreach ( $listOfWords as $word )
        {
            $camelCase .= ( $camelCase == '' ) ? $word : ucfirst( $word );
        }
        return $camelCase;
    }

    /**
     *   Performs a calculation on two times and returns a string of the time with Milliseconds .
     *
     * @param string $time1
     * @param string $operation   Should be 'add' for addition or 'diff' to subtract the larger from the smaller
     * @param string $time2
     * @return string Represents the time in 'H:i:s.ms' format (exapmle: '3:21:54.321')
     *
     * @assert( '01:00:00.000', 'add', '01:23:45.678' ) == '02:23:45.678'
     * @assert( '01:00:00.322', 'add', '00:23:45.678' ) == '01:23:46.000'
     * @assert( '01:00:00.000', 'diff', '00:23:45.678' ) == '00:36:14.322'
     */
    public static function calculateWithMicroSeconds( $time1, $operation, $time2 )
    {
        list( $regTime1, $microTime1 ) = explode('.', $time1 );
        list( $regTime2, $microTime2 ) = explode('.', $time2 );
        // microtime must be 3 digits -- right padded with 0's [zeros]
        $microTime1 = substr( str_pad( $microTime1, 3, '0', STR_PAD_RIGHT ), 0, 3 );
        $microTime2 = substr( str_pad( $microTime2, 3, '0', STR_PAD_RIGHT ), 0, 3 );
        $returnValue = null;
        $rt = null;
        switch ( $operation )
        {
            case 'add':
                $rt1 = self::getTimeInSeconds($regTime1);
                $rt2 = self::getTimeInSeconds($regTime2);
                if (is_int($rt1) && is_int( $rt2 ) )
                {
                    $rt = $rt1 + $rt2;
                    $mt = $microTime1 + $microTime2;
                    if ( $mt >= 1000 )
                    {
                        $mt = $mt - 1000;
                        $rt++;
                    }
                }
                else
                {
                    $rt = 'Input must be a time in the format 00:00:00 ';
                }
                break;
            case 'diff':
                $rt1InSec = self::getTimeInSeconds( $regTime1 );
                $rt2InSec = self::getTimeInSeconds( $regTime2 );
                if (is_int($rt1InSec) && is_int( $rt2InSec ) )
                {
                    $rt = ( $rt1InSec >= $rt2InSec)
                        ? $rt1InSec - $rt2InSec
                        : ( 24 * 60 * 60 ) - $rt1InSec - $rt2InSec ; // one day minus the diff
                    if ( $microTime1 < $microTime2 )
                    {
                        $mt = 1000 + $microTime1 - $microTime2;
                        --$rt;
                    }
                    else
                    {
                        $mt = $microTime1 - $microTime2;
                    }
                }
                else
                {
                    $rt = 'Input must be a time in the format 00:00:00 ';
                }
        }
        $mt = substr( str_pad( $mt, 3, '0', STR_PAD_RIGHT ), 0, 3 );
        if (is_string( $rt ) )
        {
            $returnValue = $rt;
        }
        else
        {
            $returnValue = self::convertSecondsToTime( "$rt.$mt" );
        }
        return $returnValue;
    }

    /**
     *
     * @param string $inputString
     * @return string
     *
     * @assert ('thisIsATest') == 'This Is A Test'
     * @assert ('this_is_another_test' ) == 'This Is Another Test'
     *
     */
    public static function explodeCamelCase( $inputString )
    {
        $retValue = preg_replace('/([A-Z])/', ' $1', $inputString );
        // just to be sure, turn underscores into spaces too
        $retValue = str_replace( '_', ' ' , $retValue);
        return ucwords( $retValue );
    }

    /**
     *
     * @param string $currentFilePath
     * @return string
     *
     * @assert ('/var/www/index.php' ) == 'expectedResult'/var/www'
     */
    public static function whereAmI( $currentFilePath, $changeUp = 0 )
    {
        $glue = DIRECTORY_SEPARATOR;
        $pathArray = explode( $glue, $currentFilePath );
        for ( $i= 0 ; $i < $changeUp + 1 ; $i++ )
        {
            array_pop($pathArray);
        }
        return implode( $glue, $pathArray);
    }

    /**
     *
     * @param string $inputTime
     * @return integer
     *
     * @assert( '00:01:54' ) == 114
     * @assert( '00:01:54.123' ) == 114.123
     */
    public static function getTimeInSeconds ( $inputTime )
    {
        $retVal = 'Input must be a time in the format 00:00:00 ';
        if (preg_match('/\d+:[0-5]\d:[0-5]\d/', $inputTime ) )
        {
            list( $h, $i, $s ) = explode( ':', $inputTime );
            $retVal = $h * 60 * 60 + $i * 60 + $s ;
        }
        return $retVal;
    }

    /**
     *
     * @param type $inputSeconds
     */
    public static function convertSecondsToTime ( $inputSeconds )
    {
        $h = $inputSeconds >= 3600 ?(int)( $inputSeconds / 3600 ) : '00';
        $remainingSeconds = $inputSeconds - ( $h * 3600 );
        $i = $remainingSeconds >= 60 ? (int)( $remainingSeconds / 60 ) : '00';
        $s = number_format( $remainingSeconds - ( $i * 60 ), 3 );
        $s = (strpos( $s, '.' ) ) ? $s : "$s.000";
        list( $sec, $ms ) = explode( '.', $s );
        $retVal = sprintf( "%02d:%02d:%02d.", $h, $i, $sec) . $ms;

        return $retVal;
    }


    public static function getRandomFactor( $max )
    {
        $factor = 0;
        $seed = rand( 0, 10 );
        for ( $i = 0 ; $i < $seed ; $i++ )
        {
            $factor += rand( 0, $max / $seed );
        }
        return rand( 0,4 ) % 2 == 0 ? $factor * ( -1 ) : $factor ;
    }
}
?>