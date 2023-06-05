<?php 

session_start();
if(!isset($_SESSION["logged_in"]))
{
    header("location: http://localhost/Projectworkits/login_definitivo.php");
    exit;
}

$dbhost = "localhost";
$username = "root";
$password = "";
$dbname = "projectworkits";
$conn = new mysqli($dbhost, $username, $password, $dbname);

$mail = $_SESSION["logged_in"];
$saldoQuery = "SELECT * FROM tmovimenticontocorrente 
                INNER JOIN tconticorrenti ON tmovimenticontocorrente.ContoCorrenteID = tconticorrenti.ContoCorrenteID 
                WHERE email = '$mail'";
$stmt1 = $conn->prepare($saldoQuery);
$stmt1->execute();
$result = $stmt1->get_result();
$tasks = array();
while( $rows = mysqli_fetch_assoc($result) ) {
    $tasks[] = $rows;
}


if(isset($_POST["ExportType"]))
{
    echo("è settato");
    switch($_POST["ExportType"])
    {
        case "export-to-excel" :
            // Submission from
            $filename = "phpflow_data_export_".date('Ymd') . ".xls";     
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            ExportFile($tasks);
            //$_POST["ExportType"] = '';
            exit();
        default :
            die("Unknown action : ".$_POST["action"]);
            break;
    }
}
function ExportFile($records) {
  $heading = false;
    if(!empty($records))
      foreach($records as $row) {
      if(!$heading) {
        // display field/column names as a first row
        echo implode("\t", array_keys($row)) . "\n";
        $heading = true;
      }
      echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <div class="col-sm-6 pull-left">
        <div class="well well-sm col-sm-12">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-info">Action</button>
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu" id="export-menu">
                    <li id="export-to-excel"><a href="#">Export to excel</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Other</a></li>
                </ul>
            </div>
        </div>
        <form action="" method="post" id="export-form">
            <input type="hidden" value="" id="hidden-type" name="ExportType" />
        </form>
        <table id="" class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <th>MovimentoID</th>
                    <th>ContoCorrenteID</th>
                    <th>Data</th>
                    <th>Importo</th>
                    <th>Saldo</th>
                    <th>CategoriaMovimentoID</th>
                    <th>DescrizioneEstesa</th>
                </tr>
            </tbody>
            <tbody>
                <?php foreach($tasks as $row):?>
                <tr>
                    <td><?php echo $row ['MovimentoID']?></td>
                    <td><?php echo $row ['ContoCorrenteID']?></td>
                    <td><?php echo $row ['Data']?></td>
                    <td><?php echo $row ['Importo']?></td>
                    <td><?php echo $row ['Saldo']?></td>
                    <td><?php echo $row ['CategoriaMovimentoID']?></td>
                    <td><?php echo $row ['DescrizioneEstesa']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
    jQuery('#export-to-excel').bind("click", function() {
    var target = $(this).attr('id');
    switch(target) {
    case 'export-to-excel' :
        $('#hidden-type').val(target);
        //alert($('#hidden-type').val());
        $('#export-form').submit();
        $('#hidden-type').val('');
        break
    }
    });
        });
</script>