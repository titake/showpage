<?php
session_start();
$name = $_GET['queryName'];
echo $_SESSION["{$name}"];