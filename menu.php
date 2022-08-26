<?
include_once('../conexao/conectar.php');
include_once('../funcao/funcoes_jean.php');

header('Cache-Control: no cache');

$permissao        = get_permissoes();
$usuario_registro = $permissao['matricula'];



$exibe_permissoes = FALSE | $_GET['exibe_permissoes'];

//matriculas autorizadas para estudo de rede
$verifica_mat_aut = "select matricula from pci.autorizados_plano_de_acao";
$exec             = mysql_query($verifica_mat_aut);
while ($res = mysql_fetch_assoc($exec)) {
    $mat_autorizadas_plano[] = $res['matricula'];
}

//matricula autorizadas para triagem
$matriculas_autorizadas = "select matricula_perm from pci.autorizados_triagem_os";
$exec                   = mysql_query($matriculas_autorizadas);
while ($res = mysql_fetch_assoc($exec)) {
    $mat_triagem[] = $res['matricula_perm'];
}

if ($exibe_permissoes)
    echo "<pre>", print_r($permissao, 1), "</pre>linha ", __LINE__;
?>
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/menu_lateral.css">
<link rel="stylesheet" href="../css/responsivo.css">
<link rel="stylesheet" href="../css/pushy.css">


<script>
    $(function() {
        var nav = $('#menuHeader');
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                nav.addClass("menu-f");
                $('body').css('padding-top', 0);
            } else {
                nav.removeClass("menu-f");
                $('body').css('padding-top', 0);
            }
        });
    });
</script>

<script>
    function goBack() {
        window.history.back()
    }
</script>

