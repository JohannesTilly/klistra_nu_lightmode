<?php
//PHP SESSION
session_start();
if (!isset($_SESSION["createdPaste"])) {
    $_SESSION["createdPaste"] = "";
}

//INCLUDES
include_once "./include/guid.php";

//HTML Main Page
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Klistra.nu</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,300,0,200" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="static/script.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    
   
    </script>
  </head>
  <body>
    <div class="pageWrapper">
    <div class="master_container">
	    <div id="001_head_container"></div>
        <?php if (isset($_GET["klister"])) {
            $_SESSION["createdPaste"] = $_GET["klister"]; ?>
                <div id="003_read_container"></div>
            <?php
        } elseif (isset($_GET["page"])) {
            //PAGES
            switch ($_GET["page"]) {
                case "privacy":
                    echo '<div id="005_privacy_container"></div>';
                    break;
                case "api":
                    echo '<div id="006_api_container"></div>';
                    break;
                case "stats":
                    echo '<div id="007_stats_container"></div>';
                    break;
            }
        } else {
             ?>
                <div id="002_create_container"></div>
            <?php
        } ?>
        <div id="004_footer_container"></div>
    </div>
    </div>
  </body>
  
  
</html>