<?php
    //author: Patrick,  Data inicial: 23/08/2022

    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 0);
    include_once("../topo.php");
    include_once('../conexao/config.php');
    include_once('../conexao/conectar.php');
    include_once('../funcao/dias.php');
    include_once('../funcao/converte_letras.php');
    include_once('../funcao/funcoes_jean.php'); 
    include_once('../redimensiona.php');
    
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
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/styleVistoria.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        <title>Vistoria de Rede Ofensora</title>
    </head>
    <body>

        <div class="container">
            <div class="title">
                <h2 class="title-pag" >VISTORIA DE REDE OFENSORA DE ROMPIMENTO DE DROP E CABO</h2>
            </div>

            <form action="backVistoria.php" method="post" class="">
                <div class="form-floating mb-3">

                    <?php
                        $sql7 = "SELECT sigla_unidade_federativa from pci.tbl_servicos_associados_rede GROUP BY sigla_unidade_federativa";
                        $qr_7 = mysql_query($sql7) or die(error_msg(mysql_error(), $sql7));
                        while($result_uf = mysql_fetch_assoc($qr_7)){
                            $v_filtros['sigla_unidade_federativa'][] = $result_uf['sigla_unidade_federativa'];
                        }
                        foreach ($v_filtros['sigla_unidade_federativa'] as $key) {
                            $ar = $tag_filtros['sigla_unidade_federativa'] .= "<option value='$key' " . (in_array($key, $_REQUEST['sigla_unidade_federativa']) ? 'selected' : '') . ">$key</option>";
                        }
                    ?>
                    <label for="sigla_unidade_federativa">UF</label>
                    <select name='sigla_unidade_federativa[]' class="col-md-6" id="sigla_unidade_federativa" title="UF" required>
                        <?php echo $tag_filtros['sigla_unidade_federativa']; ?>
                    </select>
                    <!-- <input type="text" class="form-control" id="uf" name="uf"> -->
                </div>

                <div class="form-floating mb-3">
                    <label for="cidade">CIDADE</label>
                    <input type="text" class="form-control" id="cidade" name="cidade">
                </div>
                <div class="form-floating mb-3">
                    <label for="endereco">ENDEREÇO</label>
                    <input type="text" class="form-control" id="endereco" name="endereco">
                </div>
                <div class="form-floating mb-3">
                    <label for="acessoGP">INFORME ACESSO GPON DE REFERÊNCIA</label>
                    <input type="text" class="form-control" id="acessoGP" name="acessoGP">
                </div>
                <div class="form-floating mb-3">
                    <label for="cdo">INFORME CDO DE REFERÊNCIA</label>
                    <input type="text" class="form-control" id="cdo" name="cdo">
                </div>



            </form>

        </div>














        <script src="./css/js/bootstrap.bundle.min.js"></script>
    </body>
</html>