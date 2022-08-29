<?php

class Redimensiona
{

	public function Redimensionar($imagem, $largura, $pasta)
	{

		//$mkdir = "/xampp2/htdocs/pci/ftth/imagens/";
		//$mkdir = "pci/ftth/imagens";
		//$mkdir = "/var/www/html/pci/tim/imagens/";
		$mkdir = "D:\\\\TELEMONT\\\\www\\\\pci\\\\ftth\\\\imagens\\\\vistoriaRede\\\\";

		@mkdir($mkdir, 0777);

		$name = md5(uniqid(rand(), true));

		$tecnico = SUBSTR($_POST["tecnico"], 0, 8);

		if ($imagem['type'] == "image/jpeg") {
			$img = imagecreatefromjpeg($imagem['tmp_name']);
		} else if ($imagem['type'] == "image/gif") {
			$img = imagecreatefromgif($imagem['tmp_name']);
		} else if ($imagem['type'] == "image/png") {
			$img = imagecreatefrompng($imagem['tmp_name']);
		}
		$x   = imagesx($img);
		$y   = imagesy($img);
		$autura = ($largura * $y) / $x;

		$nova = imagecreatetruecolor($largura, $autura);
		imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $autura, $x, $y);

		if ($imagem['type'] == "image/jpeg") {
			$local = $mkdir . $_POST["nrba"] . "_tr_" . $tecnico . "_" . $name . ".jpg";
			$name_file = $_POST["nrba"] . "_tr_" . $tecnico . "_" . $name . ".jpg";
			imagejpeg($nova, $local);
		} else if ($imagem['type'] == "image/gif") {
			$local = $mkdir . $_POST["nrba"] . "_tr_" . $tecnico . "_" . $name . ".gif";
			$name_file = $_POST["nrba"] . "_tr_" . $tecnico . "_" . $name . ".gif";
			imagejpeg($nova, $local);
		} else if ($imagem['type'] == "image/png") {
			$local = $mkdir . $_POST["nrba"] . "_tr_" . $tecnico . "_" . $name . ".png";
			$name_file = $_POST["nrba"] . "_tr_" . $tecnico . "_" . $name . ".png";
			imagejpeg($nova, $local);
		}

		imagedestroy($img);
		imagedestroy($nova);

		return $name_file;
	}
}
