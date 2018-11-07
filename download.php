<?php 
$filename = "./StudentInformation.txt";
if (file_get_contents($filename) == '') {
    echo "<script>alert('没有信息！');history.back(-1);</script>";
    exit();
}
header("content-disposition:attachment;filename=".basename($filename));
header("content-length:".filesize($filename));
readfile($filename);