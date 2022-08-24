<?php

include_once('../conexao/config.php');

$db = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao):
    case 'modalTabela':
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        $sql = "SELECT * from pci.vistoria where id = $id";
        foreach (@$db->query($sql) as $row) {
            echo'
                <div> 
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">UF</span>
                        <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="' . $row['uf'] .'">
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