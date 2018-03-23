<?php
$to = "alannunes@ugb.edu.br";
$subject = "FAQ";
$txt = "Hello world!";
$headers = "From: FAQ UGB" . "\r\n" .
"CC: alann.625@gmail.com";

mail($to,$subject,$txt,$headers);
?>