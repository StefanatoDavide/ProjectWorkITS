<?php
    error_reporting(0);
    session_start();
    
    //funzione per ottenere l'indirizzo pubblico dell'host
    function getPublicIP() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://httpbin.org/ip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        $ip = json_decode($output, true);
        return $ip['origin'];
      }
      

    if (isset($_SESSION["locked"]))
    {
        $difference = time() - $_SESSION["locked"];
        if ($difference > 5)
        {
            unset($_SESSION["locked"]);
            unset($_SESSION["login_attempts"]);
        }
    }

    if (isset($_REQUEST["Invio"]))
    {
        $email =trim(htmlspecialchars($_POST["email"]));
        $password =trim(htmlspecialchars($_POST["password"]));
        $hash = password_hash($password,PASSWORD_DEFAULT);

        $conn = mysqli_connect("localhost", "root", "", "projectworkits");
        $result = $conn->prepare("select * from tconticorrenti WHERE email = ?  AND password = ? ");
        $result->bind_param("ss",$email,$hash);
        $result->execute();
        $dati=$result->get_result();
        $ip=getPublicIP();

        if (mysqli_num_rows($dati) > 0)
        {
            date_default_timezone_set("Europe/Rome");
            $date= date("Y-m-d h:i:sa");
            $valido=1;
            $queryInsert=$conn->prepare("insert into taccessi (IndirizzoIP, DataOra, ValiditaAccesso) VALUES ( ?, ?, ?)");
            $queryInsert->bind_param("ssi",$ip,$date,$valido);
            if($queryInsert->execute()){
                //header("Location: index.php");
                header("Location: https://stackoverflow.com");
            }
            else{
                echo("<script>document.getElementById('errore').style.display='block'; document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Errore generico';</script>");
            }
           $queryInsert->close();

        }
        else
            {
            date_default_timezone_set("Europe/Rome");
            $date= date("Y-m-d h:i:sa");
            
            $valido=0;
           
            $queryInsert=$conn->prepare("insert into taccessi (IndirizzoIP, DataOra, ValiditaAccesso) VALUES (?, ?, ?)");
            $queryInsert->bind_param("ssi",$ip,$date,$valido);
            if($queryInsert->execute()){
                echo("<script>document.getElementById('errore').style.display='block'; document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Inserimento errato';</script>");
                //header("Location: index.php");
            }
            else{
                echo("<script>document.getElementById('errore').style.display='block'; document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Errore generico';</script>");
            }


            
            if (isset($_SESSION["login_attempts"])) {
                $_SESSION["login_attempts"] += 1; 
            }else{
                $_SESSION["login_attempts"] = 0;
            }
            
            $queryInsert->close();
        }
        mysqli_close($conn);
        unset($_REQUEST["Invio"]);
    }
   
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Form</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style>
    #errore{
        display:none;
    }
    #demo{
        text-align: center;
        font-size: 10px; 
    }
</style>
<script>
    function myFunction(){
        document.getElementById("Form").reset();
    }

    
    function avviaCountdown() {
    var durataCountdown = 30;
    var countdownElement = document.getElementById("countdown");
    var countdownInterval = setInterval(function() {
    countdownElement.textContent = durataCountdown;
    durataCountdown--;

    if (durataCountdown <= 0) {
        durataCountdown = 30;
        countdownElement.textContent = durataCountdown;
    }
    }, 1000); 
    }

  
</script>

</head>
<body onload="setInterval(myFunction, 30000),avviaCountdown()">
<div>
    <form action="" method="post" onsubmit="return Controllo()" id="Form">
        <h2>Member Login</h2>
        <div>
            <input type="text" name="email" placeholder="Email" required="required" id="email">
        </div>
        <div >
            <input type="password" name="password" placeholder="Password" required="required" id="password">
        </div>        

        <div>
            <p id="errore"></p>
        </div>
        <div >
            <?php
                if ($_SESSION["login_attempts"] >= 3) {
                    $_SESSION["locked"] = time();
                    echo "<p>Hai superato il limite di tentativi aspetta 1 minuto e ritenta</p>";
                } else {
            ?>
                <input name="Invio" type="submit" value="Accedi">
            <?php } ?>
        </div>
    </form>
</div>
<p id="paragrafoCount">Countdown: <span id="countdown"></span> secondi</p>

</body>
<script>
    function Controllo(){
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        if(email=="" || password==""){
            return false;
        }
        else{
            return true;
        }
        
    }
</script>
</html>                            