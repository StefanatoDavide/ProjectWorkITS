<?php
   
    session_start();
    $isok1=false;
    $captchaErrato=false;
    $codiceErrato=false;
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

    if (isset($_REQUEST["Invio"])&&($_POST['captcha'] == $_SESSION['captcha']))
    {
        $isok1=true;
        $email =trim(htmlspecialchars($_POST["email"]));
        $password =trim(htmlspecialchars($_POST["password"]));
        srand((double)microtime()*1000000);
        $codice=rand(1001,9999); 
        $_SESSION["codice"]=$codice;
        $_SESSION["emailPerLog"]=$email;
       
       

    }
    else
    {
        if(isset($_REQUEST["Invio"])&&($_POST['captcha'] != $_SESSION['captcha']))
        {
            
            $captchaErrato=true;
            
        }
    }
    
    if(isset($_REQUEST["Login"])&&isset($_SESSION["codice"]))
    {
        
        if($_SESSION["codice"]==$_REQUEST["codiceConferma"])
        {
            $_SESSION["logged_in"]=$_SESSION["emailPerLog"];
            unset($_SESSION["codice"]);
            unset($_REQUEST["Login"]);
            unset($_REQUEST["captcha"]);
            unset($_SESSION["emailPerLog"]);
           
        }
        else
        {
            $codiceErrato=true;
            unset($_REQUEST["Login"]);
            
        }
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
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script>
    function myFunction(){
        document.getElementById("Form").reset();
    }
</script>

</head>
<body onload="setInterval(myFunction, 60000)">
<img src="30secmod.gif" width="225" height="225" class="rounded mx-auto d-block img-fluid">
<div class="davide">
    <form action="" method="post" onsubmit="return Controllo()" id="Form" >
    <a id="font">Log-In</a>
    <br>
    <br>
        <div class="form-group w-75 centrare">
            <label id="l1" for="email" style="color:#a76b09;">Email: </label>
            <input type="email" name="email" placeholder="henrymiles@gmail.com" autocomplete="off" required id="email" class="form-control" style="background-color:#dda74f;">
        </div>
        <div class="form-group w-75 centrare">
            <label id="l2" for="email" style="color:#a76b09;">Password: </label>
            <input type="password" name="password" placeholder="********" maxlength="20" autocomplete="off" required id="password" class="form-control" style="background-color:#dda74f;">
        </div>        
       <br>
        
        <div>
            <div id="errore" class="alert alert-danger" role="alert"></div>
            <div id="info" class="alert alert-warning" role="alert"></div>
        </div>
        <div >
        <div>
            <p><img src="http://localhost/Projectworkits/Captcha/captcha.php" /></p>
            <label style="color:#a76b09;">CAPTCHA</label><br><input type="text" name="captcha" required style="background-color:#dda74f;"><br><br>
        </div>
        <input name="Invio" id="sub" type="submit" value="Accedi" class="btn btn-default glow-button" style="background-color:#d4c03d;">
            <?php
            if(isset($_SESSION["login_attempts"])){
                if ($_SESSION["login_attempts"] >= 3) {
                    echo("<script>document.getElementById('info').style.display='block'; document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Tre tentativi di login errati. Si prega di riprovare tra 1 minuto.';document.getElementById('sub').disabled=true; const myTimeout = setTimeout(enableSubmit, 10000); function enableSubmit(){document.getElementById('sub').disabled=false;} function myStopFunction(){clearTimeout(myTimeout);}</script>");
                    unset($_SESSION["login_attempts"]);  
                 } 
            }
               
            ?>
                
            
        </div>
    </form>
    <?php
            function attivaSubmit2(){
            
            echo("<div class='davide'>");
            echo('<form method="post" action="">');
            echo("<div class='form-group w-75 centrare'><label for='lCodice' style='color:#a76b09;'>Inserisci il codice ricevuto via mail</label>");
            echo("<input type='text' name='codiceConferma' id='lCodice' autocomplete='off' placeholder='codice' required style='background-color:#dda74f;'></div>");
            echo("<input type='submit' class='btn btn-default glow-button' name='Login' value='Login' style='background-color:#d4c03d;'>");
            echo("</form></div>");
            
        }
        if($codiceErrato==true)
        {
            echo("<script>document.getElementById('errore').style.display='block'; document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Codice errato!';</script>");
            attivaSubmit2();
            
        }

    ?>
</div>
</body>

<?php
    if($isok1){
        echo("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';</script>");
        $conn = mysqli_connect("localhost", "root", "", "projectworkits");
        $result = $conn->prepare("select * from tconticorrenti WHERE email = ? AND RegistrazioneConfermata=?");
        $regConfermata=1;
        $result->bind_param("si",$email,$regConfermata);
        $result->execute();
        $dati=$result->get_result();
        $ip=getPublicIP();
        $cc = $dati->fetch_assoc();
        if (mysqli_num_rows($dati) > 0&&password_verify($password, $cc["password"]))
        {   
            echo("<script>document.getElementById('errore').style.display='none';document.getElementById('info').style.display='block'; document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Inserire il codice inviato tramite mail nel campo sottostante.';</script>");
            date_default_timezone_set("Europe/Rome");
            $date= date("Y-m-d h:i:sa");
            $valido=1;
            $queryInsert=$conn->prepare("insert into taccessi (IndirizzoIP, DataOra, ValiditaAccesso) VALUES ( ?, ?, ?)");
            $queryInsert->bind_param("ssi",$ip,$date,$valido);
            if($queryInsert->execute())
            {
                $object="Conferma login";
                $header="From: zion.holdingcompanyita@gmail.com";
                $head = "MIME-Version: 1.0\r\n";
                $head .= "Content-type: text/html; charset=utf-8";
                $html=file_get_contents("email_template2.html");
                $html = str_replace("{CODICE}",$codice, $html);
                
                
                if(!mail($email,$object,$html,$head))
                {
                    echo("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore durante l'invio della mail. Si prega di riprovare.';</script>");
                }
                else
                {
                    attivaSubmit2();
                }
               
            }
            else
            {
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
                
            }
            else{
                echo("<script>document.getElementById('errore').style.display='block'; document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Errore generico';</script>");
            }


            
            if (isset($_SESSION["login_attempts"])) {
                $_SESSION["login_attempts"] += 1; 
            }else{
                $_SESSION["login_attempts"] = 1;
            }
            
            $queryInsert->close();
        }
        mysqli_close($conn);
        unset($_REQUEST["Invio"]);

        
    }
   
    if($captchaErrato)
    {
        echo("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Captcha errato!';</script>");
    }
?>
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