<?php
if(isset($_POST['url'])){
    $url = $_POST['url'];
    if(strpos($url,'yt3.ggpht.com') == true){
        $name = str_replace(' ', '_', $_POST['name']);
        $img = 'temp/'.$name."_logo.jpg";
        file_put_contents($img, file_get_contents($url));
        $file = $img;
        header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Type: '.mime_content_type($file));
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($file));
        readfile($file);
        unlink($file);
    } else {
        die('Error');
    }
}else{
    die('Error');
}
?>