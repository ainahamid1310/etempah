<?php
// the message
$msg = "test....First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("nooraina@miti.gov.my","Testing Myinvites",$msg);
?>
