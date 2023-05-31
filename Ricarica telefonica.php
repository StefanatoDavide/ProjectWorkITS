<?php
//session_start();

// Verifica se l'utente è autenticato tramite sessione
//if (!isset($_SESSION['logged_in'])) {
    // L'utente non è autenticato, reindirizza alla pagina di accesso
    //header('Location: login.php');
  //  exit;
//}

// Connessione al database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits1";

$conn = new mysqli($servername, $username, $password, $dbname);


// Ottieni l'ID dell'utente loggato dalla sessione
//$userID = $_SESSION['MovimentoID'];
$userID = 1;

// Ottieni il numero di movimenti da visualizzare
$numeroMovimenti = intval($_POST['numero_movimenti']);

// Esegui la query per ottenere gli ultimi movimenti e il saldo finale
$query = "INSERT INTO tmovimenticontocorrente (ContoCorrenteID, Data, Importo, Saldo, CategoriaMovimentoID, DescrizioneEstesa) VALUES (value1, value2, value3,...)";
$result = $conn->query($query);

// Calcola il saldo finale del conto corrente
$saldoQuery = "SELECT Saldo FROM tmovimenticontocorrente WHERE ContoCorrenteID = $userID";
$saldoResult = $conn->query($saldoQuery);
$saldo = $saldoResult->fetch_assoc()['Saldo'];

// Chiudi la connessione al database
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ricerca Movimenti</title>
</head>
<body>
    <h1>Ricarica telefonica</h1>

    <form method="post" action="">
        <label for="Operatore">Seleziona l'operatore telefonico</label>
        <select name="Operatore">
            <option value="TIM">TIM</option>
            <option value="Vodafone">Vodafone Italia</option>
            <option value="Wind">Wind Tre</option>
            <option value="Iliad">Iliad Italia</option>
        </select>
        <label for="Importo">Seleziona l'importo da utilizzare</label>
        <select name="Importo">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
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

    <h2>Saldo Finale</h2>
    <p><?php echo $saldo; ?></p>

</body>
</html>





CREATE TRIGGER aggiorna_saldo
AFTER INSERT ON tmovimenticontocorrente m
FOR EACH ROW
BEGIN
    IF ( SELECT TOP 1 * FROM tmovimenticontocorrente ORDER BY m.Data DESC )  >= $ricarica THEN
        INSERT INTO tmovimenticontocorrente(ContoCorrenteID, Data, Importo, Saldo, CategoriaMovimentoID, DescrizioneEstesa)
        VALUES (value1, value2, value3,...)
        WHERE ContoCorrenteID = $id_conto;
    ELSEIF NEW.tipo = 'guadagno' THEN
        UPDATE conti
        SET saldo = saldo + NEW.importo
        WHERE id_conto = NEW.id_conto;
    END IF;
END;

