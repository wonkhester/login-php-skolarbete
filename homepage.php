<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// process_form.php

session_start();

//kollar om du har en session annars skickar dig tillbaka till login 
if (!isset($_SESSION["username"]) || !isset($_SESSION["password"])) {
    header("location: index.php");
    exit();
}

$username = $_SESSION["username"];

echo "<h2>Hello $username!</h2>";
?>
</body>
</html>