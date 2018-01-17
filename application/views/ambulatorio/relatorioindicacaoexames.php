<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Recomendação</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatorioindicacaoexames">
                <dl>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
                    <dt>
                        <label>Grupo Recomendação</label>
                    </dt>
                    <dd>
                        <select name="grupo_indicacao" id="grupo_indicacao" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($grupos as $item) : ?>
                                <option value="<?= $item->grupo_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>                            
                        </select>
                    </dd>
                    <dt>
                        <label>Recomendação</label>
                    </dt>
                    <dd>
                        <select name="indicacao" id="indicacao" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($indicacao as $value) : ?>
                                <option value="<?= $value->paciente_indicacao_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Gráfico</label>
                    </dt>
                    <dd>
                        <select name="grafico" id="indicacao" class="size2">
                            <option value="0">NÃO</option>
                            <option value="1">SIM</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function () {
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function () {
        $("#accordion").accordion();
    });

</script>