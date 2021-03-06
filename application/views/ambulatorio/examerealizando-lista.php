<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Atendimentos</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $empresa_p = $this->guia->listarempresapermissoes();
            ?>
            <table>
                <thead>
                    <tr>
                        <th  colspan="2" class="tabela_title">Salas</th>
                        <th class="tabela_title">Nome</th>
                    </tr>
                    <tr>

                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarexamerealizando">
                    <th colspan="2" class="tabela_title">
                        <select name="sala" id="sala" class="size2">
                            <option value="">TODAS</option>
                            <? foreach ($salas as $value) : ?>
                                <option value="<?= $value->exame_sala_id; ?>" <?
                                if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </th>
                    <th colspan="4" class="tabela_title">
                        <input type="text" name="nome" class="texto09" value="<?php echo @$_GET['nome']; ?>" />

                    </th>
                    <th colspan="2" class="tabela_title">
                        <button type="submit" id="enviar">Pesquisar</button>
                    </th>
                </form>
                </tr>
                <tr>
                    <th class="tabela_header">Pedido</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Agenda</th>
                    <th class="tabela_header">Tempo</th>
                    <th class="tabela_header">Sala</th>
                    <th class="tabela_header">Tecnico</th>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header" colspan="10"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexames($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $perfil_id = $this->session->userdata('perfil_id');
                        $lista = $this->exame->listarexames($_GET)->orderby('e.data_cadastro')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_cadastro;

                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->guia_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $teste; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sala; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tecnico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> 
                                    <div class="bt_link" style="width: 85px">                                 
                                        <a style="width: 85px" href="<?= base_url() ?>ambulatorio/exame/anexarimagem/<?= $item->exames_id ?>/<?= $item->sala_id ?>">
                                            Atendimento
                                        </a>
                                    </div>
                                </td>
                                <? if ($empresa_p[0]->tecnica_enviar == 't' || ($perfil_id != 15 && $perfil_id != 7)) { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/finalizarexame/<?= $item->exames_id ?>/<?= $item->sala_id ?> ">
                                            Finalizar
                                        </a></div>
                                </td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/finalizarexametodos/<?= $item->sala_id ?>/<?= $item->guia_id; ?>/<?= $item->grupo; ?> ">
                                            Todos
                                        </a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/pendenteexame/<?= $item->exames_id ?>/<?= $item->sala_id ?> ">
                                            Pendente
                                        </a></div>
                                </td>
                                <td>
                                    <? if ($empresa_p[0]->tecnica_enviar == 't' || ($perfil_id != 15 && $perfil_id != 7)) { ?>


                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/laudo/chamarpaciente2/<?= $item->ambulatorio_laudo_id ?> ">
                                                Chamar</a></div>
                                        <!--                                        impressaolaudo -->
                                    </td>
                                <? } ?>

                                <?
                                if ($perfil_id == 1) {
                                    if ($item->agrupador_pacote_id == '') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/exame/examecancelamento/<?= $item->exames_id ?>/<?= $item->sala_id ?> /<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?> ">
                                                    Cancelar
                                                </a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link_new">
                                                <a target="_blank" href="<?= base_url() ?>ambulatorio/exame/pacotecancelamento/<?= $item->sala_id ?>/<?= $item->guia_id ?>/<?= $item->paciente_id ?>/<?= $item->agrupador_pacote_id ?> ">
                                                    Cancelar Pacote
                                                </a></div>
                                        </td>
                                        <?
                                    }
                                }
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/voltarexame/<?= $item->exames_id ?>/<?= $item->sala_id ?>/<?= $item->agenda_exames_id ?> ">
                                            Voltar
                                        </a></div>
                                </td>
        <!--                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/estoqueguia/<?= $item->exames_id ?>/<?= $item->sala_id ?>/<?= $item->agenda_exames_id ?> ">
                                            estoque
                                        </a></div>
                                </td>-->
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="17">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                            <select style="width: 57px">
                                <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/exame/listarexamerealizando/25');" <?
                                if ($limit == 25) {
                                    echo "selected";
                                }
                                ?>>25 </option>
                                <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/exame/listarexamerealizando/50');" <?
                                if ($limit == 50) {
                                    echo "selected";
                                }
                                ?>>50 </option>
                                <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/exame/listarexamerealizando/100');" <?
                                if ($limit == 100) {
                                    echo "selected";
                                }
                                ?>> 100 </option>
                                <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/exame/listarexamerealizando/todos');" <?
                                if ($limit == "todos") {
                                    echo "selected";
                                }
                                ?>> Todos </option>
                            </select>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
