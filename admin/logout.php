<?php

$past = time() - 3600;
//this makes the time in the past to destroy the cookie
setcookie("userCookie", "gone", $past);
setcookie("passCookie", "gone", $past);

header("Location: index.php");
?> 