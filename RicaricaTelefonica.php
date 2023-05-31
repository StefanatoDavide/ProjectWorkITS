<?php
session_start();
$_SESSION['ErroreImporto']="";
$_SESSION['ErroreOperatore']="";
$_SESSION['Importo']=0;
$_SESSION['Operatore']="";
// $userID=0;
// //Verifica se l'utente è autenticato tramite sessione
// if (!isset($_SESSION['logged_in'])) {
//    // L'utente non è autenticato, reindirizza alla pagina di accesso
//    header('Location: login.php');
//    exit;ì
// }
// else{
// $email = $_SESSION['email'];
// $saldoQuery = "SELECT ContoCorrenteID FROM tmovimenticontocorrente WHERE email = ?";
// $stmt1 = $conn->prepare($saldoQuery);
// $stmt1->bind_param("s", $email);
// $stmt1->execute();
// $result1 = $stmt1->get_result();
// $userID= $result1->fetch_assoc()['ContoCorrenteID'];
// }
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if ($_POST["Importo"]=="")
     {$_SESSION['ErroreImporto']= "Importo is required";}
   if ($_POST["Operatore"]=="")
     {$_SESSION['ErroreOperatore'] = "Operatore is required";}
}

// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits1";




// Ottieni l'ID dell'utente loggato dalla sessione
//$userID = $_SESSION['MovimentoID'];

$userID = 1;
$CategoriaMovimentoID=7;
date_default_timezone_set("Europe/Rome");
$data= date("Y-m-d h:i:sa");
$importo=0;
$saldo=0;
$messaggio="";
$operatore="";
$descrizione="";
$_SESSION['Importo']=$_POST["Importo"];
$_SESSION['Operatore']=$_POST["Operatore"];

if(isset($_POST['Invio']) && $_SESSION['Importo']!= "" && $_SESSION['Operatore']!="")
{
    $conn = new mysqli($servername, $username, $password, $dbname);
   
    $descrizione="Ricarica effettuata con l'operatore ".$operatore;
    // Calcola il saldo finale del conto corrente
    $saldoQuery = "SELECT Saldo FROM tmovimenticontocorrente WHERE ContoCorrenteID = ? ORDER BY Data DESC LIMIT 1;";
    $stmt1 = $conn->prepare($saldoQuery);
    $stmt1->bind_param("i", $userID);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $saldo= $result1->fetch_assoc()['Saldo'];
    if($saldo>=$importo){
        $messaggio = "Il tuo saldo è positivo. Eseguo l'operazione.....";
        $saldoRestante = $saldo-$_SESSION['Importo'];
        $messaggio .= "\nIl tuo saldo attuale è ".$saldoRestante;
        $query = "INSERT INTO tmovimenticontocorrente (ContoCorrenteID, Data, Importo, Saldo, CategoriaMovimentoID,DescrizioneEstesa) VALUES (?,?,?,?,?,?)";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("isddis", $userID,$data,$importo,$saldoRestante,$CategoriaMovimentoID,$descrizione);
        $stmt2->execute();
        $result1 = $stmt2->get_result();
        header("Location: ");
    }
    else{
        $messaggio = "Il tuo saldo è negativo. Mi dispiace ma non è possibile eseguire l'operazione";
    } 
    $importo=0;
    $operatore="";
    $conn->close();
}
else {
    $_SESSION['ErroreImporto']= "Ricarica Importo is required";
    $_SESSION['ErroreOperatore'] = "Ricarica Operatore is required";
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricarica Telefonica</title>
</head>

<body>
    <h1>Ricarica telefonica</h1>

    <form method="post" action="" >
        <label for="Operatore">Seleziona l'operatore telefonico</label>
        <select name="Operatore">
            <option value=""></option>
            <option value="TIM">TIM</option>
            <option value="Vodafone">Vodafone Italia</option>
            <option value="Wind">Wind Tre</option>
            <option value="Iliad">Iliad Italia</option>
        </select>
        <label for="Importo">Seleziona l'importo da utilizzare</label>
        <select name="Importo">
            <option value=""></option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
        </select>
        <input type="submit" name="Invio" value="Invio"/>
    </form>

    <span class="error"><?php echo $_SESSION['ErroreImporto'];?></span> <br>
    <span class="error"><?php echo $_SESSION['ErroreOperatore'];?></span>
    <p><?php echo $messaggio; ?></p>

</body>
</html>
<?php 
    unset($_SESSION['Importo']);
    unset($_SESSION['Operatore']);
    unset($_SESSION['ErroreImporto']);
    unset($_SESSION['ErroreOperatore']);
?>


