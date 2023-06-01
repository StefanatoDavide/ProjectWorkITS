<?php
    error_reporting(0);
    session_start();
    $isok1=false;
    $captchaErrato=false;
    
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
    
    if(isset($_REQUEST["Login"]))
    {
        $codiceErrato=false;
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
<style>
    #errore{
        display:none;
        color:#d4c03d;
    }
    #info{
        display:none;
        color:#d4c03d;
    }
    #demo{
        text-align: center;
        font-size: 10px; 
    }
    
    body {
      font-family: Arial, sans-serif;
      background-image: url(marmosfondo.jpg);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      background-color: black;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 400px;
      max-width: 100%;
      text-align: center;
      border-radius: 50px 50px 50px 50px;
      position: absolute;
      bottom: 50px;
      
      
    }

    .container h2 {
      margin-bottom: 30px;
      color: black;
    }

    .container input[type="text"],
    .container input[type="password"],
    .container input[type="email"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 50px;
      border: 1px solid #ccc;
      background-color: #d4c03d;
    }



    .container input[type="submit"] {
      background-color: black;
      color: #d4c03d;
      border: none;
      padding: 12px 0;
      width: 100%;
      border-radius: 50px;
      cursor: pointer;
    }

    ::placeholder {
      color: black;
    }

    .container input[type="submit"]:hover {
      background-color: #d4c03d;
      color: black;
    }

    .container p.error-message {
      color: red;
      margin-bottom: 20px;
    }

    @font-face {
      font-family: 'AlexBrush-Regular';
      src: url('AlexBrush-Regular.eot');
      src: local('AlexBrush-Regular'), url('AlexBrush-Regular.ttf') format('truetype');
    }

    #font {
      font: 65px 'AlexBrush-Regular', Georgia, serif;
      color: #d4c03d;
      position: relative;
      bottom: 225spx;
    }

    .img {
      position: absolute;
      top: 10px
    }

    .glow-button:hover {
      color: rgba(255, 255, 255, 1);
      box-shadow: 0 5px 15px rgba(207, 117, 6, 0.4);
    }
    #bord{
      border-color: #d4c03d;
    }
  
</style>
<script>
    function myFunction(){
        document.getElementById("Form").reset();
    }
</script>

</head>
<body onload="setInterval(myFunction, 30000)">
<img src="30secmod.gif" width="225" height="225" class="img">
<div class="container">
    <form action="" method="post" onsubmit="return Controllo()" id="Form">
    <a id="font">Log-In</a>
        <div>
            <label id="l1" for="email" style="color:#d4c03d;">Email: </label>
            <input type="email" name="email" placeholder="henrymiles@gmail.com" autocomplete="off" required id="email">
        </div>
        <div >
            <label id="l2" for="email" style="color:#d4c03d;">Password: </label>
            <input type="password" name="password" placeholder="********" maxlength="20" autocomplete="off" required id="password">
        </div>        

        <div>
            <p id="errore"></p>
            <p id="info" ></p>
        </div>
        <div >
        <div>
            <p><img src="http://localhost/ProjectWorkITS/ProjectWorkITS/ProjectWorkITS/captcha.php" /></p>
            <label style="color:#d4c03d;">CAPTCHA <input type="text" name="captcha" required><br><br>
        </div>
        <input name="Invio" id="sub" type="submit" value="Accedi" class="glow-button">
            <?php
                if ($_SESSION["login_attempts"] >= 3) {
                   echo("<script>document.getElementById('info').style.display='block'; document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Tre tentativi di login errati. Si prega di riprovare tra 1 minuto.';document.getElementById('sub').disabled=true; const myTimeout = setTimeout(enableSubmit, 10000); function enableSubmit(){document.getElementById('sub').disabled=false;} function myStopFunction(){clearTimeout(myTimeout);}</script>");
                   unset($_SESSION["login_attempts"]);  
                } 
            ?>
                
            
        </div>
    </form>
    <?php
        function attivaSubmit2(){
           
            echo('<form method="post" action="">');
            echo("<label for='lCodice'>Inserisci il codice ricevuto via mail</label>");
            echo("<input type='text' name='codiceConferma' id='lCodice' autocomplete='off' placeholder='codice' required>");
            echo("<input type='submit' name='Login' value='Login'>");
            echo("</form>");
            
        }
        if($codiceErrato==true)
        {
            echo("<div class='alert alert-danger' role='alert'>Codice errato! Riprovare.</div>");
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
            echo("<script>document.getElementById('info').style.display='block'; document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Inserire il codice inviato tramite mail nel campo sottostante.';</script>");
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