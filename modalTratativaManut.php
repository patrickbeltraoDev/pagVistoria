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

        <script type="text/javascript">


            $('input[name="escolha"]').change(function () {
                if ($('input[name="escolha"]:checked').val() == "sim") {
                    $('#sim2').attr("checked", "sim");
                } else {
                    $('#sim2').attr("checked", "nao");
                }
            });
            
            $('input[name="escolha2"]').change(function () {
                if ($('input[name="escolha2"]:checked').val() == "sim") {
                    $('#opEncontrada').show();
                    $('#upload-img').show();
                } else {
                    $('#opEncontrada').hide();
                    $('#upload-img').hide();
                }
            });
            
        </script>
    </head>
    <body>

        <?php
        include_once('../conexao/config.php');

        $db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

        switch ($acao):
            case 'modalTabela':
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

                $sql = "SELECT * from pci.vistoria where id = $id";
                foreach (@$db->query($sql) as $row) {
                    // echo '?>
                        <div class="container">
                            <div class="header">
                                <h1>Dados do Cadastro</h1>
                            </div>

                            <div class="main">
                                <div class="info">
                                    <div class="head">
                                        <label>ID</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['id'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>TR</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['tr'] ?></div>
                                    </div>
                                </div>  

                                <div class="info">
                                    <div class="head">
                                        <label>NOME</label>
                                    </div>
                                    <div class="article">
                                        <div class="dados"><?php echo $row['nome'] ?></div>
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
                                        <label>DATA DO CADASTRO</label>
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

                                <div class="header">
                                    <h1>TRATATIVA DA VISTORIA - MANUTENÇÃO</h1>
                                </div>


                                                <!-- INÍCIO - FORMULÁRIO -->
                                <form method="POST" id="filtroModal">
                                    <div style="display: none;">
                                        <input type="text" name="tr" value="<?php echo $usr_matricula_oi?>">
                                        <input type="text" name="nome" value="<?php echo $usr_nome?>">
                                        <input type="text" name="idVistoria" value="<?php echo $id?>">
                                    </div>

                                    
                                    <div class="main center">
                                        <div class="info">
                                            <div class="head">
                                                <label>FOI LOCALIZADO FALHA ?</label>
                                            </div>
                                            <div class="article-form">
                                                <div>
                                                    <label for="sim1">SIM</label>
                                                    <input type="radio" name="escolha" id="sim1" value="sim" checked>
                                                </div>
                                                <div>
                                                    <label for="nao1">NÃO</label>
                                                    <input type="radio" name="escolha" id="nao1" value="nao">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info">
                                            <div class="head">
                                                <label>FOI LOCALIZADO OPORTUNIDADE ?</label>
                                            </div>
                                            <div class="article-form">
                                                <div>
                                                    <label for="sim2">SIM</label>
                                                    <input type="radio" name="escolha2" id="sim2" value="sim">
                                                </div>
                                                <div>
                                                    <label for="nao2">NÃO</label>
                                                    <input type="radio" name="escolha2" id="nao2" value="nao" checked>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info" id="opEncontrada" style="display:none;">
                                            <div class="head">
                                                <label>ESCOLHA A OPORTUNIDADE ENCONTRADA</label>
                                            </div>
                                            <div class="article">
                                                <select name="opEncontrada" class="select">
                                                    <option value="">ESCOLHA UMA OPÇÃO</option>
                                                    <?php 
                                                        $sql2 = "SELECT * from pci.vistoriaTratativa";
                                                        foreach (@$db->query($sql2) as $row2) {
                                                        ?>
                                                            <option value="<?php echo $row2['id'] ?>"><?php echo $row2['problema'] ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="info" id="upload-img" style="display:none;">
                                            <div class="head">
                                                <label>INSERIR IMAGENS DA OPORTUNIDADE</label>
                                            </div>
                                            <div class="imagens">
                                                <div class="upload">
                                                    <label class="" for="img1">INSIRA UMA FOTO - ANTES<img src="../imagem/camera.png" alt=""></label>
                                                    <input type="file" id="img1" name="img1">
                                                    
                                                </div>
                                                <div class="upload">
                                                    <label class="" for="img2">INSIRA UMA FOTO - DEPOIS<img src="../imagem/camera.png" alt=""></label>
                                                    <input type="file" id="img2" name="img2">
                                                    
                                                </div>
                                                <div class="upload">
                                                    <label class="" for="img3">INSIRA UMA FOTO - DEPOIS<img src="../imagem/camera.png" alt=""></label>
                                                    <input type="file" id="img3" name="img3">
                                                </div>
                                            </div>

                                        </div>

                                        <div align="center" style="padding: 10px" class="form-group col-md-12">
                                            <button align="center" id="btn" type="submit" style="width: 345px" class="btn btn-success btn-lg"
                                            value="Enviar">ENVIAR</button>
                                            <input type="hidden" name="acao" value="cadastrar">
                                        </div>
                                        <p id="resultado">  </p> 

                                    </div>
                                </form>
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


        <script type="text/javascript">
            
            $(document).ready(function() {
                $('#example').DataTable();
            });

            $(function() {

                $('#filtroModal').submit(function(event) {
                    event.preventDefault();
                    var formDados = new FormData($(this)[0]);
                    alert('AGUARDE !!! EM PROCESSAMENTO !!!');
                    $('#resultado').html(
                                '<div class="alert alert-danger col-md-12" role="alert"><h2>AGUARDE !!! EM PROCESSAMENTO !!!</h2></div>'
                                );
                    
                    $.ajax({
        
                        url: 'backManutVistoria.php', 
                        type: 'POST',
                        data: formDados,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                        //console.log(data);
                            $('#resultado').html(
                                ""
                                );
                            $('.recebe').html(data);
                            
                            $('#filtroModal').each(function() {
                                alert('DADOS INSERIDOS COM SUCESSO!!!');
                                this.reset();
                                window.setTimeout("location.href='tratativasVistoria.php';",
                                    2000);
                            });
                        },
                        dataType: 'html'
                    });
                    return false;
                });
            }); 
        </script>


        <!-- <script type="text/javascript" src="./js/controle_ftth.js"></script> -->
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/aud_controle_validacao.js"></script>
    </body>
</html>

