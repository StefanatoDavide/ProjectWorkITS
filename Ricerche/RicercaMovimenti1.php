<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricerca</title>
</head>
<body>
<?php
// session_start();
// $userID=0;
// //Verifica se l'utente è autenticato tramite sessione
// if (!isset($_SESSION['logged_in'])) {
//    // L'utente non è autenticato, reindirizza alla pagina di accesso
//    header('Location: login.php');
//    exit;
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


$userID=2;
// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits";

$conn = new mysqli($servername, $username, $password, $dbname);

$numeroMovimenti=0;
// Ottieni il numero di movimenti da visualizzare
if($_GET["NumeroMovimenti"]!=""){
    $numeroMovimenti = intval($_GET["NumeroMovimenti"]);
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
    <h1>Ricerca Movimenti</h1>

    <form method="post" action="http://localhost/Projectworkits/Ricerche/RicercaMovimenti1.php?NumeroMovimenti=">
        <label for="numero_movimenti">Numero Movimenti:</label>
        <input type="number" id="numero_movimenti" name="numero_movimenti" value="<?php echo $numeroMovimenti; ?>">
        <button type="submit">Cerca</button>
    </form>

    <h2>Movimenti</h2>
    <table>
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
    <p><?php echo $saldo; ?></p>

</body>
</html>