<?php

    //Incluir a conexao com BD
ini_set("display_errors", 0);
include_once('../conexao/conectar.php');
include_once('../funcao/funcoes_jean.php');
include_once('./redimensiona_oportunidades.php');
header('Content-Type: text/html; charset=utf-8');
////////////////////////////////////////////////////////////

$tr = $_POST['tr'];
$nome = $_POST['nome'];
$uf = implode("','", $_REQUEST['sigla_unidade_federativa']);
$cidade = implode("','", $_REQUEST['nome_localidade']);
$endereco = $_POST['endereco'];
$acessoRef = $_POST['acessoRef'];
$cdoRef = $_POST['cdoRef'];
$vistoriaProb = implode("','", $_REQUEST['vistoriaProblema']);
$equipeVistoria = $_POST['equipeVistoria'];

$data_importacao = date('Y-m-d H:i:s');

$uf = implode("','", $_REQUEST['sigla_unidade_federativa']);

$sql = "INSERT INTO pci.vistoria (tr, nome, uf, cidade, endereco, 
    acessoRef, cdoRef, problema, equipeVistoria, dataCadastro, status)
    VALUES ('$tr', '$nome', '$uf', '$cidade', upper('$endereco'), 
    upper('$acessoRef'), upper('$cdoRef'), '$vistoriaProb', '$equipeVistoria', '$data_importacao', 'a tratar')";


$qr = mysql_query($sql) or die(mysql_error("ERRO AO INSERIR!"));

  
desconectar($db);
?>