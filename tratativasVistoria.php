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
                    <th class="" scope="col">TRATATIVA</th>
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
                        <td><strong><?php echo strtoupper($res['cdoRef'])?></strong></td>
                        <td><strong><?php echo strtoupper($res['problema'])?></strong></td>
                        <td><strong><?php echo strtoupper($res['dataCadastro'])?></strong></td>

                        <td>
                            <button type="button" id="<?php echo $res['id']?>" value="<?php echo $res['id']?>" class="btn  btn-primary" data-toggle="modal" data-target="#myModalvizualizar">
                                <a href="#" style="text-decorate: none; color: #ffffff;">Tratar</a> 
                            </button>
                        </td>
                    </tr>
                <?php
                }?>

            </tbody>
        </table>



        <button type="button" style="width: 65px; height: 35px;" id="btn-img"
            name="visualizar_imagens" onClick='botaoOK(<?php echo $res['id_oportunidade']?>)'
            class="btn btn-xs btn-primary" data-toggle="modal"
            data-target="#myModalvizualizar">Imagens
        </button>



        <div class="modal fade" id="myModalvizualizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog  aumentarModal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="imagens-modal"></div> 

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div> 



        <?php   
            desconectar($db);
        ?>




        <script>
            function botaoOK(id){  
                var validar_os = $('#validar_os').val();
            $.ajax({
                url : "./controle_ajax_oportunidade.php",
                type : 'post',
                dataType : 'html',
                data : {acao: 'modalTabela', id: id}, 
                beforeSend : function () {},

            success: function(dados) {
                $('#imagens-modal').html(dados);
                //$('.receber').html(dados);
                // console.log(dados);
                location.href= "./visualizar_evid_melhorias.php";
            }
            });
            chamaFoto(validar_os);
            }
            
        </script>



        <script src="./css/js/bootstrap.bundle.min.js"></script>    
    </body>
</html>