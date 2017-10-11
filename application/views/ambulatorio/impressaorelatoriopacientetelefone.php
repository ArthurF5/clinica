<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->

    <h4>TODAS AS CLINICAS</h4>

    <h4>Relatorio Paciente Telefone</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
</h4>
<hr>
<table border="1">
    <thead>
        <tr>

            <th class="tabela_header" width="250px;">Paciente</th>
            <th class="tabela_header" width="250px;">Pocedimento</th>
            <th class="tabela_header">Convênio</th>
            <th class="tabela_header">Grupo</th>
            <th class="tabela_header">Telefone</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $paciente = "";
        $convenio = "";

        if (count($relatorio) > 0) {
            foreach ($relatorio as $item) {
                //$dataFuturo = date("Y-m-d H:i:s");
                //$dataAtual = $item->data_atualizacao;

                if ($item->celular != "") {
                    $telefone = $item->celular;
                } elseif ($item->telefone != "") {
                    $telefone = $item->telefone;
                } else {
                    $telefone = "";
                }



                $data = $item->data;
                $dia = strftime("%A", strtotime($data));

                switch ($dia) {
                    case"Sunday": $dia = "Domingo";
                        break;
                    case"Monday": $dia = "Segunda";
                        break;
                    case"Tuesday": $dia = "Terça";
                        break;
                    case"Wednesday": $dia = "Quarta";
                        break;
                    case"Thursday": $dia = "Quinta";
                        break;
                    case"Friday": $dia = "Sexta";
                        break;
                    case"Saturday": $dia = "Sabado";
                        break;
                }
                ?>
                <tr>

                    <td <b><?= $item->paciente; ?></b></td>
                    <td <b><?= $item->nome; ?></b></td>
                    <td <b><?= $item->convenio; ?></b></td>
                    <td ><?= $item->grupo; ?></td>
                    <td ><?= $telefone; ?></td>
                </tr>

            </tbody>
            <?php
        }
    }
    ?>

</table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>