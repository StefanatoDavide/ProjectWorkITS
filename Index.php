<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            if isOnlyDigits(ricercaString)==FALSE {
                return;
            }
            if ricercaString.include("-") {
                return;
            }
            FormRicercaUltimi.submit();
        }
    </script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md bg-light navbar-light">
            <a class="navbar-brand" href="index.php" colour>
                <img border="0" alt="W3Schools" src="CoinLogo.jpg" width="50" height="50">
            </a>  

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Account
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="Index.php">Informazioni account</a>
                            <a class="dropdown-item" href="http://localhost/Projectworkits/Account/ModificaPassword.php">Modifica password</a>
                            <a class="dropdown-item text-danger" href="http://localhost/Projectworkits/Account/LogOut.php">Log Out</a>
                        </div>
                    </li> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Ricerca ultimi movimenti
                        </a>
                        <div class="dropdown-menu">
                            <form class= "form-inline" name= "FormRicercaUltimi" action="" method="post">
                                <input class="form-control" type="number" id ="intRicerca" name="IntUltimi" placeholder="Trova ultimi X movimenti">
                                <button class="btn btn-success btn-block " type="submit" onclick="CercaUltimi()">Cerca</button>
                            </form>
                            <?php
                                $intRicercaUltimi = $_POST['IntUltimi'];
                                if (empty($intRicercaUltimi) ==false){
                                    header("Location: http://localhost/Projectworkits/Ricerche/RicercaMovimenti1.php?ID='$intRicercaUltimi'");
                                }
                            ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Ricerca per tipologia movimenti
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Bonifico Entrata</a>
                            <a class="dropdown-item" href="#">Versamento Bancomat</a>	
                            <a class="dropdown-item" href="#">Bonifico Uscita</a>
                            <a class="dropdown-item" href="#">Prelievo Contanti</a>
                            <a class="dropdown-item" href="#">Pagamento Utenze</a>
                            <a class="dropdown-item" href="#">Ricarica Telefonica</a>	
                            <a class="dropdown-item" href="#">Pagamento Bollette</a>	
                            <a class="dropdown-item" href="#">Pagamento F24</a>
                            <a class="dropdown-item" href="#">Bollettino Postale</a>	
                            <a class="dropdown-item" href="#">Ricarica Carta Prepagata</a>
                            <a class="dropdown-item" href="#">Bollo Auto</a>
                            <a class="dropdown-item" href="#">Accredito Stipendio</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Ricerca per data movimento
                        </a>
                        <div class="dropdown-menu">
                            <form class="form-inline needs-validation " action=Cerca()>
                                <div class="form-group mx-auto ">
                                    <label for="da" class="mr-sm-2">Da:  </label>
                                    <input class="form-control  " type="date" id="da">
                                </div> </br>
                                <div class="form-group mx-auto ">
                                    <label for="a" class="mr-sm-2">A:</label>
                                    <input class="form-control " type="date" id="a">
                                </div>
                                <button class="btn btn-success btn-block " type="submit">Cerca</button>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Servizi
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Ricarica Telefonica</a>
                            <a class="dropdown-item" href="#">Bonifico</a>
                        </div>
                    </li> 
                </ul>
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <?php
            //                   server      utente               password        database
            $conn=mysqli_connect("localhost", "root", "", "projectworkits");
            $strSQL="select * from tmovimenticontocorrente";
            $query=mysqli_query($conn, $strSQL);
            $row = mysqli_fetch_assoc($query);

            if (!$conn) {
                die("Connessione al database fallita: " . mysqli_connect_error());
                }
            
            //chiudo connessione
            mysqli_close($conn);
        ?>
        <h1>Nome Utente</h1>
        <p>Data Conto Corrente</p>
        <h3>Saldo: 1000$</h3>
    </div>
    <div class="container-fluid" > 
        <h2>Ultimi movimenti</h2>
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Destinatario Transazione</th>
                    <th>Data</th>
                    <th>Importo</th>
                    <th>Dettaglio Movimento</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>John</strong></td>
                    <td>12/03/2023</td>
                    <td>+15.00€</td>
                    <td><a>Dettagli</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>