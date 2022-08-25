<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="./js/backTratativa.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

        <script type="text/javascript">
            // function changestatus(){
            //     var status = document.getElementsByName("escolha2");

            //     if (status.value == "sim"){
            //         document.getElementById("opEncontrada").style.display = "block";
            //     }
            //     else if(status.value == "nao"){
            //         document.getElementById("opEncontrada").style.display = "none";
            //     }
            // }

            
            $('input[name="escolha2"]').change(function () {
                if ($('input[name="escolha2"]:checked').val() == "sim") {
                    $('#opEncontrada').show();
                } else {
                    $('#opEncontrada').hide();
                }
            });
            
        </script>

        <style>

        .container{
            width: 100%;
            display: flex;
            flex-direction: column;
            font-family: 'Oswald', sans-serif;
            letter-spacing: 1.1px;
            padding: 0;
            margin: 0;
        }

        .header{
            background-color: #571925;
            width: 100%;
            margin: auto;
            color: #fff;

        }

        .header h1{
            font-size: 2em;
            text-align: center;
        }

        .main{
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
        }

        .info{
            padding: 10px;
            display: flex;
            flex-direction: column;
            margin: 5px;
            min-width: 350px;
        }

        .info-lograd{
            padding: 10px;
            display: flex;
            flex-direction: column;
            margin: 5px;
            width: 100%;
            min-width: 300px;
        }

        .head{
            text-align: center;
            font-size: 1.4em;
            background-color: #dc3545;
            color: #fff;
            /* padding: 5px; */
        }

        .article{
            /* width: auto; */
            padding: 5px;
        }

        .dados{
            text-align: center;
            font-size: 1.4em;
            padding: 5px;
            font-weight: 700;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #444;
        }

        /* formulario */

        .article-form{
            padding: 5px;
            display: flex;
            justify-content: space-around;
            border-bottom: 1px solid #444;
        }

        .article-form label{
            font-weight: 700;
            font-size: 1.4em;
        }

        .select{
            text-align: center;
            font-size: 1.4em;
            padding: 5px;
            font-weight: 700;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #444;
        }

        </style>
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
                                        <div class="dados"><?php echo $row['id'] ?></div>
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
                                    <h1>Tratativa da Vistoria</h1>
                                </div>

                                <form action="#" method="post">
                                    <div class="main">
                                        <div class="info">
                                            <div class="head">
                                                <label>FOI LOCALIZADO FALHA ?</label>
                                            </div>
                                            <div class="article-form">
                                                <div>
                                                    <label for="sim1">SIM</label>
                                                    <input type="radio" name="escolha" id="sim1" value="sim">
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
                                            <div class="article-form">
                                                <select name='probEncontrado' id='probEncontrado' class='select'>
                                                    <?php 
                                                        $sql2 = "SELECT * FROM pci.vistoriaTratativa";
                                                        $qr2 = mysql_query($sql2) or die(error_msg(mysql_error(), $sql2));
                                                        while ($res2 = mysql_fetch_assoc($qr2) ){
                                                            echo '<option value="'.$res2['id'].'">'.$res2['problema'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

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

        
    </body>
</html>

