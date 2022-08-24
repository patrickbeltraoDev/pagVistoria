<?php

ini_set("display_errors", 0);
include_once("../topo.php");
include_once('../conexao/config.php');
include_once('../conexao/conectar.php');
include_once('../funcao/funcoes_jean.php');
include_once('../conexao/conectar.php');
include_once('redimensiona.php');
header('Content-Type: text/html; charset=utf-8');


$db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$permissoes = get_permissoes();
$nome = $permissoes['nome'];

$nome = $_SESSION['usr_nome'];
$usr_matricula_oi = $_SESSION['usr_matricula'];
$usr_matricula_tlm = $_SESSION['chapa_tlm'];
$usr_funcao = $_SESSION['usr_funcao'];

// identificar qual perfil do lider , agrupando os tecnico de seu lider

// echo "<pre>";
// print_r ($_POST);
// echo "<\pre>";

$sql1 = "SELECT s.cargo , s.nome from pci.funcionarios_sigo AS s
where s.chapa_brt ='$usr_matricula_oi'
group by s.cargo";

foreach (@$db->query($sql1) as $row) {
    $usr_nome = $row['nome'];
    $cargo = $row['cargo'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/styleVistoriaManutencao.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <title>Visualizar Fila de Tratativas</title>
    </head>
    <body>


    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">UF</th>
                <th scope="col">CIDADE</th>
                <th scope="col">ENDEREÇO</th>
                <th scope="col">ACESSO REFERÊNCIA</th>
                <th scope="col">CDO REFERÊNCIA</th>
                <th scope="col">PROBLEMA VISTORIA</th>
                <th scope="col">DATA CADASTRO</th>
            </tr>
        </thead>
        <tbody>

            <?php
                $sql = "SELECT * FROM pci.vistoria";
                $qr = mysql_query($sql);
                while ($res = mysql_fetch_assoc($qr)){
            ?>
                <tr>
                    <td><strong><?php echo strtoupper($res['id'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['uf'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['cidade'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['endereco'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['acessoRef'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['problema'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['equipeVistoria'])?></strong></td>
                    <td><strong><?php echo strtoupper($res['dataCadastro'])?></strong></td>
                    
                </tr>
            <?php
            }?>

        </tbody>
        </table>



        <script src="./css/js/bootstrap.bundle.min.js"></script>    
    </body>
</html>