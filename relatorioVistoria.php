<?php

ini_set("display_errors", 0);
include_once("../topo.php");
include_once('../conexao/config.php');
include_once('../conexao/conectar.php');
include_once('../funcao/funcoes_jean.php');
include_once('../conexao/conectar.php');
// include_once('./redimensionaVistoria.php');
header('Content-Type: text/html; charset=utf-8');


$db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$permissoes = get_permissoes();
$nome = $permissoes['nome'];

$nome = $_SESSION['usr_nome'];
$usr_matricula_oi = $_SESSION['usr_matricula'];
$usr_matricula_tlm = $_SESSION['chapa_tlm'];
$usr_funcao = $_SESSION['usr_funcao'];


$sql1 = "SELECT s.cargo , s.nome from pci.funcionarios_sigo AS s
where s.chapa_brt ='$usr_matricula_oi'
group by s.cargo";

foreach (@$db->query($sql1) as $row) {
    $usr_nome = $row['nome'];
    $cargo = $row['cargo'];
}

// FILTROS


$data = date('d-m-Y');
//print_r($_POST);
if (!empty($_POST['data_fiscalizacao_i'])) {
    $inicio =  $_POST['data_fiscalizacao_i'];
    $fim =  $_POST['data_fiscalizacao_f'];
    $filtro_date = "AND dataCadastro between '$inicio' AND '$fim'";
}else{
    if (isset($data)) {
        $dia = date('d-m-Y');
        $dataHora = date('d-m-Y',  strtotime($dia));
        // sete dias anterior de atividades INST e REP
        $inicio = date('Y-m-d', strtotime('-2 day', strtotime($dia)));
        $fim = date('Y-m-d');
        $filtro_date = "AND dataCadastro between '$inicio' AND '$fim'";
    }
}

if (isset($_POST['uf'])) {
    $uf = implode("','", $_REQUEST['uf']);
    $filtro_uf = "AND uf IN('$uf')";
}

if (isset($_POST['cidade'])) {
    $cidade = implode("','", $_REQUEST['cidade']);
    $filtro_cidade = "AND cidade IN('$cidade')";
}

if (isset($_POST['cdoRef'])) {
    $cdoRef = implode("','", $_REQUEST['cdoRef']);
    $filtro_cdoRef = "AND cdoRef IN('$cdoRef')";
}
if (isset($_POST['acessoRef'])) {
    $acessoRef = implode("','", $_REQUEST['acessoRef']);
    $filtro_acessoRef = "AND  acessoRef IN('$acessoRef')";
}
if (isset($_POST['problema'])) {
    $problema = implode("','", $_REQUEST['problema']);
    $filtro_problema = "AND problema IN('$problema')";
}
if (isset($_POST['status'])) {
    $status = implode("','", $_REQUEST['status']);
    $filtro_status = "AND status IN('$status')";
}

                // --------- GRÁFICOS -------------

//  -----------QUANTIDADE A TRATAR MANUTENÇÃO -------------
$sql7 = "SELECT count(id) as qtdManutAtratar where equipeVistoria = 'MANUTENÇÃO' and status = 'a tratar'";
$qr7 = mysql_query($sql7);
while($res7 = mysql_fetch_assoc($qr7)) {
    $qtdManutAtratar = $res7['qtdManutAtratar'];
}

//  -----------QUANTIDADE TRATADOS MANUTENÇÃO -------------
$sql8 = "SELECT count(id) as qtdManutTratada where equipeVistoria = 'MANUTENÇÃO' and status = 'tratada'";
$qr8 = mysql_query($sql8);
while($res8 = mysql_fetch_assoc($qr8)) {
    $qtdManutTratada = $res8['qtdManutTratada'];
}

