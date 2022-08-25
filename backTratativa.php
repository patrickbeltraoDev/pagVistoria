<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
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
        min-width: 350px;
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


</style>


<?php
include_once('../conexao/config.php');

$db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao):
    case 'modalTabela':
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        $sql = "SELECT * from pci.vistoria where id = $id";
        foreach (@$db->query($sql) as $row) {
            echo '
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
                                <div class="dados">' . $row['id'] . '</div>
                            </div>
                        </div>  

                        <div class="info">
                            <div class="head">
                                <label>TR</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['tr'] . '</div>
                            </div>
                        </div>  

                        <div class="info">
                            <div class="head">
                                <label>NOME</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['nome'] . '</div>
                            </div>
                        </div>  

                        <div class="info">
                            <div class="head">
                                <label>UF</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['uf'] . '</div>
                            </div>
                        </div>  

                        <div class="info">
                            <div class="head">
                                <label>CIDADE</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['cidade'] . '</div>
                            </div>
                        </div>  
 
                        <div class="info">
                            <div class="head">
                                <label>ACESSO GPON REFERÊNCIA</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['acessoRef'] . '</div>
                            </div>
                        </div>  
                        <div class="info">
                            <div class="head">
                                <label>CDO REFERÊNCIA</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['cdoRef'] . '</div>
                            </div>
                        </div>  
  
                        <div class="info">
                            <div class="head">
                                <label>DATA DO CADASTRO</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['dataCadastro'] . '</div>
                            </div>
                        </div>  

                        <div class="info">
                            <div class="head">
                                <label>PROBLEMA A SER INVESTIGADO</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['problema'] . '</div>
                            </div>
                        </div>

                        <div class="info-lograd">
                            <div class="head">
                                <label>ENDEREÇO</label>
                            </div>
                            <div class="article">
                                <div class="dados">' . $row['endereco'] . '</div>
                            </div>
                        </div> 
                    </div>
                </div>
            
            ';
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
