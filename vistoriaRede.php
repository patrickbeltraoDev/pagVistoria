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
        <link rel="stylesheet" href="./css/styleVistoria.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <title>Vistoria de Rede Ofensora</title>
    </head>
    <body>

        <div class="container">
            <div class="title">
                <h2 class="title-pag" >VISTORIA DE REDE OFENSORA DE ROMPIMENTO DE DROP E CABO</h2>
            </div>
            <div class="title">
                <h3 class="title-pag" >CADASTRO - [<span>RCO</span>]</h2>
            </div>

            <form action="backVistoria.php" method="post" class="">
                <div class="row">
                    <div class="col-sm-12 col-md-6 div-inp">
                                                            <!-- UF -->
                        <label for="sigla_unidade_federativa" class="bg-danger">UF</label>
                        <?php
                            $sql1 = "SELECT sigla_unidade_federativa from pci.tbl_servicos_associados_rede GROUP BY sigla_unidade_federativa";
                            $qr_1 = mysql_query($sql1) or die(error_msg(mysql_error(), $sql1));
                            while($result_uf = mysql_fetch_assoc($qr_1)){
                                $v_filtros['sigla_unidade_federativa'][] = $result_uf['sigla_unidade_federativa'];
                            }
                            foreach ($v_filtros['sigla_unidade_federativa'] as $key) {
                                $ar = $tag_filtros['sigla_unidade_federativa'] .= "<option value='$key' " . (in_array($key, $_REQUEST['sigla_unidade_federativa']) ? 'selected' : '') . ">$key</option>";
                            }
                        ?>
                        <select name='sigla_unidade_federativa[]'  id="sigla_unidade_federativa" title="UF" required>
                            <?php echo $tag_filtros['sigla_unidade_federativa']; ?>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-6  div-inp">
                                                        <!-- CIDADE -->
                        <label for="nome_localidade" class="bg-danger">CIDADE</label>
                        <?php
                            $sql2 = "SELECT nome_localidade from pci.tbl_servicos_associados_rede GROUP BY nome_localidade";
                            $qr_2 = mysql_query($sql2) or die(error_msg(mysql_error(), $sql2));
                            while ($result_municipio = mysql_fetch_assoc($qr_2) ){
                                $v_filtros['nome_localidade'][] = $result_municipio['nome_localidade'];
                            }
                            foreach ($v_filtros['nome_localidade'] as $key) {
                                $ar = $tag_filtros['nome_localidade'] .= "<option value='$key' " . (in_array($key, $_REQUEST['nome_localidade']) ? 'selected' : '') . ">$key</option>";
                            }
                        ?>

                        <select name='nome_localidade[]' id="nome_localidade" required title="CIDADE" >
                            <?php echo $tag_filtros['nome_localidade']; ?>
                        </select> 
                    </div>
                    
                </div>
                                                   
                <div class="row" style="margin-top: 20px">
                                                        <!-- ENDEREÇO -->
                    <div class="col-sm-12 col-md-6 div-inp">
                        <label for="endereco" class="bg-danger">ENDEREÇO</label>
                        <input type="text" class="form-control" id="endereco" name="endereco">
                    </div>
                                                        <!-- ACESSO GPON REFERÊNCIA -->
                    <div class="col-sm-12 col-md-6 div-inp">
                        <label for="acessoGP" class="bg-danger">INFORME ACESSO GPON DE REFERÊNCIA</label>
                        <input type="text" class="form-control" id="acessoGP" name="acessoGP">
                    </div>
                </div>
                
                <div class="row" style="margin-top: 20px">
                                                    <!-- CDO REFERÊNCIA -->
                    <div class="col-sm-12 col-md-6 div-inp">
                        <label for="cdo" class="bg-danger">INFORME CDO DE REFERÊNCIA</label>
                        <input type="text" class="form-control" id="cdo" name="cdo">
                    </div>
                                 
                    <div class="col-sm-12 col-md-6  div-inp">
                                                    <!-- PROBLEMA A SER INVESTIGADO -->
                        <label for="vistoriaProblema" class="bg-danger">PROBLEMA A SER INVESTIGADO</label>
                            <?php
                                $sql3 = "SELECT * from pci.vistoriaProb";
                                $qr_3 = mysql_query($sql3) or die(error_msg(mysql_error(), $sql3));
                                while ($result_prob = mysql_fetch_assoc($qr_3) ){
                                    $v_filtros['problema'][] = $result_prob['problema'];
                                }
                                foreach ($v_filtros['problema'] as $key) {
                                    $ar = $tag_filtros['problema'] .= "<option value='$key' " . (in_array($key, $_REQUEST['problema']) ? 'selected' : '') . ">$key</option>";
                                }
                            ?>

                        <select name='vistoriaProblema[]' id="vistoriaProblema" required title="VistoriaProblema" >
                            <?php echo $tag_filtros['problema']; ?>
                        </select> 
                    </div>
                </div>

                <div class="row" style="margin-top: 20px">
                                                    <!-- ESCOLHA DA ÁREA QUE VAI FAZER A TRATATIVA -->
                    <div class="col-sm-12 col-md-6 div-inp">
                        <label for="areaVistoria" class="bg-danger">ÁREA QUE VAI EXECUTAR A VISTORIA</label>
                        <select class="form-select form-select-lg mb-3" name="areaVistoria" aria-label=".form-select-lg example">
                            <option selected>Escolha a área</option>
                            <option value="1">MANUTENÇÃO</option>
                            <option value="2">HOME CONNECT</option>
                        </select>
                    </div>
                                
                </div>

            </form>

        </div>














        <script src="./css/js/bootstrap.bundle.min.js"></script>
    </body>
</html>