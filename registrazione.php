<?php
session_start();
$isok = false;
$captchaErrato = false;
if (isset($_REQUEST["invio"]) && $_POST['captcha'] == $_SESSION['captcha']) {

    $isok = true;
    $mail = trim(htmlspecialchars($_REQUEST["email"]));
    $password = trim(htmlspecialchars($_REQUEST["password"]));
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $nome = trim(htmlspecialchars($_REQUEST["nomeTitolare"]));
    $cognome = trim(htmlspecialchars($_REQUEST["cognomeTitolare"]));
    $data = date('Y-m-d');
    $token = bin2hex(openssl_random_pseudo_bytes(6));
} else {
    if (isset($_REQUEST["invio"]) && $_POST['captcha'] != $_SESSION['captcha']) {
        $captchaErrato = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">




</head>


</head>

<body>
    <header>

    </header>


    <a href="#"><img src="30secmod.gif" width="225" height="225" class="rounded mx-auto d-block img-fluid"></a>>
   
    <div class="davide">
        <form action="" method="POST" onsubmit="return Controllo()">
            <div style="background-color:rgba(0, 0, 0, 0.1);">
                <div id="font">
                    Registrazione
                </div>
            </div>
            <div class="form-group w-75 centrare">
                <label for="email" id="l1" style="color:#a76b09;">Email: </label>
                <input type="email" id="email" name="email" autocomplete="off" placeholder="henrymiles@gmail.com"
                    required class="form-control" style="background-color:#dda74f;">
            </div>
            <div class="form-group w-75 centrare">
                <label for="password" id="l2" style="color:#a76b09;">Password: </label>
                <input type="password" id="password" name="password" autocomplete="off"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="Deve contenere almeno un numero e una lettera maiuscola, deve avere un numero di carateri compreso tra 8 e 20"
                    maxlength="20" placeholder="******" required class="form-control" style="background-color:#dda74f;">
            </div>
            <div class="form-group w-75 centrare">
                <label for="passwordConferma" id="l3" style="color:#a76b09;">Conferma password: </label>
                <input type="password" id="passwordConferma" name="passwordConferma" autocomplete="off"
                    placeholder="******" maxlength="20" required class="form-control" style="background-color:#dda74f;">
            </div>
            <div class="form-group w-75 centrare">
                <label for="nomeTitolare" id="l4" style="color:#a76b09;">Nome titolare: </label>
                <input type="text" id="nomeTitolare" name="nomeTitolare" autocomplete="off" placeholder="Henry"
                    required class="form-control" style="background-color:#dda74f;">
            </div>
            <div class="form-group w-75 centrare">
                <label for="cognomeTitolare" id="l5" style="color:#a76b09;">Cognome titolare: </label>
                <input type="text" id="cognomeTitolare" name="cognomeTitolare" autocomplete="off" placeholder="Miles"
                    required class="form-control" style="background-color:#dda74f;"> <br> 
            </div>
            <div>
                <p id="errore" class="alert alert-danger" role="alert"></p>
                <p id="info" class="alert alert-warning" role="alert"></p>
            </div>
            <div>
            <p><img src="http://localhost/ProjectWorkITS/ProjectWorkITS/ProjectWorkITS/captcha.php" /></p>
                <label style="color:#a76b09;">CAPTCHA<br> <input type="text" name="captcha" required style="background-color:#dda74f;"><br><br>

            </div>
            <div class="button">
                <input type="reset" id="reset" name="reset" value="Svuota campi" class="btn btn-default glow-button" style="background-color:#d4c03d;">
            </div>
            <br>
            <div class="button">
                <input type="submit" id="invio" name="invio" value="Registrati" class="btn btn-default glow-button" style="background-color:#d4c03d;">
            </div>
        </form>
    </div>
    <div id="message">
        <h3 id="error">La password deve contenere i seguenti requisiti:</h3>
        <p id="letter" class="invalid">Una lettera <b>minuscola</b></p>
        <p id="capital" class="invalid">Una lettera <b>maiuscola</b></p>
        <p id="number" class="invalid">Un <b>numero</b></p>
        <p id="length" class="invalid">Minimo <b>8 caratteri</b>, massimo <b>20</b></p>
    </div>
    <footer>

    </footer>
</body>

<script>

    var myInput = document.getElementById("password");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");
    // When the user clicks on the password field, show the message box
    myInput.onfocus = function () {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function () {
        document.getElementById("message").style.display = "none";
    }
    // When the user starts to type something inside the password field
    myInput.onkeyup = function () {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");

        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");

        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");

        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");

        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");

        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");

        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
    function Controllo() {

        let pass1 = document.getElementById("password").value;
        let pass2 = document.getElementById("passwordConferma").value;

        if (pass1 != pass2) {
            document.getElementById("errore").style.display = "block";
            document.getElementById("errore").innerHTML = "";
            document.getElementById("errore").innerHTML = "Le due password non coincidono!";
            return false;

        }


        if (pass1.length < 8) {
            document.getElementById("errore").style.display = "block";
            document.getElementById("errore").innerHTML = "";
            document.getElementById("errore").innerHTML = "La password deve avere almeno 8 caratteri!";
            return false;
        }

        //maximum length of password validation  
        if (pass1.length > 20) {
            document.getElementById("errore").style.display = "block";
            document.getElementById("errore").innerHTML = "";
            document.getElementById("errore").innerHTML = "La password deve avere al massimo 20 caratteri!";
            return false;
        }


        return true;


    }
</script>

<?php
if ($isok) {
    //Verifico che la mail non sia già esistente

    $conn = mysqli_connect("localhost", "root", "", "projectworkits");
    $strSQL = $conn->prepare("SELECT * FROM tconticorrenti WHERE email=?");
    //$strSQL="SELECT * FROM tconticorrenti WHERE email='$mail'";
    $strSQL->bind_param("s", $mail);
    $strSQL->execute();
    $result = $strSQL->get_result();
    //$result=mysqli_query($conn,$strSQL);
    if (mysqli_num_rows($result) > 0) {

        echo ("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Questa mail è già esistente!';</script>");
        $strSQL->close();
    } else {
        $queryInsert = $conn->prepare("INSERT INTO tconticorrenti (email, password, CognomeTitolare,NomeTitolare,DataApertura,RegistrazioneConfermata,Token) VALUES (?,?,?,?,?,?,?);");
        $registrazioneConf = 0;
        $queryInsert->bind_param("sssssis", $mail, $hash, $cognome, $nome, $data, $registrazioneConf, $token);

        if ($queryInsert->execute()) {

            $object = "Conferma registrazione";
            $header = "From: zion.holdingcompanyita@gmail.com";
            $head = "MIME-Version: 1.0\r\n";
            $head .= "Content-type: text/html; charset=utf-8";
            $message = "Gentile $nome $cognome,\ngrazie per esserti registrato. Conferma il tuo account al seguente link: http://localhost/ProjectWorkITS/registrazioneconfermata.php.?Token='$token'\nLa Direzione";
            $html = file_get_contents("email_template.html");
            $html = str_replace("{NOME}", $nome, $html);
            $html = str_replace("{COGNOME}", $cognome, $html);
            $html = str_replace("{TOKEN}", $token, $html);


            if (mail($mail, $object, $html, $head)) {
                echo ("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Email di conferma inviata!';</script>");
            } else {

                $queryDelete = $conn->prepare("DELETE FROM tconticorrenti WHERE email=?");
                $queryDelete->bind_param("s", $mail);
                if ($queryDelete->execute()) {
                    echo ("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore nell'invio della mail. Riprovare.';</script>");
                } else {
                    echo ("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore imprevisto. Riprovare più tardi.';</script>");
                }
                $queryDelete->close();

            }

            $queryInsert->close();
            mysqli_close($conn);
        } else {
            echo ("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore di registrazione. Riprovare.';</script>");
        }

    }
    unset($_REQUEST["invio"]);

}
if ($captchaErrato) {
    echo ("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Captcha errato!';</script>");
}

?>

</html>