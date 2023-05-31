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


$userID=1;
// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits1";

$conn = new mysqli($servername, $username, $password, $dbname);
$dataInizio=0;
$dataFine=0;
if(($_GET["Datada"]!="")&&($_GET["DataA"]!="")){
    $dataInizio =$_GET["Datada"];
    $dataFine = $_GET["DataA"];
    $query= "SELECT m.Data, m.Importo, c.NomeCategoria
    FROM tmovimenticontocorrente m
    INNER JOIN tcategoriemovimenti c ON m.CategoriaMovimentoID = c.CategoriaMovimentoID
    WHERE m.ContoCorrenteID = ? AND m.Data BETWEEN ? AND ?
    ORDER BY m.Data DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $userID,$dataInizio,$dataFine);
    $stmt->execute();
    $result = $stmt->get_result();
}

else{
    
    $dataInizio = $_POST["dataInizio"];
    $dataFine = $_POST["dataFine"];
    // Esegui la query per ottenere gli ultimi movimenti e il saldo finale
    $query= "SELECT m.Data, m.Importo, c.NomeCategoria
            FROM tmovimenticontocorrente m
            INNER JOIN tcategoriemovimenti c ON m.CategoriaMovimentoID = c.CategoriaMovimentoID
            WHERE m.ContoCorrenteID = ? AND m.Data BETWEEN ? AND ?
            ORDER BY m.Data DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $userID,$dataInizio,$dataFine);
    $stmt->execute();
    $result = $stmt->get_result();
}


// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Movimenti</title>
</head>
<body>
    <h1>Ricerca Movimenti per Data</h1>

    <form method="post" action="http://localhost/Projectworkits/Ricerche/RicercaMovimenti3.php?Datada=&DataA=">
        <label for="dataInizio">Data Inizio</label><input type="date" name="dataInizio">
        <label for="dataFine">Data Fine</label><input type="date" name="dataFine">
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

</body>
</html>