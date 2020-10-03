<?php
date_default_timezone_set("Asia/Kathmandu");
$CurrentTime = time();
//$DateTime = strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
$DateTime = strftime("%A %B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;


 ?>
