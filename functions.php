<?php
function convert($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('K', 'M', 'B', 'T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}

function filteredDesc($string) {
    if(!empty($string)){
        if(strlen($string)>300){
            $string = substr($string, 0, 300).'....';
            $string = str_replace(array('\'', '\"'), array('',''), $string);
        }
        
        return $string = str_replace(array('\'', '\"'), array('',''), $string);
        
    }else{
        return 'N/A';
    }
}

function shortTitle($string){
   return strlen($string)>14 ? substr($string, 0, 14).'...' : $string;
}

function updateSubs($conn, $channelid, $subs){
    $query = "Update channels set subscribers = '$subs' where channelid = '$channelid'";
    mysqli_query($conn, $query);
}

function updateViews($conn, $channelid, $views){
    $query = "Update channels set views = '$views' where channelid = '$channelid'";
    mysqli_query($conn, $query);
}

function compare($a, $b)
{
    return $a->statistics->subscriberCount < $b->statistics->subscriberCount;
}

function getSocialLinks($channelid, $conn){
    $query = "select * from channels where channelid='$channelid'";
    $run = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($run);
    return $row;
}



?>