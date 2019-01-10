<?php
ini_set('memory_limit', '-1');
$conn =  mysqli_connect('localhost', 'root', '', 'music');
$youtube_key = 'AIzaSyAMwSQU5ZumKTFhRERSsKYgfY3iA9Oz4X8';
$output = '';
if(isset($_POST["import"]))
{
$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);
 $ext = explode(".", $_FILES["excel"]["name"]); // For getting Extension of selected file
 $extension = end($ext);
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
  include("PHPExcel/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  $output .= "<div class='alert alert-success'><strong>Data Inserted</strong></div><table class='table table-bordered'>";
    $i = 1;
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();
   for($row=2; $row<=$highestRow; $row++)
   {
    $output .= "<tr>";
    
    $url = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
    
    if(!empty($url)){
        $pos = strrpos($url, '/');
        $channelid = $pos === false ? $url : substr($url, $pos + 1);
        $posturl = 'https://www.googleapis.com/youtube/v3/channels?part=topicDetails,status,brandingSettings,contentDetails,contentOwnerDetails,localizations,snippet,statistics,topicDetails&id='.$channelid.'&key='.$youtube_key;
        $data = file_get_contents( $posturl, false, $context);
        $response = json_decode($data);
        
        
        $country = isset($response->items[0]->snippet->country) ? $response->items[0]->snippet->country : 'N/A';
        $tags = isset($response->items[0]->brandingSettings->channel->keywords) ? $response->items[0]->brandingSettings->channel->keywords : 'N/A';
        
        $query = "INSERT INTO channels (id, channelid, country, tags) VALUES (NULL, '$channelid', '$country', '$tags')";
        mysqli_query($conn, $query);
        $output .= '<td>'.$i.'</td>';
        $output .= '<td>'.$channelid.'</td>';
        $i++;
        
        
        
    }
    
    $output .= '</tr>';
   }
  } 
  $output .= '</table>';

 }
 else
 {
  $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Import</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

   
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <br>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input name="excel" type="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <input name="import" type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <?php if(isset($output)) { echo $output; } ?>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>
