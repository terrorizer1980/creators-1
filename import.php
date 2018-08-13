<?php
include 'db.php';
$output = '';
if(isset($_POST["import"]))
{
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
    
    $url = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
    $insta = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
    
    
    
    if(!empty($url) && !empty($insta)){
        $pos = strrpos($url, '/');
        $channelid = $pos === false ? $url : substr($url, $pos + 1);
        $output .= '<td>'.$i.'</td>';
        $output .= '<td>'.$channelid.'</td>';
        $output .= '<td>'.$insta.'</td>';
        $i++;
        
        $query = "update channels set instagram = '$insta' where channelid = '$channelid'";
        mysqli_query($conn, $query);
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
