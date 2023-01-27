<?php

$_SESSION["error"] = "";
session_destroy();

header('location: index.php');
