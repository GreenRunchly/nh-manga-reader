<?php
    header('Cache-Control: max-age=0');
    header("Pragma: no-cache"); 
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time()+2));
    header("Connection: close");
    header("Content-type: image/jpeg");
    
    if (!empty($_GET['media'])){
		$mediaUrl = $_GET['media'];
	}else{
		die('');
	}
    
    $tempfile = file_get_contents($mediaUrl);
    echo $tempfile;

?>