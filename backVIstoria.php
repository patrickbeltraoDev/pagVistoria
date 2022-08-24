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
$uf = $_POST['sigla_unidade_federativa'];
$cidade = $_POST['nome_localidade'];
$endereco = $_POST['endereco'];
$acessoRef = $_POST['acessoRef'];
$cdoRef = $_POST['cdoRef'];
$vistoriaProb = $_POST['vistoriaProblema'];
$equipeVistoria = $_POST['equipeVistoria'];

$data_importacao = date('Y-m-d H:i:s');

$sql = "INSERT INTO pci.vistoria (tr, nome, uf, cidade, endereco, 
    acessoRef, cdoRef, problema, equipeVistoria, dataCadastro)
    VALUES ('$tr', '$nome', '$uf', '$cidade', upper('$endereco'), 
    upper('$acessoRef'), upper('$cdoRef'), '$vistoriaProb', '$equipeVistoria', '$data_importacao')";





?>