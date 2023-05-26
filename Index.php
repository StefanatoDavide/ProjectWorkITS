<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>   
    <title>Login</title>
</head>
<body>
    <header>Ricerca   |   Account   |   Funzionalità</header>
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
        <table class="table">
            <thead>
                <tr>
                    <th>Destinatario Transazione</th>
                    <th>Data</th>
                    <th>Importo</th>
                    <th> </th>
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
    <footer class="navbar navbar-fixed-bottom">Contatti   |   Chi siamo</footer>
</body>
</html>