<!-- AUTHOR: PATRICK BELTRÃO - DESENVOLVEDOR DE SISTEMAS JR. -->


<?php

//Incluir a conexao com BD
ini_set("display_errors", 0);
include_once('../conexao/conectar.php');
include_once('../funcao/funcoes_jean.php');
include_once('./redimensiona_oportunidades.php');
header('Content-Type: text/html; charset=utf-8');


if (isset($_POST['acao']) && $_POST['acao'] == "cadastrar") {

	$foto1 = $_FILES['img1'];
	$redim = new Redimensiona();
	$src1 = $redim->Redimensionar($foto1, 800, "images");

	$foto2 = $_FILES['img2'];
	$redim = new Redimensiona();
	$src2 = $redim->Redimensionar($foto2, 800, "images");

	$foto3 = $_FILES['img3'];
	$redim = new Redimensiona();
	$src3 = $redim->Redimensionar($foto3, 800, "images");

}


$tr = $_POST['tr'];
$nome = $_POST['nome'];
$idVistoria = $_POST['idVistoria'];
$locFalha = $_POST['escolha'];
$locOportunidade = $_POST['escolha2'];
$oportEncontrada = $_POST['opEncontrada'];

$evidencia1 = $src1;
$evidencia2 = $src2;
$evidencia3 = $src3;

$data_importacao = date('Y-m-d H:i:s');


$sql = "INSERT INTO pci.vistoriaManutencao (tr, nome, localizadaFalha, localizadaOportunidade, oportunidadeEncontrada, 
    foto1, foto2, foto3, dataTratativa, idVistoria)
    VALUES ('$tr', '$nome', '$locFalha', '$locOportunidade', '$oportEncontrada', 
    '$evidencia1', '$evidencia2', '$evidencia3', '$data_importacao', '$idVistoria')";

$qr = mysql_query($sql) or die(mysql_error("ERRO AO INSERIR!"));


if($locFalha == 'nao' && $locOportunidade == 'nao'){
	$sql2 = "UPDATE pci.vistoria SET status = 'nao atuou' where id = $idVistoria";
	$qr2 = mysql_query($sql2) or die(mysql_error("ERRO AO INSERIR!"));
}elseif($oportEncontrada == 1 || $oportEncontrada == 2){
	$sql2 = "UPDATE pci.vistoria SET status = 'tratada' where id = $idVistoria";
	$qr2 = mysql_query($sql2) or die(mysql_error("ERRO AO INSERIR!"));
}elseif($oportEncontrada == 3 || $oportEncontrada == 4){
	$sql2 = "UPDATE pci.vistoria SET status = 'pendente' where id = $idVistoria";
	$qr2 = mysql_query($sql2) or die(mysql_error("ERRO AO INSERIR!"));
}






desconectar($db);

?>