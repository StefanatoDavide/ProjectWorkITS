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
$dbname = "projectworkits1";

$conn = new mysqli($servername, $username, $password, $dbname);
$CategoriaID =0;  
if($_GET["Categoria"]!=""){
    $CategoriaID=intval($_GET["Categoria"]);
    $query= "SELECT m.Data, m.Importo, c.NomeCategoria
    FROM tmovimenticontocorrente m
    INNER JOIN tcategoriemovimenti c ON m.CategoriaMovimentoID = c.CategoriaMovimentoID
    WHERE m.ContoCorrenteID = ? AND m.CategoriaMovimentoID= ?
    ORDER BY m.Data DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userID,$CategoriaID);
    $stmt->execute();
    $result = $stmt->get_result();

}

else{
    $CategoriaID=$_POST["Categorie"];
    // Esegui la query per ottenere gli ultimi movimenti e il saldo finale
    $query= "SELECT m.Data, m.Importo, c.NomeCategoria
    FROM tmovimenticontocorrente m
    INNER JOIN tcategoriemovimenti c ON m.CategoriaMovimentoID = c.CategoriaMovimentoID
    WHERE m.ContoCorrenteID = ? AND m.CategoriaMovimentoID= ?
    ORDER BY m.Data DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userID,$CategoriaID);
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
    <h1>Ricerca Movimenti per Categoria</h1>

    <form method="post" action="http://localhost/Projectworkits/Ricerche/RicercaMovimenti2.php?Categoria=">
        <select name="Categorie">
            <option value="1">Apertura Conto</option>
            <option value="2">Bonifico Entrata</option>
            <option value="3">Versamento Bancomat</option>
            <option value="4">Bonifico Uscita</option>
            <option value="5">Prelievo Contanti</option>
            <option value="6">Pagamento Utenze</option>
            <option value="7">Ricarica telefonica</option>
            <option value="8">Pagamento Bollette</option>
            <option value="9">Pagamento F24</option>
            <option value="10">Bollettino Postale</option>
            <option value="11">Ricarica Carta Prepagata</option>
            <option value="12">Bollo Auto</option>
            <option value="13">Accredito Stipendio</option>
        </select>
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
