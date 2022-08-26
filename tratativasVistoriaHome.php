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
                    $sql = "SELECT * FROM pci.vistoria where (equipeVistoria = 'HOME CONNECT' AND status = 'a tratar') or (equipeVistoria = 'HOME CONNECT' AND status = 'pendente');";
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
                            <button type="submit" id="btn-img"
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