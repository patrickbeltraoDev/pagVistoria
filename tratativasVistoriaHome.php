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





?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap-toggle.min.css" rel="stylesheet">
        <script type="text/javascript" src="../js/bootstrap4-toggle.min.js"></script>
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <link rel="stylesheet" href="./css/styleVistoriaManutencao.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <title>Visualizar Fila de Tratativas</title>

        <script type="text/javascript">
            function botaoOKH(id){  
                var validar_os = $('#validar_os').val();
            $.ajax({
                url : "./modalTratativaHome.php",
                type : 'post',
                dataType : 'html',
                data : {acao: 'modalTabela', id: id}, 
                beforeSend : function () {

                },

            success: function(dados) {
                $('#imagens-modal').html(dados);
                console.log(dados);
                
            }
            });
            // chamaFoto(validar_os);
            }

        </script>
    </head>
    <body>
        <form method="post" id="filtro">
                <div class="row">
                    <div class="date">
                        <div class="div-date">
                            <label for="data_fiscalizacao_i">Data inicial:</label>
                            <input style="width: 115px; height:30px;" type="date" name="data_fiscalizacao_i" value="<? echo $inicio ?>"
                                id="data_fiscalizacao_i" onChange=" document.getElementById('filtro').submit();">
                        </div>
                        <div class="div-date">
                            <label for="data_fiscalizacao_f">Data final:</label>
                            <input style="width: 115px; height:30px;" type="date" name="data_fiscalizacao_f" value="<? echo $fim ?>"
                            id="data_fiscalizacao_f" onChange=" document.getElementById('filtro').submit();">
                        </div>
                    </div>
                    <div class="other-filter">
                            <!-- --------------------////////////////     FILTRO UF    /////////////////------------------------------------->
                        <?php
                        $sql_uf = "SELECT uf FROM pci.vistoria where (equipeVistoria = 'MANUTENÇÃO' AND status = 'a tratar') or (equipeVistoria = 'MANUTENÇÃO' AND status = 'pendente') group by uf order by uf ASC";
                        $query_uf = mysql_query($sql_uf) or die(error_msg(mysql_error(), $sql_uf));
                        while ($result_uf = mysql_fetch_assoc($query_uf)) {
                            $v_filtros['uf'][] = $result_uf['uf'];
                        }
                        foreach ($v_filtros['uf'] as $key) {
                            $ar = $tag_filtros['uf'] .= "<option value='$key' " . (in_array($key, $_REQUEST['uf']) ? 'selected' : '') . ">$key</option>";
                        }
                        ?>
                        <select name='uf[]' class="selectpicker" multiple title="UF" data-live-search="false"
                        data-selected-text-format="count" data-actions-box="true"
                        onChange="document.getElementById('filtro').submit();">
                        <?php echo $tag_filtros['uf']; ?>
                        </select>
        
                                        <!-- --------------------////////////////   CIDADE     /////////////////------------------------------------->
                        <?php

                            $sql_cidade = "SELECT cidade FROM pci.vistoria  where (equipeVistoria = 'MANUTENÇÃO' AND status = 'a tratar') or (equipeVistoria = 'MANUTENÇÃO' AND status = 'pendente')
                                                group by cidade order by cidade ASC";
                            $query_cidade = mysql_query($sql_cidade) or die(error_msg(mysql_error(), $sql_cidade));

                            while ($result_cidade = mysql_fetch_assoc($query_cidade)) {
                                $v_filtros['cidade'][] = $result_cidade['cidade'];
                            }

                            foreach ($v_filtros['cidade'] as $key) {
                                $tag_filtros['cidade'] .= "<option value='$key' " . (in_array($key, $_REQUEST['cidade']) ? 'selected' : '') . ">$key</option>";
                            }

                        ?>

                        <select name='cidade[]' class="selectpicker" multiple title="CIDADE" data-live-search="false"
                        data-selected-text-format="count" data-actions-box="true"
                        onChange=" document.getElementById('filtro').submit();">
                        <?php echo $tag_filtros['cidade'];?>

                        </select>
                                    <!-- --------------------////////////////   CDO REFERÊNCIA     /////////////////------------------------------------->  
                        <?php

                            $sql_celula = "SELECT cdoRef FROM pci.vistoria where (equipeVistoria = 'MANUTENÇÃO' AND status = 'a tratar') or (equipeVistoria = 'MANUTENÇÃO' AND status = 'pendente')
                                                group by cdoRef order by cdoRef ASC";
                            $query_celula = mysql_query($sql_celula) or die(error_msg(mysql_error(), $sql_celula));

                            while ($result_celula = mysql_fetch_assoc($query_celula)) {
                                $v_filtros['cdoRef'][] = $result_celula['cdoRef'];
                            }

                            foreach ($v_filtros['cdoRef'] as $key) {
                                $tag_filtros['cdoRef'] .= "<option value='$key' " . (in_array($key, $_REQUEST['cdoRef']) ? 'selected' : '') . ">$key</option>";
                            }
                        ?>

                        <select name='cdoRef[]' class="selectpicker" multiple title="CDO" data-live-search="false"
                        data-selected-text-format="count" data-actions-box="true"
                        onChange=" document.getElementById('filtro').submit();">
                        <?php echo $tag_filtros['cdoRef'];?>

                        </select>
                                    <!-- --------------------////////////////   ACESSO REFERÊNCIA    /////////////////------------------------------------->
                        <?php
                            $sql_acessoRef = "SELECT acessoRef FROM pci.vistoria where (equipeVistoria = 'MANUTENÇÃO' AND status = 'a tratar') or (equipeVistoria = 'MANUTENÇÃO' AND status = 'pendente') group by acessoRef order by acessoRef ASC";
                            $query_acessoRef = mysql_query($sql_acessoRef) or die(error_msg(mysql_error(), $sql_acessoRef));
                            while ($result_acessoRef = mysql_fetch_assoc($query_acessoRef)) {
                                $v_filtros['acessoRef'][] = $result_acessoRef['acessoRef'];
                            }
                            foreach ($v_filtros['acessoRef'] as $key) {
                                $tag_filtros['acessoRef'] .= "<option value='$key' " . (in_array($key, $_REQUEST['acessoRef']) ? 'selected' : '') . ">$key</option>";
                            }
                        ?>
                        <select name='acessoRef[]' class="selectpicker" multiple title="ACESSO GPON" data-live-search="false"
                        data-selected-text-format="count" data-actions-box="true"
                        onChange=" document.getElementById('filtro').submit();">
                        <?php echo $tag_filtros['acessoRef'];?>
                        </select>

                            <!-- --------------------////////////////   PROBLEMA VISTORIA    /////////////////------------------------------------->
                                    
                        <?php
                            $sql_problema = "SELECT problema from pci.vistoria where (equipeVistoria = 'MANUTENÇÃO' AND status = 'a tratar') or (equipeVistoria = 'MANUTENÇÃO' AND status = 'pendente') group by acessoRef order by acessoRef ASC";
                            $query_problema = mysql_query($sql_problema) or die(error_msg(mysql_error(), $sql_problema));
                            while ($result_problema = mysql_fetch_assoc($query_problema)) {
                                $v_filtros['problema'][] = $result_problema['problema'];
                            }
                            foreach ($v_filtros['problema'] as $key) {
                                $tag_filtros['problema'] .= "<option value='$key' " . (in_array($key, $_REQUEST['problema']) ? 'selected' : '') . ">$key</option>";
                            }
                        ?>
                        <select name='problema[]' class="selectpicker" multiple title="PROBLEMA IDENTIFICADO" data-live-search="false"
                        data-selected-text-format="count" data-actions-box="true"
                        onChange="document.getElementById('filtro').submit();">
                        <?php echo $tag_filtros['problema'];?>
                        </select>

                        <!-- --------------------////////////////   STATUS    /////////////////------------------------------------->
                                    
                        <?php
                            $sql_status = "SELECT status from pci.vistoria where (equipeVistoria = 'MANUTENÇÃO' AND status = 'a tratar') or (equipeVistoria = 'MANUTENÇÃO' AND status = 'pendente') group by status order by status ASC";
                            $query_status = mysql_query($sql_status) or die(error_msg(mysql_error(), $sql_status));
                            while ($result_status = mysql_fetch_assoc($query_status)) {
                                $v_filtros['status'][] = $result_status['status'];
                            }
                            foreach ($v_filtros['status'] as $key) {
                                $tag_filtros['status'] .= "<option value='$key' " . (in_array($key, $_REQUEST['status']) ? 'selected' : '') . ">$key</option>";
                            }
                        ?>
                        <select name='status[]' class="selectpicker" multiple title="STATUS" data-live-search="false"
                        data-selected-text-format="count" data-actions-box="true"
                        onChange="document.getElementById('filtro').submit();">
                        <?php echo $tag_filtros['status'];?>
                        </select>  
                    </div>
                </div>


                <!-- TABELA   -->
                <table class="table table-bordered border-secondary table-striped">
                    <thead>
                        <tr class="">
                            <th class="" scope="col">ID</th>
                            <th class="" scope="col">UF</th>
                            <th class="" scope="col">CIDADE</th>
                            <th class="" scope="col">ENDEREÇO</th>
                            <th class="" scope="col">ACESSO REFERÊNCIA</th>
                            <th class="" scope="col">CDO REFERÊNCIA</th>
                            <th class="" scope="col">PROBLEMA VISTORIA</th>
                            <th class="" scope="col">DATA CADASTRO</th>
                            <th class="" scope="col">STATUS</th>
                            <th class="" scope="col">TRATATIVA</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $sql = "SELECT * FROM pci.vistoria where status <> '' $filtro_uf $filtro_cidade $filtro_cdoRef $filtro_acessoRef $filtro_problema $filtro_status $filtro_date
                            AND (equipeVistoria = 'HOME CONNECT' AND status = 'a tratar') or (equipeVistoria = 'HOME CONNECT' AND status = 'pendente')";
                            $qr = mysql_query($sql);
                            while ($res = mysql_fetch_assoc($qr)){
                        ?>
                            <tr>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['id'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['uf'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['cidade'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['endereco'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['acessoRef'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['cdoRef'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['problema'])?></strong></td>
                                <td class="align-v" style="display: table-cell; vertical-align: middle;"><strong><?php echo strtoupper($res['dataCadastro'])?></strong></td>
                                
                                <?php 
                                    switch ($res['status']) {
                                        case 'a tratar':  
                                            echo '<td class="bg-a-tratar " style="display: table-cell; vertical-align: middle;"><strong>A TRATAR</strong></td>';
                                        break;
                                        case 'pendente':    
                                            echo '<td class="bg-pendente" style="display: table-cell; vertical-align: middle;"><strong>PENDENTE</strong></td>';
                                        break;                             
                                    }                            
                                ?>
                                <td>
                                    <button type="button" style="width: 100%; height: 40px;" id="btn-img"
                                        name="visualizar_imagens" value="<?php echo $res['id']?>"
                                        class="btn btn-xs btn-primary" data-toggle="modal"
                                        data-target="#myModalvizualizar" onClick='botaoOKH(<?php echo $res['id']?>)'>
                                        Visualizar
                                    </button>
                                </td>
                                
                            </tr>
                        <?php
                        }?>

                    </tbody>
                </table>

                <div class="modal fade" id="myModalvizualizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog aumentarModal" role="document"  style="width: 90vw;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="imagens-modal">
        
                            </div> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div> 
        



        <!-- < ?php   
            desconectar($db);
        ?> -->




        



        <!-- <script src="./css/js/bootstrap.bundle.min.js"></script>     -->
    </body>
</html>