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

// Load an inline SVG.
function load_inline_svg( $filename ) {

    // Check the SVG file exists
    if ( file_exists( $filename ) ) {
        // Load and return the contents of the file
        return file_get_contents( $filename );
    }

    // Return a blank string if we can't find the file.
    return '';
}

// Slugify a String
function create_slug($str, $delimiter = '-'){
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;
}
// function slugify($string){
//   return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
// }

// Get ACF Field By Key
function get_acf_key($field_name) {
    global $wpdb;
    $length = strlen($field_name);
    $sql = "
        SELECT `meta_key`
        FROM {$wpdb->postmeta}
        WHERE `meta_key` LIKE 'field_%' AND `meta_value` LIKE '%\"name\";s:$length:\"$field_name\";%';
    ";
    return $wpdb->get_var($sql);
}

// Encode String to Base64
function base64url_encode($plainText) {
    $base64 = base64_encode($plainText);
    $base64url = strtr($base64, '+/=', '-_,');
    return $base64url;
}

// Decode String to Base64
function base64url_decode($plainText) {
    $base64url = strtr($plainText, '-_,', '+/=');
    $base64 = base64_decode($base64url);
    return $base64;
}

// Detect Client Language
function get_client_language($availableLanguages, $default='en'){
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $langs=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($langs as $value){
            $choice=substr($value,0,2);
            if(in_array($choice, $availableLanguages)){
                return $choice;
            }
        }
    }
    return $default;
}

// Add (th, st, nd, rd, th) to the end of a number
function ordinal($cdnl){
    $test_c = abs($cdnl) % 10;
    $ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th'
            : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1)
            ? 'th' : 'st' : 'nd' : 'rd' : 'th'));
    return $cdnl.$ext;
}
// for ($i=1; $i<100; $i++) {
//     echo ordinal($i) . '<br>';
// }

// Check if String Begins with Substring
function startsWith($string, $startString) {
  $len = strlen($startString);
  return (substr($string, 0, $len) === $startString);
}

// Get Email(s) from String
function extract_emails_from($string) {
    preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
    return $matches[0];
}

// Validate Email
function check_email($email) {
    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)) {
        list($username,$domain)=split('@',$email);
        if (!checkdnsrr($domain,'MX')) {
            return false;
          }
        return true;
    }
    return false;
}

// Sorts a collection of arrays or objects by key
function order_by($items, $attr, $order) {
    $sortedItems = [];

    foreach ($items as $item) {
        $key = is_object($item) ? $item->{$attr} : $item[$attr];
        $sortedItems[$key] = $item;
    }

    if ($order === 'desc') {
        krsort($sortedItems);
    } else {
        ksort($sortedItems);
    }

    return array_values($sortedItems);
}

// Get the Median
function median($numbers) {
  sort($numbers);
  $totalNumbers = count($numbers);
  $mid = floor($totalNumbers / 2);

  return ($totalNumbers % 2) === 0 ? ($numbers[$mid - 1] + $numbers[$mid]) / 2 : $numbers[$mid];
}
