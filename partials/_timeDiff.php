<?php
    // set the default timezone to use.
    date_default_timezone_set( 'Asia/Kolkata');

    function timediff($sub_time){
        $to_time = strtotime(date("Y-m-d H:i:s"));
        $from_time = strtotime("$sub_time");
        $min= round(abs($to_time - $from_time) / 60);
        // echo $min;
        if ($min < 60) {
            $time = $min.' minuts ago';
            return $time;
        }
        elseif (($min >= 60) && ($min < 1440)) {
            $time = round($min / 60). ' hours ago';
            return $time;
        }
        elseif (($min >= 1440) && ($min < 10080)) {
            $time = round($min / 1440). ' days ago';
            return $time;
        }
        elseif (($min >= 10080) && ($min < 43800)) {
            $time = round($min / 10080). ' weeks ago';
            return $time;
        }
        elseif (($min >= 43800) && ($min < 525600)) {
            $time = round($min / 43800). ' months ago';
            return $time;
        }
        elseif (($min >= 525600)) {
            $time = round($min / 525600). ' years ago';
            return $time;
        }
        else {
            $time = 'Invalid time';
            return $time;
        }
    }
?>