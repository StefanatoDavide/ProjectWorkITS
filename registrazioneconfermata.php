<?php
    $isok=false;
    if($_GET["Token"]!="")
    {
        $isok=true;
        $token=$_GET["Token"];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione confermata</title>
</head>
<body>
   <?php
        if($isok)
        {
            /*function IBAN_generator($acc){

                if(strlen($acc)!=23)
                    return;
                $temp_str=substr($acc,0,3);
                $remainder =$temp_str % 97;
                for($i=3;$i<=22;$i++)
                {
                    $remainder =$remainder .substr($acc,$i,1);
                    $remainder  = $remainder  % 97;
                }
                $con_num = 98 - $remainder;
                if ($con_num<10)
                {
                    $con_num="0".$con_num;
                }
                $IBAN="IT".$con_num.substr($acc,0,17);
                return $IBAN;
            }*/
            $IBAN='IT99C1234567890123456789012';
            
            $conn=mysqli_connect("localhost","root", "","projectworkits");
            $queryUpdate=$conn->prepare("UPDATE tconticorrenti SET RegistrazioneConfermata=?, IBAN= ? WHERE Token=?");
            $registrazioneConfermata=1;
            $queryUpdate->bind_param("sss",$registrazioneConfermata,$IBAN,$token);
            if($queryUpdate->execute())
            {
                $querySelect=$conn->prepare("SELECT * FROM tconticorrenti WHERE Token=?");
                $querySelect->bind_param("s",$token);
                $querySelect->execute();
                $result = $querySelect->get_result();
                $row = $result->fetch_assoc();
                $contoId=$row['ContoCorrenteID'];
                $queryInsert=$conn->prepare("INSERT INTO tmovimenticontocorrente (ContoCorrenteID,Data,Importo,Saldo,CategoriaMovimentoID, DescrizioneEstesa) VALUES (?,?,?,?,?,?)");
                $data=date('Y-m-d');
                $importo=0;
                $saldo=0;
                $categoriaMovimenti=1;
                $desc="Apertura Conto";
                $queryInsert->bind_param("ssiiis",$contoId,$data,$importo,$saldo,$categoriaMovimenti,$desc);
                if($queryInsert->execute())
                {
                    echo("<h4>La registrazione è andata a buon fine! Sarai reindirizzato alla pagina principale.</h4>");
                    header("refresh:5;url=http://localhost/ProjectWorkITS/index.php");
                    echo "<p>Se il tuo browser non supporta il redirect, clicca <a href='http://localhost/ProjectWorkITS/index.php'>qui</a></p>";
                }
                else
                {
                    echo("<p>Si è verificato un errore. Verrai reindirizzato alla pagina di registrazione");
                    header("refresh:5;url=http://localhost/ProjectWorkITS/registrazione.php");
                    echo "<p>Se il tuo browser non supporta il redirect, clicca <a href='http://localhost/ProjectWorkITS/index.php'>qui</a></p>";
                }

                
            }
        }
        else
        {
            header("Location: http://localhost/ProjectWorkITS/registrazione.php ");
            exit;
        }
   
   ?>
</body>
</html>