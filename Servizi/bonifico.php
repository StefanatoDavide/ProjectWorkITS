<?php
    session_start();
    $isok=false;
    $isok2=false;
    $codiceErrato=false;
    if(!isset($_SESSION["log_in"]))
    {
        header("location: login.php");
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
        $mail=$_SESSION["log_in"];
        
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
</head>
<body>
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
                    
                    
                    if(!mail($mail,$object,$html,$head))
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
                $mail=$_SESSION["log_in"];
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