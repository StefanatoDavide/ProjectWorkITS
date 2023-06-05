<?php
session_start();
$_SESSION['ErroreImporto']="";
$_SESSION['ErroreOperatore']="";
$_SESSION['Importo']=0;
$_SESSION['Operatore']="";
$userID=0;

// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits";
$conn = new mysqli($servername, $username, $password, $dbname);
//Verifica se l'utente è autenticato tramite sessione
if (!isset($_SESSION['logged_in'])) {
   // L'utente non è autenticato, reindirizza alla pagina di accesso
   header('Location: http://localhost/Projectworkits/login_definitivo.php');
   exit;
} else {
$email = $_SESSION['logged_in'];
$saldoQuery = "SELECT tconticorrenti.ContoCorrenteID FROM tmovimenticontocorrente 
                INNER JOIN tconticorrenti ON tmovimenticontocorrente.ContoCorrenteID = tconticorrenti.ContoCorrenteID
                WHERE email = ?";
$stmt1 = $conn->prepare($saldoQuery);
$stmt1->bind_param("s", $email);
$stmt1->execute();
$result1 = $stmt1->get_result();
$userID= $result1->fetch_assoc()['ContoCorrenteID'];

}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if ($_POST["Importo"]=="")
     {$_SESSION['ErroreImporto']= "Importo è un campo obbligatorio";}
   if ($_POST["Operatore"]=="")
     {$_SESSION['ErroreOperatore'] = "Operatore è un campo obbligatorio";}
}






// Ottieni l'ID dell'utente loggato dalla sessione
//$userID = $_SESSION['MovimentoID'];

$CategoriaMovimentoID=7;
date_default_timezone_set("Europe/Rome");
$data= date("Y-m-d h:i:sa");
$importo=0;
$saldo=0;
$messaggio="";
$operatore="";
$descrizione="";
if (isset($_POST["Importo"])){
    $_SESSION['Importo']=$_POST["Importo"];
    $importo=$_POST["Importo"];
    $_SESSION['Operatore']=$_POST["Operatore"];
    $operatore=$_POST["Operatore"];
}

if(isset($_POST['Invio']) && $_SESSION['Importo']!= "" && $_SESSION['Operatore']!="")
{
   
   
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
    $_SESSION['ErroreImporto']= "Ricarica Importo è un campo obbligatorio";
    $_SESSION['ErroreOperatore'] = "Ricarica Operatore è un campo obbligatorio";
}


?>

<!DOCTYPE html>
<html>
<head>
    <script>
        function isOnlyDigits(string) {
            for (let i = 0; i < string.length; i++) {
                var ascii = string.charCodeAt(i);
                if (ascii < 48 || ascii > 57) {
                    return false;
                }
            }
            return true;
        }

        function CercaUltimi() {
            ricercaString = FormRicercaUltimi.intRicerca.value;
            if (isOnlyDigits(ricercaString)==FALSE) {
                return;
            }
            if (ricercaString.include("-")) {
                return;
            }
            FormRicercaUltimi.submit();
        }
        
        function CercaData(){
            daString = FormRicercaData.IDda.value;
            aString = FormRicercaData.IDa.value;
            FormRicercaData.submit();
        }
    </script>
    <title>Ricarica Telefonica</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md bg-body navbar-dark">
            <a class="navbar-brand" href="http://localhost/Projectworkits/index.php" colour>
            <img src="http://localhost/Projectworkits/30secmod.gif" width="225" height="50"  style="width:130px" class="rounded d-block img-fluid">
            </a>  

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse davide" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning" href="#" id="navbardrop" data-toggle="dropdown">
                            Account
                        </a>
                        <div class="dropdown-menu bg-warning">
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Index.php">Informazioni account</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Account/modificapassword.php">Modifica password</a>
                            <a class="dropdown-item text-danger" href="http://localhost/Projectworkits/Account/LogOut.php">Log Out</a>
                        </div>
                    </li> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning" href="#" id="navbardrop" data-toggle="dropdown">
                            Ricerca ultimi movimenti
                        </a>
                        <div class="dropdown-menu pt-0 pb-0 bg-warning">

                            <form class= "form-inline" name= "FormRicercaUltimi" action="" method="get">
                                <input class="form-control text-light" style="background-color:#dda74f; border:black" type="number" id ="intRicerca" name="IntUltimi" placeholder="Trova ultimi X movimenti">
                                <button class="btn btn-block text-warning" style="background-color:#070707;" type="submit" onclick="CercaUltimi()">Cerca</button>
                            </form>
                            <?php
                                if(isset($_GET['IntUltimi'])){
                                    $intRicercaUltimi = $_GET['IntUltimi'];
                                    $url = "http://localhost/Projectworkits/Ricerche/RicercaMovimenti1.php?ID=".$intRicercaUltimi;
                                    
                                    if (empty($intRicercaUltimi) ==false){
                                        header("Location: ".$url);
                                    }
                                }
                            ?>

                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning" href="#" id="navbardrop" data-toggle="dropdown">
                            Ricerca per tipologia movimenti
                        </a>
                        <div class="dropdown-menu bg-warning">
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=2">Bonifico Entrata</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=3">Versamento Bancomat</a>	
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=4">Bonifico Uscita</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=5">Prelievo Contanti</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=6">Pagamento Utenze</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=7">Ricarica Telefonica</a>	
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=8">Pagamento Bollette</a>	
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=9">Pagamento F24</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=10">Bollettino Postale</a>	
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=11">Ricarica Carta Prepagata</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=12">Bollo Auto</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?ID=13">Accredito Stipendio</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning" href="#" id="navbardrop" data-toggle="dropdown">
                            Ricerca per data movimento
                        </a>
                        <div class="dropdown-menu pt-0 pb-0 bg-warning">
                            <form class="form-inline needs-validation" name= "FormRicercaData" method="get" action="http://localhost/Projectworkits/Ricerche/RicercaMovimenti3.php">
                                <div class="form-group mx-auto ">
                                    <label for="da" class="float-start">Da:  </label>
                                    <input class="form-control" style="background-color:#dda74f; border:black" type="date" id = "IDda" name="Datada">
                                </div> </br>
                                <div class="form-group mx-auto ">
                                    <label for="a" class="mr-sm-2"> A:</label>
                                    <input class="form-control" style="background-color:#dda74f; border:black" type="date" id = "IDa" name="DataA">
                                </div>
                                <button class="btn btn-block text-warning" style="background-color:#070707;" type="submit" >Cerca</button>

                                <?php
                                
                                if(isset($_GET['Datada']) && isset($_GET["DataA"])){
                                    
                                    $data1 = $_GET['Datada'];
                                    $data2 = $_GET['DataA'];
                                    $url = "http://localhost/Projectworkits/Ricerche/RicercaMovimenti3.php?DA=".$data1."&A=".$data2;
                                    
                                    
                                    if (empty($data1) ==false){
                                        header("Location: http://localhost/Projectworkits/Ricerche/RicercaMovimenti3.php");
                                    }else{
                                        
                                    }                                        
                                }
                                ?>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-warning" href="#" id="navbardrop" data-toggle="dropdown">
                            Servizi
                        </a>
                        <div class="dropdown-menu bg-warning">
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Servizi/RicaricaTelefonica.php">Ricarica Telefonica</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Servizi/bonifico.php">Bonifico</a>
                        </div>
                    </li> 
                </ul>
            </div>
        </nav>
    </header>

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


