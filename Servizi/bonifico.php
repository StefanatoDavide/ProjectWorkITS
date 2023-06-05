<?php
    session_start();
    $isok=false;
    $isok2=false;
    $codiceErrato=false;
    if(!isset($_SESSION["logged_in"]))
    {
        header("location: http://localhost/Projectworkits/login_definitivo.php");
        exit;
    }

    if(isset($_REQUEST["Invio"]))
    {
        $isok=true;
        $_SESSION["ibanDest"]=$_REQUEST["ibanDest"];
        $importo=floatval($_REQUEST["importo"]);
        $_SESSION["importo"]=$importo;
        srand((double)microtime()*1000000);
        $codice=rand(1001,9999); 
        $_SESSION["codice"]=$codice;
        $mail=$_SESSION["logged_in"];
        
    }

    if(isset($_REQUEST["Conferma"]))
    {   
            if($_REQUEST["codiceConferma"]==$_SESSION["codice"])
            {
                $isok2=true;

            }
            else
            {
                $codiceErrato=true;
            }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina bonifico</title>
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

    <form action="" method="post">
        <div>
            <h4>Bonifico</h4>
        </div>
        <div>
            <label for="ibanDest">Inserisci conto corrente del destinatario:</label>
            <input type="text" id="ibanDest" name="ibanDest" autocomplete="off" placeholder="IT 99 C 12345 67890 123456789012" required>
        </div>
        <div>
            <label for="importo">Inserisci importo del bonifico:</label>
            <input type="text" id="importo" name="importo" autocomplete="off" required>
        </div>
        <div>
            <p id="errore"></p>
            <p id="info"></p>
        </div>
        <div>
            <input type="submit" id="Invio" name="Invio" value="Effettua bonifico">
        </div>    
    </form>
    <?php
        function attivaSubmit2()
        {
            echo('<form method="post" action="">');
            echo("<div><label for='lCodice'>Inserisci il codice ricevuto via mail</label>");
            echo("<input type='text' name='codiceConferma' id='lCodice' autocomplete='off' placeholder='codice' required></div><br>");
            echo("<div><input type='submit' name='Conferma' value='Conferma'></div>");
            echo("</form>");
            
        }

        if($codiceErrato)
        {
            attivaSubmit2();
            echo("<script>document.getElementById('errore').style.display='block'; document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Codice di conferma errato';</script>");
            
        }


    ?>
    <?php
        if($isok)
        {

                    //Invio mail
                    $object="Conferma bonifico";
                    $header="From: zion.holdingcompanyita@gmail.com";
                    $head = "MIME-Version: 1.0\r\n";
                    $head .= "Content-type: text/html; charset=utf-8";
                    $html=file_get_contents("email_template3.html");
                    $html = str_replace("{CODICE}",$codice, $html);
                    
                    
                    if(!mail($email,$object,$html,$head))
                    {
                        echo("<script>document.getElementById('errore').style.display='block';document.getElementById('errore').innerHTML='';document.getElementById('errore').innerHTML='Si è verificato un errore durante l'invio della mail. Si prega di riprovare.';</script>");
                    }
                    else
                    {
                        echo("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Email di conferma inviata.';</script>");
                        attivaSubmit2();
                    }
        }
        if($isok2)
        {
            $ibanDest=$_SESSION["ibanDest"];
            $importo=$_SESSION["importo"];
            $conn=mysqli_connect("localhost","root", "","projectworkits");
            $strSQL = $conn->prepare("SELECT * FROM tconticorrenti WHERE IBAN=?");
            $strSQL->bind_param("s",$ibanDest);
            $strSQL->execute();
            $result = $strSQL->get_result();
            
            if (mysqli_num_rows($result)>0)
            {
                $row = $result->fetch_assoc();
                $idDest=intval($row["ContoCorrenteID"]);
                $nomeDest=$row["NomeTitolare"];
                $cognomeDest=$row["CognomeTitolare"];


                $strSQL = $conn->prepare("SELECT * FROM tconticorrenti WHERE email=?");
                $mail=$_SESSION["logged_in"];
                $strSQL->bind_param("s",$mail);
                $strSQL->execute();
                $result = $strSQL->get_result();
                $row = $result->fetch_assoc();
                $contoIdMittente=intval($row["ContoCorrenteID"]);
                $nomeMittente=$row["NomeTitolare"];
                $cognomeMittente=$row["CognomeTitolare"];

                $strSQL = $conn->prepare("SELECT * FROM tmovimenticontocorrente WHERE ContoCorrenteID=? ORDER BY MovimentoID DESC LIMIT 1");
                $strSQL->bind_param("s",$contoIdMittente);
                $strSQL->execute();
                $result = $strSQL->get_result();
                $row = $result->fetch_assoc();
                $saldoCorrente=floatval($row["Saldo"]);
                $saldoAggiornato=$saldoCorrente-$importo;
                if($saldoAggiornato>0)
                {
                    //saldo utente destinatario
                    $strSQL = $conn->prepare("SELECT * FROM tmovimenticontocorrente WHERE ContoCorrenteID=? ORDER BY MovimentoID DESC LIMIT 1");
                    $strSQL->bind_param("s",$idDest);
                    $strSQL->execute();
                    $result = $strSQL->get_result();
                    $row = $result->fetch_assoc();
                    $saldoCorrenteDest=floatval($row["Saldo"]);
                    $strInsert = $conn->prepare("INSERT INTO tmovimenticontocorrente (ContoCorrenteID,Data,Importo,Saldo,CategoriaMovimentoID,DescrizioneEstesa) VALUES (?,?,?,?,?,?) ");
                    $data=date('Y-m-d');
                    $importo=-$importo;
                    $categoriaMovimento=4;
                    $descrizioneEstesa="Bonifico a favore di $nomeDest $cognomeDest";
                    $strInsert->bind_param("isiiis",$contoIdMittente,$data,$importo,$saldoAggiornato,$categoriaMovimento,$descrizioneEstesa);
                    $strInsert->execute();
                    
                    $strInsert = $conn->prepare("INSERT INTO tmovimenticontocorrente (ContoCorrenteID,Data,Importo,Saldo,CategoriaMovimentoID,DescrizioneEstesa) VALUES (?,?,?,?,?,?) ");
                    $importo=-$importo;
                    $saldoDestAggiornato=$saldoCorrenteDest+$importo;
                    $categoriaMovimento=2;
                    $descrizioneEstesa="Bonifico disposto da $nomeMittente $cognomeMittente";
                    $strInsert->bind_param("isiiis",$idDest,$data,$importo,$saldoDestAggiornato,$categoriaMovimento,$descrizioneEstesa);
                    $strInsert->execute();
                    $result = $strSQL->get_result();
                    $strInsert->close();
                    echo("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Bonifico effettuato con successo.';</script>");
                }
                else
                {
                     echo("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='Importo superiore al saldo disponibile nel conto.';</script>");
                }
                    
                
            }
            else
            {
                echo("<script>document.getElementById('info').style.display='block';document.getElementById('info').innerHTML='';document.getElementById('info').innerHTML='IBAN inserito non valido.';</script>");
                
            }
            $strSQL->close();
            unset( $_SESSION["codice"]);
            unset($_SESSION["importo"]);
            unset($_SESSION["ibanDest"]);
            mysqli_close($conn);
        }
         

    ?>
</body>
</html>