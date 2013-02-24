<?php 

$url_this = "http://".$_SERVER ['HTTP_HOST'];
header("Location: ".$url_this."/istatdchat/src/index.php?p=istatd"); 
exit();

?>
