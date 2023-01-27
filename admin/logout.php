<?php

$_SESSION["error"] = "";

session_unset();

session_destroy();

header('location: index.php');
exit;