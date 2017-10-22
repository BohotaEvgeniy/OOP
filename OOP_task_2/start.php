<?php
    session_start();
    $_SESSION['count'] = 0;
    $data = $_POST['play'];
    if ($data) {
        $_SESSION['checkUser'] = $_POST['player'];
        header('Location: http://oop/OOP/OOP_task_2/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Your page title here :)</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">

    <style>
    </style>

</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container">
    <div class="row">
        <div class="twelve columns" style="margin-top: 25%; text-align: center;">
            <form action="" method="post">
                <label for="">Are you playing game with me?</label>
                <input type="submit" name="play" value="Play">
                <p>
                    <span style="float: left">
                        <label for="">Do you wont first city enter?</label>
                        <input type="radio" name="player" value="Player">
                    </span>
                    <span style="float: right;">
                        <label for="">Ok.I will enter rirst?</label>
                        <input type="radio" name="player" checked value="PC">
                    </span>
                </p>
            </form>
        </div>
    </div>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
