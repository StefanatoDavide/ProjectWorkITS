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
    session_start();
    if(!isset($_SESSION["logged_in"]))
    {
        header("location: http://localhost/Projectworkits/login_definitivo.php");
        exit;
    } else {
        session_destroy();
        header("location: http://localhost/Projectworkits/login_definitivo.php");
        exit;
    }


    ?>
</body>
</html>