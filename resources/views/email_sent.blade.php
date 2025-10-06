<?php
$to = "nooraina@miti.gov.my";
$subject = "test hantar email";
$txt = "Hello world!";
$headers = "From: test@miti.com" . "\r\n" .
"CC: rozita@miti.gov.my";

mail($to,$subject,$txt,$headers);
?>