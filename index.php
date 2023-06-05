<?php
    session_start();
    if(!isset($_SESSION["logged_in"]))
    {
        header("location: http://localhost/Projectworkits/login_definitivo.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Area Riservata</title>
    
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
<body >
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

    <div class="container text-warning davide">
        <?php
            $mail = $_SESSION["logged_in"];

            $conn=mysqli_connect("localhost", "root", "", "projectworkits");
            $strSQL="SELECT * FROM `tconticorrenti` WHERE `email`= '$mail'";
            $query=mysqli_query($conn, $strSQL);
            $row = mysqli_fetch_assoc($query);

            $strSQL2="SELECT * FROM `tmovimenticontocorrente` INNER JOIN tconticorrenti ON tmovimenticontocorrente.ContoCorrenteID = tconticorrenti.ContoCorrenteID
            WHERE  tconticorrenti.email = '$mail' ORDER BY `MovimentoID` DESC LIMIT 1";
            $query2=mysqli_query($conn, $strSQL2);
            $row2 = mysqli_fetch_assoc($query2);

            if (!$conn) {
                die("Connessione al database fallita: ". mysqli_connect_error());
                }
            
           
            echo("<h1>".$row['NomeTitolare']." ".$row['CognomeTitolare']."</h1><p>Conto aperto in data: ".$row['DataApertura']."</p><h3>Saldo:".$row2["Saldo"]."€</h3>");
        ?>
    </div>
    <div class="container-fluid text-warning davide" > 
        <h2>Ultimi movimenti</h2>
        <table class="table table-bordered text-warning">
            <thead>
                <tr>
                    <th>Destinatario Transazione</th>
                    <th>Data <small class ="text-secondary">(YYYY/MM/DD)</small></th>
                    <th>Importo</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $strSQL="SELECT * FROM `tmovimenticontocorrente` 
                            INNER JOIN tconticorrenti ON tmovimenticontocorrente.ContoCorrenteID = tconticorrenti.ContoCorrenteID
                            WHERE `email` = '$mail' 
                            ORDER BY `MovimentoID` DESC LIMIT 5";
                    $query=mysqli_query($conn, $strSQL);
                    while ($row = mysqli_fetch_assoc($query)) 
                    {
                        $dettaglio = "http://localhost/Projectworkits/DettaglioMovimento.php?ID=".$row["MovimentoID"];
                        echo("<tr>");
                        echo("<td><strong>".$row["DescrizioneEstesa"]."</strong></td>");
                        echo("<td>".$row["Data"]."</td>");
                        echo("<td>".$row["Importo"]."€</td>");
                        echo("<td><a href='$dettaglio' class='text-warning'>Dettagli</a></td>");
                        echo("</tr>");
                    }
                    //chiudo connessione
                    mysqli_close($conn);
                ?>
            </tbody>
        </table>
        <div class="inline">
            <a class = "text-warning" href= "EsportazioneExcel.php">Esporta in excel |</a>
            <a class = "text-warning" href= "EsportazioneCsv.php">| Esporta in csv</a>
        <div class="inline">
    </div>
</body>
</html>