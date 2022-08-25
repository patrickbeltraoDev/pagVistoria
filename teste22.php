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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap-toggle.min.css" rel="stylesheet">
        <script type="text/javascript" src="../js/bootstrap4-toggle.min.js"></script>
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/controle_ftth_oportunidade_tratados.js"></script>
        <link rel="stylesheet" href="./css/auditoria.css">
        <title>Oportunidades Tratadas</title>
    </head>
    <body>



        <button type="button" style="width: 65px; height: 35px;" id="btn-img"
            name="visualizar_imagens" 
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

        


        <!-- <script src="./css/js/bootstrap.bundle.min.js"></script>  -->
    </body>
</html>