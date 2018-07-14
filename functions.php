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

function compare($a, $b)
{
    return $a->statistics->subscriberCount < $b->statistics->subscriberCount;
}

function paginate($page_query, $page, $record_per_page, $class, $conn)
{
    $pagination = "";
    //$page_query = "SELECT * FROM $table ORDER BY id DESC";
    $page_result = mysqli_query($conn, $page_query);
    $total_records = mysqli_num_rows($page_result);
    $total_pages = ceil($total_records/$record_per_page);
    $start_loop = $page;
    $difference = $total_pages - $page;
    if($difference <= 5){
        $start_loop = 1;
    }$end_loop = $total_pages;
        if($page > 1){
            $pagination.= "<li><a href='#' data-page='$i' class='$class'><i class='fa fa-angle-left'></i></a></li>";
        }
        for($i=$start_loop; $i<=$end_loop; $i++){
            if($page==$i){
                $pagination.= "<li class=''><a data-page='$i' class='$class' href='#'>".$i."</a></li>";
            }else{
                $pagination.= "<li><a data-page='$i' class='$class' href='#'>".$i."</a></li>";
            }
            
        }
        if($page <= $end_loop){
            $pagination.= "<li><a data-page='$total_pages' class='$class' href='#' ><span aria-hidden='true'><i class='fa fa-angle-right'></i></span></a><li>";
        }
    return $pagination;
}

?>