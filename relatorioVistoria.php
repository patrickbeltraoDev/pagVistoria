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
$sql7 = "SELECT count(id) as qtdManutAtratar from pci.vistoria where equipeVistoria = 'MANUTENÇÃO' and status = 'a tratar'";
$qr7 = mysql_query($sql7);
while($res7 = mysql_fetch_assoc($qr7)) {
    $qtdManutAtratar = $res7['qtdManutAtratar'];
}

//  -----------QUANTIDADE TRATADOS MANUTENÇÃO -------------
$sql8 = "SELECT count(id) as qtdManutTratada from pci.vistoria where equipeVistoria = 'MANUTENÇÃO' and status = 'tratada'";
$qr8 = mysql_query($sql8);
while($res8 = mysql_fetch_assoc($qr8)) {
    $qtdManutTratada = $res8['qtdManutTratada'];
}

//  -----------QUANTIDADE PENDENTES MANUTENÇÃO -------------
$sql9 = "SELECT count(id) as qtdManutPendente from pci.vistoria where equipeVistoria = 'MANUTENÇÃO' and status = 'pendente'";
$qr9 = mysql_query($sql9);
while($res9 = mysql_fetch_assoc($qr9)) {
    $qtdManutPendente = $res9['qtdManutPendente'];
}

//  -----------QUANTIDADE A TRATAR HOME CONNECT -------------
$sql10 = "SELECT count(id) as qtdHomeTratar from pci.vistoria where equipeVistoria = 'HOME CONNECT' and status = 'a tratar'";
$qr10 = mysql_query($sql10);
while($res10 = mysql_fetch_assoc($qr10)) {
    $qtdHomeTratar = $res10['qtdHomeTratar'];
}

//  -----------QUANTIDADE TRATADOS HOME CONNECT -------------
$sql11 = "SELECT count(id) as qtdHomeTratadas from pci.vistoria where equipeVistoria = 'HOME CONNECT' and status = 'tratada'";
$qr11 = mysql_query($sql11);
while($res11 = mysql_fetch_assoc($qr11)) {
    $qtdHomeTratadas = $res11['qtdHomeTratadas'];
}

//  -----------QUANTIDADE PENDENTES HOME CONNECT-------------
$sql12 = "SELECT count(id) as qtdHomePendentes from pci.vistoria where equipeVistoria = 'HOME CONNECT' and status = 'pendente'";
$qr12 = mysql_query($sql12);
while($res12 = mysql_fetch_assoc($qr12)) {
    $qtdHomePendentes = $res12['qtdHomePendentes'];
}



                        
//  -----------QUANTIDADE PARA OS GRÁFICOS -------------
$sql3 = "SELECT count(id) as qtdManut from pci.vistoria where equipeVistoria = 'MANUTENÇÃO'";
$qr3 = mysql_query($sql3);
while($res3 = mysql_fetch_assoc($qr3)) {
   $qtdManut = $res3['qtdManut'];
}
 
