<?php
    $isok=false;
    if(isset($_REQUEST["Invio"]))
    {
        $isok=true;
        $mail=trim(htmlspecialchars($_REQUEST["mail"]));
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $password=implode($pass);
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password dimenticata</title>
</head>
<body>
    <form action="" method="post" onsubmit="return Controllo()">
        <div>
            <h4>Recupero password</h4>
        </div>
        <div>
            <label for="l1">Inserisci email a cui inviare la nuova password:</label>
            <input type="email" id="mail" name="mail" placeholder="henrymiles@gmail.com" autocomplete="off" required >
        </div>
        <div>
            <p id="errore"></p>
            <p id="info"></p>
        </div>
        <div>
            <input type="submit" name="Invio" id="Invio" value="Invia">
        </div>
    </form>
</body>
<?php
    if($isok)
    {
        $conn = mysqli_connect("localhost", "root", "", "projectworkits");
        $result = $conn->prepare("select * from tconticorrenti WHERE email = ? AND RegistrazioneConfermata=?");
        $regConfermata=1;
        $result->bind_param("si",$mail,$regConfermata);
        $result->execute();
        $dati=$result->get_result();
        if (mysqli_num_rows($dati) > 0)
        {  
            $object="Nuova password";
            $header="From: zion.holdingcompanyita@gmail.com";
            $head = "MIME-Version: 1.0\r\n";
            $head .= "Content-type: text/html; charset=utf-8";
            $html=file_get_contents("email_template4.html");
            $html = str_replace("{PASSWORD}",$password, $html);
            
            
            if(!mail($mail,$object,$html,$head))
            {
                echo("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore durante l'invio della mail. Si prega di riprovare.';</script>");
            }
            else
            {
                $queryUpdate=$conn->prepare("UPDATE tconticorrenti SET password=? WHERE email=?");
                $queryUpdate->bind_param("ss",$hash,$mail);
                if($queryUpdate->execute())
                {
                    echo("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Email inviata con successo. La password è stata cambiata.';</script>");
                    header("refresh:5;url=http://localhost/ProjectWorkITS/login.php");
                }
                else
                {
                    echo("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore generico. Si prega di riprovare.';</script>");
                }
                $queryUpdate->close();
            }
           

        }
        else
        {
            echo("<script>document.getElementById('errore').style.display = 'block'; document.getElementById('errore').innerHTML = '';document.getElementById('errore').innerHTML = 'Email non esistente! Si prega di riprovare.';</script>");
        }
        
        mysqli_close($conn);
        unset($_REQUEST["Invio"]);
        
    }

?>

<script>
    function Controllo()
    {
        let email=document.getElementById("mail").value;
        if(email=="")
        {
            document.getElementById("errore").style.display = "block";
            document.getElementById("errore").innerHTML = "";
            document.getElementById("errore").innerHTML = "Inserisci un'email valida!";
            return false;
        }
        else
        {
            return true;
        }
    }
</script>
</html>