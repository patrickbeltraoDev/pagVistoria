<?php
    //author: Patrick,  Data inicial: 23/08/2022

    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 0);
    include_once('../conexao/config.php');
    include_once('../conexao/conectar.php');
    include_once('../funcao/dias.php');
    include_once('../funcao/converte_letras.php');
    include_once('../funcao/funcoes_jean.php'); 
    include_once('./redimensionaVistoria.php');
    
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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="./css/styleVistoriaManutencao.css">

    </head>
    <body>

        <?php
        include_once('../conexao/config.php');

        $db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

        switch ($acao):
            case 'modalTabela':
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

                $sql = "SELECT v.id as idCadastro, v.tr as trCadastro, v.nome as nomeCadastro, v.uf, v.cidade, v.endereco, v.acessoRef, v.cdoRef, v.problema, v.equipeVistoria, v.dataCadastro, v.status,
                        m.id as idTratativa, m.tr as trTratativa, m.nome as nomeTratativa, m.localizadaFalha, m.localizadaOportunidade, m.oportunidadeEncontrada, m.foto1, m.foto2, m.foto3, m.dataTratativa,
                        t.problema as opEncontrada
                        from pci.vistoria as v
                        LEFT JOIN pci.vistoriaManutencao as m on m.idVistoria = v.id
                        LEFT JOIN pci.vistoriaTratativa as t on t.id = m.oportunidadeEncontrada
                        where v.id = $id";

                
                foreach (@$db->query($sql) as $row) {
                    // echo '?>
                        <div class="container">
                            <div class="header">
                                <h1>DADOS DO CADASTRO</h1>
                            </div>

                            <div class="main">
                                <div class="info">
                                    <div class="head">
                                        <label>ID - CADASTRO</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['idCadastro'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>TR - CADASTRO</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['trCadastro'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>NOME - CADASTRO</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['nomeCadastro'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>UF</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['uf'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>CIDADE</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['cidade'] ?></div>
                                    </div>
                                </div>  
        
                                <div class="info">
                                    <div class="head">
                                        <label>ACESSO GPON REFERÊNCIA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['acessoRef'] ?></div>
                                    </div>
                                </div>  
                                <div class="info">
                                    <div class="head">
                                        <label>CDO REFERÊNCIA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['cdoRef'] ?></div>
                                    </div>
                                </div>  
        
                                <div class="info">
                                    <div class="head">
                                        <label>DATA - CADASTRO</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['dataCadastro'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>PROBLEMA A SER INVESTIGADO</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['problema'] ?></div>
                                    </div>
                                </div>

                                <div class="info-lograd">
                                    <div class="head">
                                        <label>ENDEREÇO</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['endereco'] ?></div>
                                    </div>
                                </div> 

                                <!-- DADOS DA TRATATIVA -->

                                <div class="header">
                                    <h1>DADOS DA TRATATIVA</h1>
                                </div>

                                <div class="info">
                                    <div class="head">
                                        <label>ID - TRATATIVA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['idTratativa'] ?></div>
                                    </div>
                                </div> 

                                <div class="info">
                                    <div class="head">
                                        <label>TR - TRATATIVA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['trTratativa'] ?></div>
                                    </div>
                                </div> 

                                <div class="info">
                                    <div class="head">
                                        <label>NOME - TRATATIVA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['nomeCadastro'] ?></div>
                                    </div>
                                </div> 

                                <div class="info">
                                    <div class="head">
                                        <label>FOI LOCALIZADO FALHA?</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['localizadaFalha'] ?></div>
                                    </div>
                                </div> 

                                <div class="info">
                                    <div class="head">
                                        <label>FOI LOCALIZADO OPORTUNIDADE?</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['localizadaOportunidade'] ?></div>
                                    </div>
                                </div> 

                                <div class="info">
                                    <div class="head">
                                        <label>OPORTUNIDADE ENCONTRADA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['opEncontrada'] ?></div>
                                    </div>
                                </div> 

                                <div class="info">
                                    <div class="head">
                                        <label>DATA - TRATATIVA</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['dataTratativa'] ?></div>
                                    </div>
                                </div>

                                <div class="img-modal">
                                
                                    <div class="info-img">
                                        <div class="head">
                                            <label>FOTO - ANTES</label>
                                        </div>
                                        <div class="cards-img">
                                            <a href="imagens/vistoriaRede/<?php echo $row['foto1']?>" target="_blank"><img src="imagens/vistoriaRede/<?php echo $row['foto1']?>" style="max-width: 350px; height: 100%;"></a>
                                        </div>
                                    </div>

                                    <div class="info-img">
                                        <div class="head">
                                            <label>FOTO - DEPOIS</label>
                                        </div>
                                        <div class="cards-img">
                                            <a href="imagens/vistoriaRede/<?php echo $row['foto2']?>" target="_blank"><img src="imagens/vistoriaRede/<?php echo $row['foto2']?>" style="max-width: 350px; height: 100%;"></a>
                                        </div>
                                    </div>

                                    <div class="info-img">
                                        <div class="head">
                                            <label>FOTO - DEPOIS</label>
                                        </div>
                                        <div class="cards-img">
                                            <a href="imagens/vistoriaRede/<?php echo $row['foto3']?>" target="_blank"><img src="imagens/vistoriaRede/<?php echo $row['foto3']?>" style="max-width: 350px; height: 100%;"></a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    
                    <!-- '; -->
                    <?php
                }
            break;
            case 'modalFotos':

                $validar_os = filter_input(INPUT_POST, 'validar_os', FILTER_SANITIZE_STRING);
            
                $array= array();
                    $sql="SELECT a.chapa_auditor as chapa, a.nome_auditor As nome,  a.nrba,  a.foto01, a.foto02, a.foto03 , a.foto04
                    FROM tbl_auditoria_ativ AS a 
                    where    a.id =$validar_os AND a.validacao !=4";
            
                foreach (@$db->query($sql) as $row) {
                $array[]=$row;
                }
            break;

            case 'salvarApr':
                $validar_os = filter_input(INPUT_POST, 'validar_os', FILTER_SANITIZE_STRING);
                $tr = filter_input(INPUT_POST, 'tr', FILTER_SANITIZE_STRING);
            
                $sql3 = "SELECT validacao FROM pci.tbl_auditoria_ativ  WHERE id = $validar_os";  
                foreach (@$db->query($sql3) as $row) {
                if($row['validacao'] == 3){$validacao = 5; } else {$validacao = 1;}
                }
            
            
                $array= array();
                $sql3 = "UPDATE pci.tbl_auditoria_ativ set validacao=$validacao, dt_justi=now(), auditor_just='$tr'  WHERE id = $validar_os; ";
                $resultq = mysql_query($sql3);
                if($sql3 == $sql3){
                }
                foreach (@$db->query($sql3) as $row) {
                    $array[]=$row;
                }
                echo json_encode($array);
            
            break;
            
            case 'salvarRec':
            
                $validar_os = filter_input(INPUT_POST, 'validar_os', FILTER_SANITIZE_STRING);
                $tr = filter_input(INPUT_POST, 'tr', FILTER_SANITIZE_STRING);
                $justItem = filter_input(INPUT_POST, 'justItem', FILTER_SANITIZE_STRING);
                $justificativa = filter_input(INPUT_POST, 'justificativa', FILTER_SANITIZE_STRING);
                
                $array= array();
                echo $sql4 = "UPDATE  pci.tbl_auditoria_ativ set validacao=2, just_itens_recusar='$justItem', just_recusar='$justificativa', dt_justi=now(), auditor_just='$tr' WHERE id =  $validar_os; ";
                $result = mysql_query($sql4);
                if($sql4 == $sql4){
                }
                
                foreach (@$db->query($sql4) as $row) {
                $array[]=$row;
                }
                echo json_encode($array);
            
            
            break;
            endswitch;
        ?>


        <!-- <script type="text/javascript" src="./js/controle_ftth.js"></script> -->
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/aud_controle_validacao.js"></script>
    </body>
</html>