$sql4 = "SELECT count(id) as qtdHome from pci.vistoria where equipeVistoria = 'HOME CONNECT'";
$qr4 = mysql_query($sql4);
while($res4 = mysql_fetch_assoc($qr4)) {
   $qtdHome = $res4['qtdHome'];
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
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script> -->
        <title>Relatório Vistoria de Rede</title>

        

    </head>
    <body onresize="responsiveFonts()">
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
                        <div class="cards cadastro text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql2 = "SELECT count(id) as qtdCadastros from pci.vistoria";
                                $qr2 = mysql_query($sql2);
                                while($res2 = mysql_fetch_assoc($qr2)) {
                                   $qtdCadastros = $res2['qtdCadastros'];
                                }
                            ?>
                            
                            <div class="icon">
                                <img src="../imagem/registro.png">
                            </div>
                            <div class="card-body">
                                <?php echo $qtdCadastros ?>
                            </div>
                            <div class="subtitle">
                                <p>Total - Cadastros</p>
                            </div>
                        </div>

                        <div class="cards aTratar text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql5 = "SELECT count(id) as qtdAtratar from pci.vistoria where status = 'a tratar'";
                                $qr5 = mysql_query($sql5);
                                while($res5 = mysql_fetch_assoc($qr5)) {
                                   $qtdAtratar = $res5['qtdAtratar'];
                                }
                            ?>
                            <div class="icon">
                                <img src="../imagem/alvo.png">
                            </div>
                            <div class="card-body">
                                <?php echo $qtdAtratar ?>
                            </div>
                            <div class="subtitle">
                                <p>Total - A Tratar</p>
                            </div>
                        </div>

                        <div class="cards tratados text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sqlTratada = "SELECT count(id) as qtdTratados from pci.vistoria where status = 'tratada'";
                                $qrTratada = mysql_query($sqlTratada);
                                while($resTratada = mysql_fetch_assoc($qrTratada)) {
                                   $qtdTratados = $resTratada['qtdTratados'];
                                }
                            ?>
                            <div class="icon">
                                <img src="../imagem/servico.png">
                            </div>
                            <div class="card-body">
                                <?php echo $qtdTratados ?>
                            </div>
                            <div class="subtitle">
                                <p>Total - Tratados</p>
                            </div>
                        </div>

                        <div class="cards pendentes text-bg-primary m-3" style="max-width: 18rem;">
                            <?php 
                                $sql6 = "SELECT count(id) as qtdPendente from pci.vistoria where status = 'pendente'";
                                $qr6 = mysql_query($sql6);
                                while($res6 = mysql_fetch_assoc($qr6)) {
                                   $qtdPendente   = $res6['qtdPendente'];
                                }
                            ?>
                            <div class="icon">
                                <img src="../imagem/teste.png">
                            </div>
                            <div class="card-body">
                                <?php echo $qtdPendente ?>
                            </div>
                            <div class="subtitle">
                                <p>Total - Pendentes</p>
                            </div>
                        </div>
                
                    </div>
                </div>
                <div class="main-relatorio container col-12">
                    <div class="row">
                        <div class="card text-bg-primary m-3 col-5">
                            <div class="title-card">Relatório Equipe Manutenção</div>
                            <canvas id="chartManut" ></canvas>
                        </div>
                        <div class="card text-bg-primary m-3 col-5">
                            <div class="title-card">Relatório Equipe Home Connect</div>
                            <canvas id="chartHome" ></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card text-bg-primary m-3 col-5">
                            <div class="title-card">Problemas Ofensores</div>
                            <canvas id="chartOfensores"></canvas>
                        </div>
                        <div class="card text-bg-primary m-3 col-5">
                            <div class="title-card">Oportunidades Encontradas</div>
                            <canvas id="chartOportunidade"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                                     <!-- GRÁFICO -- 'RELATÓRIO EQUIPE MANUTENÇÃO' -->
        <script>
            const ctx = document.getElementById('chartManut').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Cadastro', 'A tratar', 'Tratadas', 'Pendentes'],
                    datasets: [{
                        // label: 'RELATÓRIO EQUIPE MANUTENÇÃO',
                        data: [<?php echo $qtdManut?>,<?php echo $qtdManutAtratar?>, <?php echo $qtdManutTratada?>, <?php echo $qtdManutPendente?>],
                        backgroundColor: [
                            'rgba(54, 162, 235)',
                            'rgba(255, 99, 132)',
                            'rgba(75, 192, 192)',
                            'rgba(255, 206, 86)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1,
                        datalabels: {
                            align: 'start',
                            anchor: 'end',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: 18
                            }
                        }
                    }]
                },
                options: {
                    scales: {
                        x: {
                            grid: {
                            display: false
                            }
                        },
                        y: {
                            display: false,
                            grid: {display: false}
                        }
                    },
                    plugins: {
                        //remove a legenda da parte superior do gráfico
                        legend: {
                            display: false      
                        },
                    }, 
                    layout: {
                        padding: 20
                    }
                },
                plugins: [ChartDataLabels],
                
            });
        </script>

                            <!-- GRÁFICO -- 'RELATÓRIO EQUIPE HOME CONNECT' -->
        <script>
            const ctx2 = document.getElementById('chartHome').getContext('2d');
            const myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Cadastro', 'A tratar', 'Tratadas', 'Pendentes'],
                    datasets: [{
                        
                        data: [<?php echo $qtdHome?>,<?php echo $qtdHomeTratar?>, <?php echo $qtdHomeTratadas?>, <?php echo $qtdHomePendentes?>],
                        backgroundColor: [
                            'rgba(54, 163, 235)',
                            'rgba(255, 99, 132)',
                            'rgba(75, 192, 192)',
                            'rgba(255, 206, 86)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235)',
                            'rgba(255, 99, 132)',
                            'rgba(75, 192, 192)',
                            'rgba(255, 206, 86)'
                        ],
                        borderWidth: 1,
                        datalabels: {
                            align: 'start',
                            anchor: 'end',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: 18
                            }
                        }
                    }]
                },
                options: {
                    scales: {
                        x: {
                            grid: {
                            display: false
                            }
                        },
                        y: {
                            display: false,
                            grid: {display: false}
                        }
                    },
                    plugins: {
                        legend: {
                            display: false      
                        },
                    },
                    layout: {
                        padding: 20
                    }
                },
                plugins: [ChartDataLabels],
            });
            
        </script>



        <!-- GRÁFICO -- 'RELATÓRIO + OFENSORES VISTORIA' -->
        <script>

            <?php 
                $label = [];
                $qtd = [];
                $sql13 = "SELECT count(problema) as qtdProblema, problema from pci.vistoria group by problema order by qtdProblema DESC";
                $qr13 = mysql_query($sql13);
                while($res13 = mysql_fetch_assoc($qr13)) {
                    $qtdProblema = $res13['qtdProblema'];
                    $problemas = $res13['problema'];

                    $sep = substr($problemas, 0, strlen($problemas)/2);
                    $sep2 = substr($problemas, strlen($problemas)/2);

                    $label[] = "['{$sep}','{$sep2}']";

                    // CONSULTA DO TOTAL PARA A PORCENTAGEM
                    $sqlP2 = "SELECT count(problema) as total from pci.vistoria";
                    $qrP2 = mysql_query($sqlP2);
                    while($resP2 = mysql_fetch_assoc($qrP2)) {
                        $total2 = $resP2['total'];
                    }

                    $porc2 = (($qtdProblema * 100)/$total2); 

                    $qtd[] = $porc2;
                }

                $labels = implode(",", $label);    
                $qtds = implode(",", $qtd);
            ?>
            
            
            // setup 
            const data = {
                    labels: [
                        <?php echo $labels?>
                    ],
                    datasets: [{
                        // label: 'Weekly Sales',
                        data: [<?php echo $qtds?>],
                        backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(0, 0, 0, 0.2)'
                        ],
                        borderColor: [
                        'rgba(54, 162, 235)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(0, 0, 0, 1)'
                        ],
                        borderWidth: 1,
                        barPercentage: 0.75,
                        categoryPercentage: 1,
                        datalabels: {
                            align: 'start',
                            anchor: 'end',
                            color: 'black',
                            font: {
                                weight: 'bold'
                            }
                        },
                    }]
                    
            };
            
                const config = {
                    type: 'bar',
                    data,
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                display: false,
                                grid: {display: false}
                            },
                            y: {
                                beginAtZero: true,
                                grid: {display: false}
                            }
                        },
                        plugins: {
                            legend: {
                                display: false      
                            },
                            datalabels:{
                                formatter: (value, context) => {
                                    const valor = context.chart.data.datasets[0].data;
                                    const percentageValue = [`${value}%`];
                                    return percentageValue;
                                }
                            }
                        },
                        layout: {
                            padding: 20
                        },
                        
                    },
                    plugins: [ChartDataLabels],
                };

                // Chart.defaults.font.size = 8;  ---> faz com que todas as fontes dos gráficos fique desse tamanho.
                
                // render init block
                const chartOfensores = new Chart(
                document.getElementById('chartOfensores'),
                config
                );

        </script>


            <!-- GRÁFICO -- 'RELATÓRIO + OFENSORES VISTORIA' -->
        
        <script>
            <?php 
                $labelOp = [];
                $qtdOp = [];
                $sql14 = "SELECT count(m.oportunidadeEncontrada) as qtdOportunidade, m.oportunidadeEncontrada, t.problema
                            from pci.vistoriaManutencao as m
                            left join pci.vistoriaTratativa as t on t.id = m.oportunidadeEncontrada
                            group by oportunidadeEncontrada order by qtdOportunidade DESC";
                $qr14 = mysql_query($sql14);
                while($res14 = mysql_fetch_assoc($qr14)) {
                    $qtdOpEncontrada = $res14['qtdOportunidade'];
                    $OpEncontradas = $res14['problema'];

                    $sepOp1 = substr($OpEncontradas, 0, strlen($OpEncontradas)/2);
                    $sepOp2 = substr($OpEncontradas, strlen($OpEncontradas)/2);

                    $labelOp[] = "['{$sepOp1}','{$sepOp2}']";

                        // CONSULTA DO TOTAL PARA A PORCENTAGEM
                    $sqlP1 = "SELECT count(oportunidadeEncontrada) as total from pci.vistoriaManutencao";
                    $qrP1 = mysql_query($sqlP1);
                    while($resP1 = mysql_fetch_assoc($qrP1)) {
                        $total = $resP1['total'];
                    }

                    $porc1 = (($qtdOpEncontrada * 100)/$total); 

                    $qtdOp[] = $porc1;

                }

                

                $labels_Op = implode(",", $labelOp);    
                $qtds_Op = implode(",", $qtdOp);
            ?>

            // setup 
            const dataOp = {
                    labels: [
                        <?php echo $labels_Op?>
                    ],
                    datasets: [{
                        // label: 'Weekly Sales',
                        data: [<?php echo  $qtds_Op?>],
                        backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(0, 0, 0, 0.2)'
                        ],
                        borderColor: [
                        'rgba(54, 162, 235)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(0, 0, 0, 1)'
                        ],
                        borderWidth: 1,
                        barPercentage: 0.75,
                        categoryPercentage: 1,
                        datalabels: {
                            align: 'start',
                            anchor: 'end',
                            color: 'black',
                            font: {
                                weight: 'bold'
                            }
                        },
                    }]
                    
            };
            
                const config2 = {
                    type: 'bar',
                    data: dataOp,
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                display: false,
                                grid: {display: false}
                            },
                            y: {
                                beginAtZero: true,
                                grid: {display: false}
                            }
                        },
                        plugins: {
                            legend: {
                                display: false      
                            },
                            datalabels:{
                                formatter: (value, context) => {
                                    const valor = context.chart.data.datasets[0].data;
                                    const percentageValue = [`${value}%`];
                                    return percentageValue;
                                }
                            }
                        },
                        layout: {
                            padding: 20
                        },
                        
                    },
                    plugins: [ChartDataLabels],
                };

                // Chart.defaults.font.size = 8;  ---> faz com que todas as fontes dos gráficos fique desse tamanho.
                
                // render init block
                const chartOportunidade = new Chart(
                document.getElementById('chartOportunidade'),
                config2
                );



        </script>

        <script>
            function responsiveFonts(){
                if(window.outerWidth > 1400){
                    Chart.defaults.font.size = 16;
                    Chart.defaults.font.weight = 'bold';
                };
                if(window.outerWidth < 1400 && window.outerWidth > 333){
                    Chart.defaults.font.size = 12;
                    Chart.defaults.font.weight = 'bold';
                };
                if(window.outerWidth < 333){
                    Chart.defaults.font.size = 8;
                    Chart.defaults.font.weight = 'bold';
                };

                chartOfensores.update();
                myChart2.update();
                myChart.update();
            }
        </script>


        
        <script src="./css/js/bootstrap.bundle.min.js"></script>
    </body>
</html>