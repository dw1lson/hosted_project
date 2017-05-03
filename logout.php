<?php
session_start();

session_destroy();

header("Location: candyStore.php");

?>