<?php
    //author: Patrick,  Data inicial: 23/08/2022

    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 0);
    include_once("../topo.php");
    include_once('../conexao/config.php');
    include_once('../conexao/conectar.php');
    include_once('../funcao/dias.php');
    include_once('../funcao/converte_letras.php');
    include_once('../funcao/funcoes_jean.php'); 
    include_once('../redimensiona.php');

    
    
    $db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    ////////// - DADOS DO LOGIN - \\\\\\\\\
    $permissoes = get_permissoes();
    //$nome = $permissoes['nome'];
    $usr_matricula = $_SESSION['chapa_tlm'];
    $data = date('d-m-Y');
    $nome = $_SESSION['usr_nome'];
    $usr_matricula_oi = $_SESSION['usr_matricula'];
    $usr_matricula_tlm = $_SESSION['chapa_tlm'];
    $usr_funcao = $_SESSION['usr_funcao'];

    $sql1 = "SELECT s.cargo , nome from pci.funcionarios_sigo AS s 
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
        <title>Vistoria de Rede Ofensora</title>
    </head>
    <body>
    <h1>Hello!</h1>














        <script src="./css/js/bootstrap.bundle.min.js"></script>
    </body>
</html>