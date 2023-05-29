<?php
    $isok=false;
    if($_GET["Token"]!="")
    {
        $isok=true;
        $token=$_GET["Token"];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione confermata</title>
</head>
<body>
   <?php
        if($isok)
        {
            
            $conn=mysqli_connect("localhost","root", "","projectworkits");
            $queryUpdate=$conn->prepare("UPDATE tconticorrenti SET RegistrazioneConfermata=? WHERE Token=?");
            $registrazioneConfermata=1;
            $queryUpdate->bind_param("ss",$registrazioneConfermata,$token);
            if($queryUpdate->execute())
            {
                echo("<h4>La registrazione è andata a buon fine! Sarai reindirizzato alla pagina principale.</h4>");
                header("refresh:5;url=http://localhost/ProjectWorkITS/index.php");
                echo "<p>Se il tuo browser non supporta il redirect, clicca <a href='http://localhost/ProjectWorkITS/index.php'>qui</a></p>";
            }
        }
        else
        {
            header("Location: http://localhost/ProjectWorkITS/registrazione.php ");
            exit;
        }
   
   ?>
</body>
</html>