<nav id="menuHeader">

    <div class="cor-black">


        <button class="menu-btn">&#9776; Menu</button>

        <button class="meio-btn" id="tc_titulo_bt"> <?= addslashes(filter_input(INPUT_GET, 'tc', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?> </button>

        <button class="voltar-btn" onclick="goBack()">&#x2190; Voltar</button>

    </div>

</nav>
<nav class="pushy pushy-left" data-focus="#first-link">
    <div class="pushy-content">

        <?php
        if ($permissao['grupo'] < 13 || $permissao['grupo'] > 17  && $permissao['grupo'] != 20 && $permissao['grupo'] != 22) {
        ?><ul>
                <ul>
                    <li><a href="../cl/pagina_visualizar.php">PESQUISAR PAGINA</a></li>
                </ul>
                <li class="pushy-submenu">


                    <button>OI & VTAL</button>
                    <ul>

                        <?php
                        if ($permissao['grupo'] != 3 && $permissao['grupo'] != 13 && $permissao['grupo'] != 14 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22) {
                        ?>
                            <li class="pushy-submenu">
                                <button>NOVO CONTRATO</button>
                                <ul>
                                    <li><a href="../o&m/indicadores_contratuais_nv.php">INDICADORES RCO </a></li>
                                    <li><a href="../o&m/ind_reparos_contratual.php">INDICADORES CONTRATUAIS</a></li>
                                    <li><a href="../o&m/painel_indicadores_contratuais.php">IND. AGENDAMENTO EFICÁCIA</a></li>
                                    <li><a href="../o&m/visao_reparo_aberto.php">REPAROS ABERTOS (IG)</a></li>
                                    <li><a href="../o&m/visao_reparo_aberto_new.php">REPAROS ABERTOS 2022 (IG)</a></li>
                                    <li><a href="../o&m/indicadores_contratuais_nv_v2.php">NOVO FI </a></li>
                                    <li><a href="../o&m/indicadores_contratuais_nv_v2020.php">NOVO FI 2020</a></li>
                                    <li><a href="../o&m/indicadores_geral.php">RANKING</a></li>
                                    <li><a href="../o&m/visao_acumulada.php">VISAO ACUMULADA</a></li>
                                    <li><a href="../o&m/gestao_avista.php">GESTÃO A VISTA</a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        if (($permissao['voz']) && $permissao['grupo'] != 14 && $permissao['grupo'] != 15 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22) {
                        ?>
                            <li class="pushy-submenu">
                                <button>ANTIGO CONTRATO</button>
                                <ul>
                                    <li><a href="../o&m/novo_ind_gerencial.php">INDICADOR GERENCIAL</a></li>
                                    <li><a href="../o&m/ind_tela_voz_coord.php">PAINEL POR GRAN VOZ</a></li>
                                    <li><a href="../o&m/ind_tela_voz_lider.php">PAINEL POR GRA VOZ</a></li>
                                    <li><a href="../o&m/ind_tela_voz_tecnico_geral.php">TÉCNICO VOZ</a></li>
                                    <li><a href="../o&m/ind_tela_velox_coord.php">PAINEL POR GRAN VELOX</a></li>
                                    <li><a href="../o&m/ind_tela_velox_lider.php">PAINEL POR GRA VELOX</a></li>
                                    <li><a href="../o&m/ind_tela_velox_tecnico_geral.php">TÉCNICO VELOX</a></li>
                                    <li><a href="../o&m/antigo_gestao_avista.php">GESTÃO A VISTA</a></li>
                                </ul>
                            </li>

                        <?php

                        }
                        ?>

                        <li class="pushy-submenu">
                            <button>FTTH</button>
                            <ul>
                                <!-- MONITORIAS E AUDITORIAS INICIO -->
                                <li class="pushy-submenu">
                                    <button>AUDITORIAS E MONITORIA FTTH</button>
                                    <ul>
                                        <li class="pushy-submenu">
                                            <button>MONITORIA ATIVIDADES FTTH</button>
                                            <ul>
                                                <li><a href="../ftth/controle_ftth.php">MONITORIA ATIVIDADES</a></li>
                                                <li><a href="../ftth/graf_auditoria_atividades_rco1.php">GRÁFICOS ATIVIDADES RCO I</a></li>
                                                <li><a href="../ftth/graf_auditoria_atividades_rco2.php">GRÁFICOS ATIVIDADES RCO II</a></li>
                                                <li><a href="../ftth/painel_ga.php">PAINEL GA</a></li>
                                                <li><a href="../ftth/parecer_qualidade.php">PARECER DE QUALIDADE NPS</a></li>
                                                <li><a href="../ftth/parecer_qualidade_rel.php">RELATORIO PARECER DE QUALIDADE NPS</a></li>
                                            </ul>
                                        </li>
                                        <li class="pushy-submenu">
                                            <button>AUDITORIA CLIENTES FTTH</button>
                                            <ul>
                                                <li><a href="../ftth/check_list_22.php">AUDITORIA CLIENTES</a></li>
                                                <li><a href="../ftth/graf_check_list.php">GRÁFICOS CLIENTES RCO I</a></li>
                                                <li><a href="../ftth/graf_check_list2.php">GRÁFICOS CLIENTES RCO II</a></li>
                                                <li><a href="../ftth/graf_check_list_22.php">GRÁFICOS CLIENTES RCO 2022</a></li>
                                            </ul>
                                        </li>
                                        <li class="pushy-submenu">
                                            <button>AUDITORIA FERRAMENTAL FTTH</button>
                                            <ul>
                                                <li><a href="../o&m/checklist_tec.php">AUDITORIA FERRAMENTAL</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../o&m/relatorio_gerencial.php">RELATÓRIO GERENCIAL</a></li>
                                            </ul>
                                        </li>

                                        <li class="pushy-submenu">
                                            <button>OPORTUNIDADE DE MELHORIA</button>
                                            <ul>
                                                <li><a href="../ftth/oportunidade_melhoria.php">CADASTRO</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../ftth/visualizar_evid_melhorias.php">ACOMPANHAMENTO - MANUTENÇÃO</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../ftth/visualizar_evid_homeconnect.php">ACOMPANHAMENTO - HOME CONNECT</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../ftth/visualizar_evid_tratados.php">ACOMPANHAMENTO - OPORTUNIDADES [TRATADAS]</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../ftth/relatorio_oportunidade.php">RELATÓRIO</a></li>
                                            </ul>

                                        </li>

                                        <li class="pushy-submenu">
                                            <button>VISTORIA DE REDE OFENSORA</button>
                                            <ul>
                                                <li><a href="../ftth/vistoriaRede.php">CADASTRO</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../ftth/TratativasVistoria.php">ACOMPANHAMENTO - MANUTENÇÃO</a></li>
                                            </ul>
                                            <ul>
                                                <li><a href="../ftth/TratativasVistoriaHome.php">ACOMPANHAMENTO - HOMECONNECT</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <!-- MONITORIAS E AUDITORIAS FIM -->

                                <li class="pushy-submenu">
                                    <button>QUALIDADE</button>
                                    <ul>
                                        <li><a href="../o&m/hab_grafico.php">GRÁFICO TECNICOS HABILITADOS</a></li>
                                        <li><a href="../o&m/habilitados.php">TECNICOS HABILITADOS</a></li>
                                    </ul>
                                </li>

                                <li><a href="../ftth/consulta_ftth.php">CONSULTA FTTH</a></li>
                                <li><a href="../ftth/tarefas_abertas_ftth.php">TAREFAS ABERTAS-FILA</a></li>
                                <li><a href="../ftth/ind_eficacia_ftth.php">EFICÁCIA FTTH</a></li>
                                <li><a href="../ftth/monitoramento_pendencia.php">MONITORAMENTO DE PENDÊNCIA</a></li>
                                <li><a href="../ftth/tempo_ocioso.php">MONITORAMENTO DE VALIDAÇÃO</a></li>
                                <li><a href="../ftth/ftth_pareto_pendencias.php">PARETO DE PENDÊNCIAS</a></li> <!-- Ricardo Santana | 20200819 -->
                                <li><a href="../ftth/agendamento_ftth.php">AGENDAMENTO FTTH</a></li>
                                <li><a href="../ftth/indicadores_ftth.php">INDICADORES DE REPARO</a></li>
                                <li><a href="../o&m/gestao_avista_ftth.php">GESTÃO A VISTA FTTH</a></li>
                                <li><a href="../o&m/reclassificacao_ba.php">RECLASSIFICAÇÃO FTTH</a></li>
                                <li><a href="../ftth/ind.php">RANKING FTTH</a></li>
                                <li><a href="../ftth/ranking_tec_uf.php">RANKING TÉCNICOS UF</a></li>
                                <li><a href="../ftth/tecnicos_nps.php">TÉCNICOS NPS</a></li>
                                <li><a href="../ftth/tecnicos_eficacia.php">EFICÁCIA TÉCNICOS UF</a></li>
                                <li><a href="../ftth/rede_sobreposta.php">REDE SOBREPOSTA</a></li>


                                <li><a href="../o&m/garantia_online.php">OS GARANTIA ONLINE</a></li>
                                <!-- <li><a href="../ftth/triagem_ftth.php">TRIAGEM DE OS FTTH</a></li>
                               
                                
                                <li class="pushy-submenu">
                                    <button>GESTÃO DAS RETIRADAS DE EQUIPAMENTO</button>
                                    <ul>
                                        <?php
                                        if ($permissao['grupo'] == 1 || $permissao['grupo'] == 19 &&  $permissao['grupo'] != 20) {
                                        ?>
                                        <li><a href="../ftth/devolucao_equipamento.php">DEVOLUÇÃO DE EQUIPAMENTO</a></li>
                                        <?php
                                        }
                                        ?>
                                        <li><a href="../ftth/painel_devolucao_equipamento.php">PAINEL DE DEVOLUÇÕES</a></li>
                                </li>
                                    </ul>
                            -->
                        </li>



                    </ul>
                </li>
            <?
        } else if ($permissao['grupo'] == 16) { ?>

                <li class="pushy-submenu">
                    <button>OPORTUNIDADE DE MELHORIA</button>
                    <ul>
                        <li><a href="../ftth/oportunidade_melhoria.php">CADASTRO</a></li>
                    </ul>
                    <!-- <ul>
                        <li><a href="../ftth/visualizar_evid_melhorias.php">ACOMPANHAMENTO</a></li>
                    </ul> -->
                </li>

            <?php }
        if (($permissao['grupo'] != 3 && $permissao['grupo'] < 13 || $permissao['grupo'] > 20 && $permissao['grupo'] != 22)) {
            ?>
                <li class="pushy-submenu"><a href="javascript:;">TERMINAIS CRÍTICOS</a>
                    <ul>
                        <li><a href="../o&m/terminais_criticos_voz.php">TERMINAIS CRÍTICOS VOZ</a></li>
                        <li><a href="../o&m/terminais_criticos_velox.php">TERMINAIS CRÍTICOS VELOX</a></li>
                        <li><a href="../o&m/painel_acao_terminal_critico_voz.php">PAINEL AÇÕES CRÍTICAS VOZ</a></li>
                        <li><a href="../o&m/painel_acao_terminal_critico_velox.php">PAINEL AÇÕES CRÍTICAS VELOX</a></li>
                        <li><a href="../o&m/painel_acao_terminal_critico_voz_motivo_macro.php">AÇÕES MOTIVO MACRO VOZ</a></li>
                        <li><a href="../o&m/painel_acao_terminal_critico_velox_motivo_macro.php">AÇÕES MOTIVO MACRO VELOX</a></li>
                        <li><a href="http://189.75.118.146:8181/auto/consulta_velox.php">CONSULTA ASSIA</a></li>
                        <li><a href="../o&m/assia_massivo_resumo.php">RESUMO MASSIVO ASSIA</a></li>
                        <?php if ($usuario_registro !=  'TR018333') { ?>
                            <li><a href="../o&m/reteste_sala_gpon.php">RETESTE</a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php
        }

        if (($permissao['grupo'] != 3 && $permissao['grupo'] != 13 && $permissao['grupo'] != 14 && $permissao['grupo'] != 15 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22) || ($permissao['controlador'])) {
            ?>
                <li class="pushy-submenu"><a href="javascript:;">CLICK</a>
                    <ul>
                        <li class="pushy-submenu"><a href="javascript:;">INDICADOR SPOKE</a>
                            <ul>
                                <li><a href="../ftth/indicador_spoke_graficos.php">GRÁFICOS</a></li>
                                <li><a href="../ftth/indicador_spoke.php">INDICADOR</a></li>

                            </ul>
                        </li>

                        <li><a href="../o&m/agendamentos_perdidos.php">AGENDAMENTOS PERDIDOS</a></li>
                        <li><a href="../o&m/ind_cumprimento_agendamento_click.php">CUMPRIMENTO AGENDAMENTO</a></li>
                        <li><a href="../o&m/cumprimento_gross.php">CUMPRIMENTO GROSS</a></li>
                        <li><a href="../o&m/ind_eficacia_click.php">EFICÁCIA </a></li>
                        <li><a href="../o&m/painel_esteira.php">ESTEIRA CLICK RCO</a></li>
                        <li><a href="../o&m/justificativa_esteira.php">JUSTIFICATIVA ESTEIRA</a></li>
                        <!--         <li><a href="../o&m/painel_producao_click.php">PRODUÇÃO CLICK</a></li> -->
                        <li><a href="../o&m/producao_click.php">PRODUÇÃO CLICK 2022</a></li>
                        <li><a href="../o&m/producao_click_hora.php">PRODUÇÃO POR HORA</a></li>
                        <li><a href="../o&m/repasse_lacb.php">REPASSE CB</a></li>
                        <li><a href="../o&m/indisponibilidade_rco.php">INDISPONIBILIDADE </a></li>
                        <li><a href="../o&m/acompanhamento_producao.php">ACOMPANHAMENTO PRODUÇÃO</a></li>
                        <li><a href="../o&m/gestao_fac_estudo_rede.php">IMPEDIMENTOS DE REDE</a></li>
                        <li><a href="../o&m/triagem_correcao_endereco.php">CORRECAO DE ENDERECO</a></li>
                        <li><a href="../o&m/triagem_os.php">TRIAGEM DE O.S</a></li>
                        <li><a href="../o&m/painel_triagem_colaborador.php">PRODUÇÃO TRIAGEM</a></li>
                        <li><a href="../cl/eficacia_reparo.php">EFICÁCIA REPARO</a></li>
                    </ul>
                </li>
            <?php
        }

        if (($permissao['grupo'] != 3 && $permissao['grupo'] != 13 && $permissao['grupo'] != 14 && $permissao['grupo'] != 15 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22)) {
            ?>
                <li class="pushy-submenu"><a href="javascript:;">ANATEL</a>
                    <ul>
                        <li><a href="../o&m/reclassificacao_anatel.php">ANALITICO</a></li>
                        <!--<li><a href="../o&m/acompanhamento_anatel.php">ACOMP. ANATEL RCO</a></li>-->
                        <li><a href="../o&m/propensos_anatel_novo.php">PROPENSOS ANATEL</a></li>
                        <li><a href="../ftth/ranking_propenso.php">PROPENSO ANATEL DETALHADO</a></li>
                        <li><a href="../o&m/anatel.php">RECLASSIFICAÇÃO ANATEL</a></li>
                    </ul>
                </li>
            <?php
        }

        if (($permissao['grupo'] != 3 & $permissao['grupo'] != 13 && $permissao['grupo'] != 15 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22)) {
            ?>
                <!--           <li class="pushy-submenu"><a href="javascript:;">ANALITICO</a>
                    <ul>
                        <li><a href="../o&m/painel_prazo_analitico.php">REPARO NO PRAZO CLICK</a></li>
                        <li><a href="../o&m/painel_eficacia_analitico.php">EFICACIA ANALITICO</a></li>
                        <li><a href="../o&m/painel_agendamento_analitico.php">AGENDAMENTO ANALITICO</a></li>
                        <li><a href="../o&m/painel_analitico_tmr.php">TMR ANALITICO</a></li>
                        <li><a href="../o&m/painel_analitico_trimestral_tmr.php">TMR ANALITICO TRIMESTRAL</a></li>
                        <li><a href="../o&m/tempo_improdutivo.php">TEMPO IMPRODUTIVO</a></li>
                        <li><a href="../o&m/solicitacao_expurgo.php">SOLICITAÇÃO DE EXPURGO</a></li>
                    </ul>
                </li> -->
            <?php
        }


        if (($permissao['grupo'] != 3 && $permissao['grupo'] != 13 && $permissao['grupo'] != 14 && $permissao['grupo'] != 15 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22)) {
            ?>
                <li class="pushy-submenu"><a href="javascript:;">DTH ANTIGO CONTRATO</a>
                    <ul>
                        <li><a href="../o&m/ind_cont_oitv.php">INDICADORES OI TV</a></li>
                        <li><a href="../o&m/ind_home_network.php">HOME NETWORK</a></li>
                        <li><a href="../o&m/reparos_abertos_dth.php">REPAROS ABERTOS DTH</a></li>
                    </ul>
                </li>
            <?php
        }



        if (($usuario_registro !=  'TR018333' && $permissao['grupo'] != 3 && $permissao['grupo'] != 14 && $permissao['grupo'] != 15 && $permissao['grupo'] != 16 && $permissao['grupo'] != 17 && $permissao['grupo'] != 18 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20 && $permissao['grupo'] != 22) && ($permissao['voz'] || $permissao['velox'])) {
            ?>

                <li class="pushy-submenu"><a href="javascript:;">BOLETIM TÉCNICO</a>
                    <ul>
                        <li><a href="../o&m/ind_informe_boletim_qualidade.php">SEMANAL</a></li>
                        <li><a href="../o&m/ind_boletim_qualidade_nv.php">MENSAL</a></li>
                    </ul>
                </li>

            <?php
        }

        if (($permissao['grupo'] == 13 || $permissao['grupo'] == 16)) {
            ?>
                <li><a href="../o&m/reteste_sala_gpon.php">RETESTE</a></li>
                <li><a href="../o&m/indicadores_geral_tec_individual.php">RANKING COBRE</a> </li>
                <li><a href="../ftth/check_list_line.php">AUDITORIA CHECK LIST</a> </li>
                <li><a href="../ftth/ranking_tec_uf.php">RANKING FTTH</a></li>
            <?php
        }

            ?>

            <?php

            if (($permissao['grupo'] != 3  && $permissao['grupo'] < 13 || $permissao['grupo'] > 20  && $permissao['grupo'] != 22)) {
            ?>
                <li><a href="../o&amp;m/relatorios_qualidade.php">RELATÓRIOS</a></li>

            <?php
            }

            ?>


            <?php

            if (($permissao['grupo'] != 3 && $permissao['grupo'] != 10 && $permissao['grupo']  < 13 || $permissao['grupo'] > 17  && $permissao['grupo'] != 22)) {
            ?>

                <li class="pushy-submenu">
                    <button>IMPLANTAÇÃO</button>
                    <ul>
                        <li><a href="../implantacao/enderecos_viaveis.php">ENDEREÇOS VIÁVEIS</a></li>
                        <li><a href="../implantacao/omr.php">FILA OMR</a></li>
                        <li><a href="../implantacao/relatorio_omr.php">TRATATIVA OMR</a></li>
                    </ul>
                </li>

            <?php
            }

            ?>

            <?php
            if ($permissao['grupo'] == 1 || $permissao['grupo'] == 2 || $permissao['grupo'] == 4 || $permissao['grupo'] == 5 || $permissao['grupo'] == 10 || $permissao['grupo'] == 13 || $permissao['grupo'] == 16 && $permissao['grupo'] != 20) {
            ?>
                <li><a href="/auto/consultaFac.php" target="_blank">CONSULTAR FACILIDADES</a></li>
            <?php
            }
            ?>
            <?php

            // if (($permissao['grupo'] != 3 && $permissao['grupo'] != 10 && $permissao['grupo'] != 13 && $permissao['grupo'] != 14 && $permissao['grupo'] != 15 && $permissao['grupo'] != 17 && $permissao['grupo'] != 19 && $permissao['grupo'] != 20)) {

            if ($permissao['grupo'] == 10 || $permissao['grupo'] == 1 || $permissao['grupo'] == 4) {
            ?>


                <li class="pushy-submenu">
                    <button>CONTROLE LOCAL</button>
                    <ul>
                        <li class="pushy-submenu">
                            <button>VALIDAÇÃO</button>
                            <ul>
                                <li><a href="../cl/valida_pendencia.php">VALIDAÇÃO DE PENDÊNCIA</a></li>
                                <li><a href="../cl/reverter.php">RELATÓRIO OPERADOR CL</a></li>
                                <li><a href="../cl/valida.php">RELATÓRIO VALIDAÇÃO TÉCNICO</a></li>

                            </ul>
                        </li>
                        <li><a href="../cl/triagem_ftth.php">TRIAGEM DE OS FTTH</a></li>
                        <li><a href="../cl/valida_pendencia.php">VALIDAÇÃO DE PENDÊNCIA</a></li>
                        <li><a href="../o&m/quiz2.php">TESTE SEU CONHECIMENTO</a></li>

                        <?php
                        if ($permissao['grupo'] == 1 || $permissao['grupo'] == 4) {
                        ?>
                            <li><a href="../o&m/exportar_excel_quiz.php">RELATÓRIO</a></li>
                        <?php
                        }
                        ?>

                    </ul>
                </li>

            <?php
            } else {
            ?>
                <li><a href="../cl/valida.php">RELATÓRIO VALIDAÇÃO TÉCNICO</a></li>
            <?php
            }

            ?>

            </ul>
            </li>

            <!--
            <?php if (($permissao['tim']) &&  $permissao['grupo'] == 1 || $permissao['grupo'] == 2 || $permissao['grupo'] == 15 || $permissao['grupo'] == 17 || $permissao['grupo'] == 20) {   ?>
                <li class="pushy-submenu">
                    <button>TIM</button>
                    <ul>
                        <ul>
                        <?php } ?>
                        <li class="pushy-submenu">
                            <?php if (($permissao['tim']) &&  $permissao['grupo'] == 1 || $permissao['grupo'] == 2 || $permissao['grupo'] == 15 || $permissao['grupo'] == 17) {   ?>
                               <button>GO</button>
                                <ul> 
                                    <ul>
                                       <li class="pushy-submenu">
                                            <button>BACKLOG REPAROS</button>
                                            <ul>
                                                <li><a href="../tim/gestao_avista_tim.php">GESTÃO A VISTA</a></li>
                                                <li><a href="../tim/backlog_reparos.php">REPAROS MAX</a></li>
                                                <li><a href="../tim/backlog_status.php">REPAROS DO DIA</a></li>
                                                <li><a href="../tim/reparos_msan_faixa_horas.php">CONCENTRACAO REPAROS</a></li>
                                                <li><a href="../tim/listar_reparos.php">LISTAR REPAROS</a></li>

                                            </ul>
                                        </li>

                                        <li class="pushy-submenu">
                                            <button>FISCALIZA&Ccedil;&Atilde;O</button>
                                            <ul>
                                                <li><a href="../tim/controle_fiscalizacao_tim.php">CONTROLE</a></li>
                                                <li><a href="../tim/visualizacao_tim.php">VISUALIZAÇÃO</a></li>
                                            </ul>
                                        </li>
                                        <?php if ($permissao['grupo'] != 17) { ?>
                                            <li><a href="../tim/cadastro_trea.php">CONTROLE TREA/CHECK LIST</a></li>
                                        <?php }
                                        if ($permissao['grupo'] == 17) { ?>
                                            <li><a href="../tim/trea_relatorio.php">RELATÓRIO TREA</a></li>
                                        <?php } ?>
                                        <li><a href="../tim/instalacao_recentes.php">INSTALAÇÕES NA GARANTIA</a></li>
                                        <li><a href="../tim/producao_painel_tim.php?tc=PAINEL%20DE%20PRODU&Ccedil;&Atilde;O%20TIM">PAINEL DE PRODU&Ccedil;&Atilde;O</a></li>
                                        <li><a href="../tim/painel_producao.php">PRODUÇÃO</a></li>
                                        <li><a href="../tim/producao_tec.php">PRODUÇÃO POR HORA</a></li>
                                        <li><a href="../tim/eficiencia.php">EFICIÊNCIA</a></li>
                                        <li><a href="../tim/tempo_de_improdutividade.php">TEMPO DE IMPRODUTIVIDADE</a></li>
                                        <li><a href="../tim/reteste_tim.php">RETESTE</a></li>
                                        <li><a href="../tim/agendamento_triagen.php">TRIAGEM AGENDAMENTO</a></li>

                                    </ul>
                        </li>

                        <li class="pushy-submenu">
                             <button>TEMPO PRODUTIVO</button>
                                <ul>
                                <li><a href="../tim/mes_carga_horas.php">TEMPO PRODUTIVO</a></li>
                                </ul>
                        </li> 
                    <?php echo '</ul>';
                            }
                            if ($permissao['grupo'] == 20 ||  $permissao['grupo'] == 2 || $permissao['grupo'] == 1) {
                                echo '</ul>'; ?>

                       <li class="pushy-submenu">
                            <button>SP</button>
                            <ul>
                                <ul>

                                    <li><a href="../tim_sp/painel_producao.php">PRODUÇÃO</a></li>

                                    <li><a href="../tim_sp/eficiencia.php">EFICIÊNCIA</a></li>

                                    <li><a href="../tim_sp/producao_tec.php">PRODUÇÃO POR HORA</a></li>
                                    <li><a href="../tim_sp/instalacao_recentes.php">INSTALAÇÔES NA GARANTIA</a></li>

                                    <li><a href="../tim_sp/reteste_tim.php">RETESTE</a></li>

                                </ul>
                        </li>

                        </ul>
                    </ul> 

                <?php
                            } else {
                                echo '</ul></ul>';
                            }
                ?>-->
            </ul>
            </ul>



            <!-- MENU MINAS GERAIS -->

            <?php if ($permissao['grupo'] == 1 || $permissao['grupo'] == 22) {   ?>
                <li class="pushy-submenu">
                    <button>MG</button>
                    <ul>

                        <li class="pushy-submenu">
                            <button>MONITORIA ATIVIDADES FTTH</button>
                            <ul>
                                <li><a href="../mg/controle_ftth.php">MONITORIA ATIVIDADES</a></li>
                                <li><a href="../mg/graf_auditoria_atividades_rmg.php">GRÁFICOS ATIVIDADES - RMG</a></li>
                                <li><a href="../mg/painel_ga.php">PAINEL GA</a></li>
                            </ul>
                        </li>
                        <li class="pushy-submenu">
                            <button>AUDITORIA CLIENTES FTTH</button>
                            <ul>
                                <li><a href="../mg/ftth_auditoria_qualidade.php">AUDITORIA CLIENTES</a></li>
                                <li><a href="../mg/graf_auditoria_velocidades_rmg.php">GRÁFICOS CLIENTES - RMG</a></li>
                                <!-- <li><a href="../mg/graf_auditoria_velocidades_es.php">GRÁFICOS CLIENTES - ES</a></li>  -->
                            </ul>
                        </li>

                        <!-- <li><a href="../mg/atualizar_setor.php" target="_blank">HIERARQUIA - FÉRIAS</a></li>
                       <li><a href="../mg/painel_ga.php" target="_blank">PAINEL GA</a></li>        -->

                    </ul>
                </li>

            <?php } ?>



            <!-- MENU CHAMADOS -->
            <?php
            if ($permissao['grupo'] != 16) {
            ?>

                <li class="pushy-submenu"><a href="javascript:;">CHAMADOS</a>
                    <ul>
                        <li><a href="../ondemand/">SOLICITAÇÃO/ACOMP.</a></li>

                        <?php
                        if ($permissao['grupo'] == 1) {
                        ?>
                            <li><a href="../ondemand/">RELATÓRIOS</a></li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permissao['grupo'] != 22) {
                        ?>
                            <li><a href="../o&m/atualizar_setor.php">HIERARQUIA</a></li>
                            <li><a href="../ftth/funcionarios_sigo.php">HIERARQUIA SIGO</a></li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($permissao['grupo'] == 1 || $permissao['grupo'] == 22) {
                        ?>
                            <li><a href="../mg/atualizar_setor.php" target="_blank">HIERARQUIA-RMG</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
            <?php
            }
            ?>



            <li class="pushy-submenu"><a href="javascript:;">ADMINISTRAÇÃO</a>
                <ul>
                    <li><a href="../o&amp;m/perfil_usuario.php">MEU PERFIL</a></li>
                    <li><a href="../alterar_senha/">ALTERAR SENHA</a></li>
                    <?php

                    if ($permissao['grupo'] == 21 || $permissao['grupo'] == 1) {
                    ?>
                        <li><a href="../vt/vale_transp.php">VALE TRANSPORTE</a></li>
                    <?php
                    }
                    if ($permissao['grupo'] == 1) {
                    ?>
                        <li><a href="../o&amp;m/cadastro_metas_producao.php">METAS PRODUÇÃO</a></li>
                        <li><a href="../o&amp;m/paginas_restritas.php">PÁGINAS RESTRITAS</a></li>
                        <li><a href="../o&amp;m/registro_usuarios.php">CONTROLE DE USUÁRIOS</a></li>
                        <li><a href="../o&amp;m/acomp_ind_click.php">ACOMP. BASES ATUALIZADAS</a></li>
                        <li><a href="../o&amp;m/painel_coletador_voz.php">BDS VOZ SABRE</a></li>
                        <li><a href="../o&amp;m/painel_coletador_velox.php">BDS VELOX SABRE</a></li>
                        <li><a href="../o&amp;m/painel_coletador_garantia.php">O.S ATIVAÇÃO</a></li>
                        <li><a href="../o&amp;m/registro_grupos.php">CONTROLE DE GRUPOS</a></li>
                        <li><a href="../o&amp;m/monitor_coletadores.php">GESTÃO DE COLETA</a></li>
                        <li><a href="../cl/base.php">ACOMPANHAMENTO BASES</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>

            <li><a href="../sair.php">SAIR</a></li>
            </ul>
    </div>
</nav>
<!-- Site Overlay -->
<div class="site-overlay"></div>
<!-- Pushy JS -->
<script src="../js/pushy.min.js"></script>