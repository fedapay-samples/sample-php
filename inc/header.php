<?php
$config = require('config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config["project_name"] ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="div">
            <h1 class="h1 mt-5 mb-3" style="text-align:center; margin-top:25px; margin-bottom:25px"><?php echo $config["project_name"] ?></h1>
        </div>
    </div>
    
    <div class="container">
    <!---- Page body starts here ---->
