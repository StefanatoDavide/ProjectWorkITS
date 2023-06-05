<?php
session_start();
    $isok=false;
    $codiceErrato=false;
    if(!isset($_SESSION["log_in"]))
    {
        header("location: login.php");
        exit;
    }
    if(isset($_REQUEST["Invio"]))
    {
        $isok=true;
        $password = trim(htmlspecialchars($_REQUEST["password"]));
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica password</title>
    <style>
        #errore {
            display: none;
            color: #d4c03d;
        }

        #info {
            display: none;
            color:#d4c03d;
        }
        

        #message {
            display: none;
            background: black;
            color: #000;
            position: absolute;
            right: 10px;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }


        .invalid {
            color: #d4c03d;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>
</head>
<body>
    <form action="" method="post" onsubmit="return Controllo()">
        <div>
            <h4>Modifica password</h4>
        </div>
        <div>
            <label for="password">Inserisci nuova password:</label>
            <input type="password" id="password" name="password" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="********" required>
        </div>
        <div>
            <label for="passwordConferma">Conferma password:</label>
            <input type="password" id="passwordConferma" name="passwordConferma" placeholder="********" autocomplete="off" required>
        </div>
        <div>
            <p id="errore"></p>
            <p id="info"></p>
        </div>
        <div>
            <input type="submit" id="Invio" name="Invio" value="Cambia password">
        </div>    
    </form>
    <div id="message">
        <h3 id="error">La password deve contenere i seguenti requisiti:</h3>
        <p id="letter" class="invalid">Una lettera <b>minuscola</b></p>
        <p id="capital" class="invalid">Una lettera <b>maiuscola</b></p>
        <p id="number" class="invalid">Un <b>numero</b></p>
        <p id="length" class="invalid">Minimo <b>8 caratteri</b>, massimo <b>20</b></p>
    </div>

</body>
<?php
    if($isok)
    {
        $conn = mysqli_connect("localhost", "root", "", "projectworkits");
        $queryUpdate=$conn->prepare("UPDATE tconticorrenti SET password=? WHERE email=?");
        //$mail="tomas.arnaldi@allievi.itsdigitalacademy.com";
        $mail=$_SESSION["log_in"];
        $queryUpdate->bind_param("ss",$hash,$mail);

        if($queryUpdate->execute())
        {
            echo ("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Password cambiata con successo!';</script>");
        }
        else
        {
            echo ("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Errore generico. Riprovare.';</script>");
        }
    }

?>
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
    function Controllo()
    {
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
</html>