<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home | BrickMMO Colours</title>

    <link href="styles.css" type="text/css" rel="stylesheet">

</head>
<body>

    <a href="/">Home</a>

    <h1>BrickMMO Colours</h1>

    <h2>Colours</h2>

    <?php

    /*
    Run a query to fecth all the themes
    */
    $query = 'SELECT * 
        FROM colours
        ORDER BY name';
    $result = mysqli_query($connect, $query);

    ?>

    <?php while($colour = mysqli_fetch_assoc($result)): ?>

        <hr>

        <h3>Theme: <?=$colour['name']?></h3>

        <div style="width: 100px; height: 100px; background-color:#<?=$colour['rgb']?>;"></div>
        
    <?php endwhile; ?>

</body>
</html>