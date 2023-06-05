<?php
session_start();
// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits";
$conn = new mysqli($servername, $username, $password, $dbname);

$filename = "InformazioniUtenti.csv";
$output = fopen('php://memory', 'w');
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 
    
<?php


// Start the output buffer.
ob_start();



// Ottieni l'ID dell'utente loggato dalla sessione
//$userID = $_SESSION['MovimentoID'];


$saldoQuery = "SELECT * FROM tmovimenticontocorrente WHERE ContoCorrenteID = ?";
$stmt1 = $conn->prepare($saldoQuery);
$stmt1->bind_param("i", $userID);
$stmt1->execute();
$result = $stmt1->get_result();

if(mysqli_num_rows($result) > 0){ 
 $intestazione = array('MovimentoID', 'ContoCorrenteID', 'Data', 'Importo', 'Saldo', 'CategoriaMovimentoID ', 'DescrizioneEstesa');
 $delimitatore = ",";
 ob_end_clean();

fputcsv($output, $intestazione,$delimitatore);


while ($row = $result->fetch_assoc()) {
    $lineData = array($row['MovimentoID'], $row['ContoCorrenteID'], $row['Data'], $row['Importo'], $row['Saldo'], $row['CategoriaMovimentoID'], $row['DescrizioneEstesa']);
    fputcsv($output, $lineData, $delimitatore); 
}

// Move back to beginning of file 
fseek($output, 0); 

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=InformazioniUtenti.csv');
// Close the file pointer with PHP with the updated output.
fpassthru($output);

}
else{
echo("errore in fase di elaborazione");    
exit;
}
?>

</body>



</html>