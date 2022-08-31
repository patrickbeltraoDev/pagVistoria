<!-- AUTOR: PATRICK BELTRÃO -->
<?php
    include_once '../conexao/conectar.php';
    include_once('../conexao/config.php');
    date_default_timezone_set('America/Sao_Paulo');

    // echo "<pre>";
    //     print_r($_GET);
    // echo"</pre>";

    $datai = $_GET['data_i'];
    $dataf = $_GET['data_f'];
    $uf = $_GET['uf'];
    $cidade = $_GET['cidade'];
    $cdo = $_GET['cdo'];
    $acesso = $_GET['acesso'];
    $status = $_GET['status'];
    
     
/////////////////////////////////     VERIFICAÇÃO DOS FILTROS     \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    $data = date('d-m-Y');
if (!empty($_GET['data_i'])) {
    $inicio =  $_GET['data_i'];
    $fim =  $_GET['data_f'];
    $filtro_date = "AND v.dataCadastro between '$inicio' AND '$fim'";
}else{
    if (isset($data)) {
        $dia = date('d-m-Y');
        $dataHora = date('d-m-Y',  strtotime($dia));
        // sete dias anterior de atividades INST e REP
        $inicio = date('Y-m-d', strtotime('-2 day', strtotime($dia)));
        $fim = date('Y-m-d');
        $filtro_date = "AND v.dataCadastro between '$inicio' AND '$fim'";
    }
}


if (!empty($_GET['uf'])) {
    $ufs = explode(',', $_GET['uf']);
    $ufs = implode(',', $ufs);
    $filtro_uf = "AND v.uf IN('$uf')";
}

if (!empty($_GET['cidade'])) {
    $cid = explode(',', $_GET['cidade']);
    $cid = implode(',', $cid);
    $filtro_cidade = "AND v.cidade IN('$cid')";
}

if (!empty($_GET['cdo'])) {
    $cdo = explode(',', $_GET['cdo']);
    $cdo = implode(',', $cdo);
    $filtro_cdo = "AND v.cdoRef IN('$cdo')";
}

if (!empty($_GET['status'])) {
    $status = explode(',', $_GET['status']);
    $status = implode(',', $status);
    $filtro_status = "AND v.status IN('$status')";
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Baixar Relatório</title>
    </head>
    <body>

        <?php
        $tbl = "
        <table border ='1'>
            <thead>
                <tr style='background-color: #dc3545; font-size: 20px;'>    
                    <th colspan = '12'><b>DADOS DO CADASTRO</b></th>
                    <th colspan = '7'><b>DADOS DA VISTORIA</b></th>
                </tr>

                <tr style='font-size: 15px;'> 
                    <th><b>ID-CADASTRO</b></th>
                    <th><b>TR-CADASTRO</b></th>
                    <th><b>NOME-CADASTRO</b></th>
                    <th><b>UF</b></th>
                    <th><b>CIDADE</b></th>
                    <th><b>ENDEREÇO</b></th>
                    <th><b>ACESSO GPON</b></th>
                    <th><b>NÚMERO-CDO</b></th>
                    <th><b>PROBLEMA-VISTORIA</b></th>
                    <th><b>EQUIPE-A-TRATAR</b></th>
                    <th><b>DATA-CADASTRO</b></th>
                    <th><b>STATUS</b></th>
                    <th><b>ID-TRATATIVA</b></th>
                    <th><b>TR-TRATATIVA</b></th>
                    <th><b>NOME-TRATATIVA</b></th>
                    <th><b>LOCALIZADO FALHA?</b></th>
                    <th><b>LOCALIZADO OPORTUNIDADE?</b></th>
                    <th><b>OP. ENCONTRADA</b></th>
                    <th><b>DATA-TRATATIVA</b></th>
                </tr>
            </thead> 
            
            <tbody>";
            
                // $filtro_uf $filtro_setor $filtro_cidade $filtro_celula $filtro_criticidade
                

                $sql = "SELECT v.id as idCadastro, v.tr as trCadastro, v.nome as nomeCadastro, v.uf, v.cidade, v.endereco, v.acessoRef, v.cdoRef, v.problema, v.equipeVistoria, v.dataCadastro, v.status,
                        m.id as idTratativa, m.tr as trTratativa, m.nome as nomeTratativa, m.localizadaFalha, m.localizadaOportunidade, m.oportunidadeEncontrada, m.dataTratativa,
                        t.problema as opEncontrada
                        from pci.vistoria as v
                        LEFT JOIN pci.vistoriaManutencao as m on m.idVistoria = v.id
                        LEFT JOIN pci.vistoriaTratativa as t on t.id = m.oportunidadeEncontrada
                        WHERE v.tr <> '' $filtro_date $filtro_uf  $filtro_cidade $filtro_cdo $filtro_status order by idCadastro
                ";
                $query = mysql_query($sql);
                while ($res = mysql_fetch_assoc($query)) {
                    $idCadastro = $res['idCadastro'];
                    $trCadastro = $res['trCadastro'];
                    $nomeCadastro = $res['nomeCadastro'];
                    $uf = $res['uf'];
                    $cidade = $res['cidade'];
                    $endereco = $res['endereco'];
                    $acessoRef = $res['acessoRef'];
                    $cdoRef = $res['cdoRef'];
                    $problema = $res['problema'];
                    $equipeVistoria = $res['equipeVistoria'];
                    $dataCadastro = $res['dataCadastro'];
                    $status = $res['status'];
                    $idTratativa = $res['idTratativa'];
                    $trTratativa = $res['trTratativa'];
                    $nomeTratativa = $res['nomeTratativa'];
                    $localizadaFalha = $res['localizadaFalha'];
                    $localizadaOportunidade = $res['localizadaOportunidade'];
                    $opEncontrada = $res['opEncontrada'];
                    $dataTratativa = $res['dataTratativa'];
                
                    $tbl .= "
                        <tr>
                            <td><b>" . $idCadastro . "</b></td>
                            <td><b>" . $trCadastro . "</b></td>
                            <td><b>" . $nomeCadastro . "</b></td>
                            <td><b>" . $uf . "</b></td>
                            <td><b>" . $cidade . "</b></td>
                            <td><b>" . $endereco . "</b></td>
                            <td><b>" . $acessoRef . "</b></td>
                            <td><b>" . $cdoRef . "</b></td>
                            <td><b>" . $problema . "</b></td>
                            <td><b>" . $equipeVistoria . "</b></td>
                            <td><b>" . $dataCadastro . "</b></td>
                            <td><b>" . $status . "</b></td>
                            <td><b>" . $idTratativa . "</b></td>
                            <td><b>" . $trTratativa . "</b></td>
                            <td><b>" . $nomeTratativa . "</b></td>
                            <td><b>" . $localizadaFalha . "</b></td>
                            <td><b>" . $localizadaOportunidade . "</b></td>
                            <td><b>" . $opEncontrada . "</b></td> 
                            <td><b>" . $dataTratativa . "</b></td>
                            
                        </tr>";
                }
            $tbl .= "
            </tbody>
        
        </table>
        ";
        
            $nome_arquivo = 'relatorioVistoria.xls';

            header ("Expires: Mon, 07 Jul 2016 05:00:00 GMT");
            header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header ("Cache-Control: no-cache, must-revalidate");
            header ("Pragma: no-cache");
            header ("Content-type: application/vnd.ms-excel");
            header ("Content-Disposition: attachment; filename= {$nome_arquivo}" );
            header ("Content-Description: PHP Generated Data" );

            echo $tbl;
            exit;
        ?>
        
    </body>
</html>