//  -----------QUANTIDADE PENDENTES MANUTENÇÃO -------------
$sql9 = "SELECT count(id) as qtdManutPendente where equipeVistoria = 'MANUTENÇÃO' and status = 'pendente'";
$qr9 = mysql_query($sql9);
while($res9 = mysql_fetch_assoc($qr9)) {
    $qtdManutPendente = $res9['qtdManutPendente'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
        <!-- <script type="text/javascript" src="../js/bootstrap4-toggle.min.js"></script> -->
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <link rel="stylesheet" href="./css/styleVistoriaManutencao.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <title>Relatório Vistoria de Rede</title>

        

    </head>
    <body>
                                        <!-- FINAL - FILTRO -->

        <div class="container-fluid">
            <div class="">
                <div class="container">
                    <div class="title">
                        <h1>Main Dashboard</h1>
                    </div>
                    <div class="exportar">
                        exportar
                    </div>
                </div>
            </div>

            <div class="main-relatorio container col-12">
                <div class="">
                    <div class="row ">
                        <div class="card text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql2 = "SELECT count(id) as qtdCadastros from pci.vistoria";
                                $qr2 = mysql_query($sql2);
                                while($res2 = mysql_fetch_assoc($qr2)) {
                                   $qtdCadastros = $res2['qtdCadastros'];
                                }
                            ?>
                            <div class="p-3 card-body">
                                <?php echo $qtdCadastros ?>
                            </div>
                            <div class="p-2 card-header ">
                                <p>Vistorias [Cadastradas]</p>
                            </div>
                        </div>

                        <div class="card text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql5 = "SELECT count(id) as qtdAtratar from pci.vistoria where status = 'a tratar'";
                                $qr5 = mysql_query($sql5);
                                while($res5 = mysql_fetch_assoc($qr5)) {
                                   $qtdAtratar = $res5['qtdAtratar'];
                                }
                            ?>
                            <div class="p-3 card-body">
                                <?php echo $qtdAtratar ?>
                            </div>
                            <div class="p-2 card-header ">
                                <p>Vistorias [A Tratar]</p>
                            </div>
                        </div>

                        <div class="card text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql6 = "SELECT count(id) as qtdPendente from pci.vistoria where status = 'pendente'";
                                $qr6 = mysql_query($sql6);
                                while($res6 = mysql_fetch_assoc($qr6)) {
                                   $qtdPendente   = $res6['qtdPendente'];
                                }
                            ?>
                            <div class="p-3 card-body">
                                <?php echo $qtdPendente ?>
                            </div>
                            <div class="p-2 card-header ">
                                <p>Vistorias [Pendentes]</p>
                            </div>
                        </div>

                        <div class="card text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql3 = "SELECT count(id) as qtdManut from pci.vistoria where equipeVistoria = 'MANUTENÇÃO'";
                                $qr3 = mysql_query($sql3);
                                while($res3 = mysql_fetch_assoc($qr3)) {
                                   $qtdManut = $res3['qtdManut'];
                                }
                            ?>
                            <div class="p-3 card-body">
                                <?php echo $qtdManut ?>
                            </div>
                            <div class="p-2 card-header ">
                                <p>Vistorias [Manutenção]</p>
                            </div>
                        </div>

                        <div class="card text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql4 = "SELECT count(id) as qtdHome from pci.vistoria where equipeVistoria = 'HOME CONNECT'";
                                $qr4 = mysql_query($sql4);
                                while($res4 = mysql_fetch_assoc($qr4)) {
                                   $qtdHome = $res4['qtdHome'];
                                }
                            ?>
                            <div class="p-3 card-body">
                                <?php echo $qtdHome ?>
                            </div>
                            <div class="p-2 card-header ">
                                <p>Vistorias [Home Connect]</p>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <div class="main-relatorio container col-12">
                    <div class="row">
                        <div class="card text-bg-primary m-3">
                            <canvas id="chartManut"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('chartManut').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Cadastro', 'A tratar', 'Tratadas', 'Pendentes'],
                    datasets: [{
                        label: 'RELATÓRIO EQUIPE MANUTENÇÃO',
                        data: [$qtdManut, $qtdManutAtratar, $qtdManutTratada, $qtdManutPendente],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                           
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <!-- <script>
            const ctx2 = document.getElementById('myChart2').getContext('2d');
            const myChart2 = new Chart(ctx2, {
               type: 'line',
               data: {
                    labels: ['< ?php echo $qtdManut ?>'],
                    datasets: [{
                        label: "Quantidade de cadastros Manut",
                        data: [0, < ?php echo $qtdManut?>],
                        borderWidth: 6, 
                        borderColor: 'rgba(77,166,253,0.85)',
                        backgroundColor: 'transparent',
                    }]
               } 
                
            });
            
            
        </script> -->


        
        <script src="./css/js/bootstrap.bundle.min.js"></script>
    </body>
</html>