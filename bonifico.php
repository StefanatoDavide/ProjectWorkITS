<?php
    $isok=false;
    /*if(!isset($_SESSION["log_in"]))
    {
        header("location: login.php");
        exit;
    }*/

    if(isset($_REQUEST["Invio"]))
    {
        $isok=true;
        $ibanDest=$_REQUEST["ibanDest"];
        $importo=floatval($_REQUEST["importo"]);
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
            <input type="text" id="iban" name="ibanDest" autocomplete="off" placeholder="IT 99 C 12345 67890 123456789012" required>
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
        if($isok)
        {

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
                $strSQL->bind_param("s",$_SESSION["log_in"]);
                $strSQL->bind_param("s",$mail);
                $strSQL->execute();
                $result = $strSQL->get_result();
                $row = $result->fetch_assoc();
                $contoIdMittente=intval($row['ContoCorrenteID']);
                $nomeMittente=$row["NomeTitolare"];
                $cognomeMittente=$row['CognomeTitolare'];

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
                    $categoriaMovimento=4;
                    $descrizioneEstesa="Bonifico a favore di $nomeDest $cognomeDest";
                    $strInsert->bind_param("isiiis",$contoIdMittente,$data,$importo,$saldoAggiornato,$categoriaMovimento,$descrizioneEstesa);
                    $strInsert->execute();

                    $strInsert = $conn->prepare("INSERT INTO tmovimenticontocorrente (ContoCorrenteID,Data,Importo,Saldo,CategoriaMovimentoID,DescrizioneEstesa) VALUES (?,?,?,?,?,?) ");
                    $saldoDestAggiornato=$saldoCorrenteDest+$importo;
                    $categoriaMovimento=2;
                    $importo=-$importo;
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
            
            mysqli_close($conn);

        }
         

    ?>
</body>
</html>