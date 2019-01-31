<?php

// Truncate Text
function truncate_by_word($string, $limit, $break = ".", $pad = "...") {
    if (strlen($string) <= $limit) return $string;
    if (false !== ($breakpoint = strpos($string, $break, $limit))) {
        if ($breakpoint < strlen($string) - 1) {
            $string = substr($string, 0, $breakpoint) . $pad;
        }
    }
    return $string;
}

// Time Ago
function time_ago($tm,$rcs = 0) {
   $cur_tm = time(); $dif = $cur_tm-$tm;
   $pds = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
   $lngh = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
   for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
   $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
   return $x;
}

// Reading Time
function read_time( $content ) {
    $mycontent = $content;
    $word = str_word_count(strip_tags($mycontent));
    $m = floor($word / 200);
    $s = floor($word % 200 / (200 / 60));
    $est = $m . 'm';
    return ( $est < 1 ? 'Quick' : $est );
}
