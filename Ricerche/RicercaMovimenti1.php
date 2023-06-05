<?php
session_start();
// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits";

$conn = new mysqli($servername, $username, $password, $dbname);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Projectworkits/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
    
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

<?php

$userID=0;
//Verifica se l'utente è autenticato tramite sessione
if (!isset($_SESSION['logged_in'])) {
   // L'utente non è autenticato, reindirizza alla pagina di accesso
   header('Location: http://localhost/Projectworkits/login_definitivo.php');
   exit;
}
else{
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




$numeroMovimenti=0;
// Ottieni il numero di movimenti da visualizzare
if (isset($_GET['ID'])){
    $numeroMovimenti = intval($_GET["ID"]);
    $query = "SELECT m.Data, m.Importo, c.NomeCategoria
          FROM tmovimenticontocorrente m
          INNER JOIN tcategoriemovimenti c ON m.CategoriaMovimentoID = c.CategoriaMovimentoID
          WHERE m.ContoCorrenteID = ?
          ORDER BY m.Data DESC
          LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userID,$numeroMovimenti);
    $stmt->execute();
    $result = $stmt->get_result();
}
else{
    $numeroMovimenti=$_POST["numero_movimenti"];
    $query = "SELECT m.Data, m.Importo, c.NomeCategoria
    FROM tmovimenticontocorrente m
    INNER JOIN tcategoriemovimenti c ON m.CategoriaMovimentoID = c.CategoriaMovimentoID
    WHERE m.ContoCorrenteID = ?
    ORDER BY m.Data DESC
    LIMIT ?";   
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userID,$numeroMovimenti);
    $stmt->execute();
    $result = $stmt->get_result();
}


// Calcola il saldo finale del conto corrente
$saldoQuery = "SELECT Saldo FROM tmovimenticontocorrente WHERE ContoCorrenteID = ? ORDER BY Data DESC LIMIT 1;";
$stmt1 = $conn->prepare($saldoQuery);
$stmt1->bind_param("i", $userID);
$stmt1->execute();
$result1 = $stmt1->get_result();
$saldo= $result1->fetch_assoc()['Saldo'];
// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Movimenti</title>
</head>
<body>
    <div class = "container text-warning davide">
        <h1>Ricerca Movimenti</h1>

        <form method="post" action="http://localhost/Projectworkits/Ricerche/RicercaMovimenti1.php?ID=&NumeroMovimenti=">
            <label for="numero_movimenti">Numero Movimenti:</label>
            <input class="form text-light" style="background-color:#dda74f; border:black" type="number" id="numero_movimenti" name="numero_movimenti" value="<?php echo $numeroMovimenti; ?>">
            <button class="btn text-warning" type="submit">Cerca</button>
        </form>
    </div>

    <div class = "container-fluid text-warning davide">
        <h2>Movimenti</h2>
        <table class="table table-bordered text-warning">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Importo</th>
                    <th>Nome Categoria</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['Data']; ?></td>
                        <td><?php echo $row['Importo']; ?></td>
                        <td><?php echo $row['NomeCategoria']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <h2>Saldo Finale</h2>
        <p><?php echo ($saldo."€"); ?></p>
    </div>

</body>
</html>