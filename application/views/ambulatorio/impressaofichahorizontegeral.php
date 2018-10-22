<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <table>
        <td>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <?= @$cabecalho_config; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table style="width: 100%;">
                <tbody>
                    <tr>                        
                        <td width="900px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>

                </tbody>
            </table>
        </td>
    </table>
    <table style="width: 100%">
        <tr>            
            <td colspan="2"><b><font size = -1><?= $paciente['0']->nome; ?></b></td>
            <td ><font size = -1>Data de Realização do(s) exame(s): <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?></td>            
<!--            <td ><font size = -1>
                <b>Resultado: www.clinicavaleimagem.com.br/ </b><br>
                Usuario:&nbsp;<b><?= $paciente['0']->paciente_id ?>&nbsp;</b>Senha: &nbsp;<b><?= $exames['0']->agenda_exames_id ?></b>
            </td>-->
        </tr>
        <tr>
            <td colspan="1"><font size = -1>Exame(s):<b> <?= $exame[0]->procedimento; ?></b></td>            
        </tr>
    </table>

    <br><br>
    <?
    foreach ($exames as $item) :
        if ($item->grupo == $exame[0]->grupo) {
            $exame_id = $item->agenda_exames_id;
            $dataatualizacao = $item->data_autorizacao;
            $inicio = $item->inicio;
            $agenda = $item->agenda;
            $operador_autorizacao = $item->operador;
            ?>     
            <?
        }
    endforeach;
    ?>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <?= @$cabecalho_config; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>                        
                        <td width="700px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>                    
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            <?= @$cabecalho_config; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>                        
                        <td width="700px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>  
                </table>
            </td>
        </tr>

    </table>
    <table style="width: 100%;">
        <tr>
            <td>
                <hr>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <hr>
            </td>
            <td>
                <hr>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <hr>
            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 11pt;">
<!--        <tr>
            <td>
                <table>
                    <tr>
                        <td width="700px" align="center"><?= @$cabecalho_config; ?><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>
                </table>
            </td>
        </tr>-->
        <tr>
            <td>Código: <?= $item->codigo ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?></td>
            <td>Código: <?= $item->codigo ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?></td>
<!--            <td>
                Agenda...: <?= $exame[0]->crm_medico; ?>  - <?= $exame[0]->medico; ?>
            </td>-->
<!--            <td>
                <span style="font-weight: bold; font-size: 14pt;">Formulário(AN): <?= $exame[0]->ambulatorio_guia_id; ?></span> 
            </td>-->
        </tr>
        <tr>
            <td>
                Paciente.: <span style="font-weight: bold"><?= $paciente[0]->paciente_id; ?>  - <?= $paciente[0]->nome; ?></span>
            </td>
            <td>
                Paciente.: <span style="font-weight: bold"><?= $paciente[0]->paciente_id; ?>  - <?= $paciente[0]->nome; ?></span>
            </td>
<!--            <td>
                Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?>
            </td>-->
        </tr>
        <tr>
            <td>
                Idade.......:  <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                
            </td>
            <td>
                Idade.......:  <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                
            </td>
<!--            <td>
                Endereço: <?= $paciente[0]->logradouro; ?>  - <?= $paciente[0]->numero; ?> - <?= $paciente[0]->bairro; ?>
            </td>-->
<!--            <td>
                RG: <?= $paciente[0]->rg; ?>
            </td>-->
        </tr>
        <tr>
            <td>RG: <?= $paciente[0]->rg; ?></td>
            <td>RG: <?= $paciente[0]->rg; ?></td>
        </tr>
        <tr>
            <td>
                Telefones: <?= $paciente[0]->telefone; ?>  - <?= $paciente[0]->celular; ?> - <?= $paciente[0]->whatsapp; ?>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Sexo:  <span style="font-weight: bold"><?= $paciente[0]->sexo; ?></span>
            </td>
            <td>
                Telefones: <?= $paciente[0]->telefone; ?>  - <?= $paciente[0]->celular; ?> - <?= $paciente[0]->whatsapp; ?>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Sexo:  <span style="font-weight: bold"><?= $paciente[0]->sexo; ?></span>
            </td>
<!--            <td>
                CPF......: <?= ($paciente[0]->cpf_responsavel_flag == 'f') ? $paciente[0]->cpf : ''; ?>
            </td>-->
        </tr>
        <tr>

<!--            <td>
                Idade.......: <span style="font-weight: bold"> <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>
                </span>
            </td>-->
<!--            <td>
                <span style="font-weight: bold">Chegada:  <?= substr($dataatualizacao, 10, 9); ?></span>
            </td>-->
        </tr>
        <tr>
            <td>
                Tipo de Atendimento.: <span style="font-weight: bold"> <?= $exame[0]->convenio; ?> </span>
            </td>
            <td>
                Tipo de Atendimento.: <span style="font-weight: bold"> <?= $exame[0]->convenio; ?> </span>
            </td>

        </tr>
        <tr>
            <td>Forma de Pagamento.:</td>
            <td>Forma de Pagamento.:</td>

        </tr>
        <tr>
            <td>
                Atendente...: <?= $exame[0]->atendente; ?>
            </td>
            <td>
                Atendente...: <?= $exame[0]->atendente; ?>
            </td>
<!--            <td>
                Carteira....: <?= $paciente[0]->convenionumero; ?>
            </td>
            <td>
                Autorização: <?= $exame[0]->autorizacao; ?>
            </td>-->
        </tr>
        <tr>
            <td>Película: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CD: </td>
            <td>Película: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CD: </td>
        </tr>
<!--        <tr>
            <td>
                Solicitante: <?= $exame[0]->crm_solicitante; ?>  - <?= $exame[0]->medicosolicitante; ?>
            </td>
            <td>
                Validade: <? //= $exame[0]->agenda_exames_id;                       ?>
            </td>
        </tr>-->
        <tr>
            <td>
                Previsão de Entrega.: <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>
            </td>
            <td>
                Previsão de Entrega.: <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>

            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td>
                <table style="width:100%;">                
                    <td>Exame</td>
                    <td align="right">Valor</td>
                    <hr>
                </table>
            </td>
            <td>
                <table style="width:100%;">                
                    <td>Exame</td>
                    <td align="right">Valor</td>
                    <hr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td>
                <table style="width: 100%; font-size: 11pt;">

                    <?
                    $valor_total_ficha = 0;
                    $desconto_total = 0;
                    $cartao_total = 0;
                    foreach ($formapagamento as $value) {
                        $data[$value->nome] = 0;
                        $datacredito[$value->nome] = 0;
                        $numerocredito[$value->nome] = 0;
                        $descontocredito[$value->nome] = 0;
                        $numero[$value->nome] = 0;
                        $desconto[$value->nome] = 0;
                    }

//        var_dump($exames); die;
                    foreach ($exames as $item) :
                        $u = 0;



                        if ($item->grupo == $exame[0]->grupo) {
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor1;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {
                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento2 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor2;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento3 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor3;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento4 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor4;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }


                            $valor_total_ficha = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                            $desconto_total = $desconto_total + $item->desconto;
                            ?>
                            <tr>
                                <td ><?= $item->procedimento ?></td>                    
                                <td align="right">R$<?= number_format($item->valor_total * $item->quantidade, 2, ',', '.') ?></td>
                            </tr>
                            <?
                        }
                    endforeach;
                    ?>

                </table>
                <hr>
                Para sua segurança, não passamos resultado de exames por telefone.<br>
                TRAZER ESTA VIA PARA RECEBIMENTO DE EXAMES.
            </td>

            <td>
                <table style="width: 100%; font-size: 11pt;">

                    <?
                    $valor_total_ficha = 0;
                    $desconto_total = 0;
                    $cartao_total = 0;
                    foreach ($formapagamento as $value) {
//                        var_dump($formapagamento);die;
                        $data[$value->nome] = 0;
                        $datacredito[$value->nome] = 0;
                        $numerocredito[$value->nome] = 0;
                        $descontocredito[$value->nome] = 0;
                        $numero[$value->nome] = 0;
                        $desconto[$value->nome] = 0;
                    }

//        var_dump($exames); die;
                    foreach ($exames as $item) :
                        $u = 0;



                        if ($item->grupo == $exame[0]->grupo) {
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor1;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {
                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento2 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor2;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento3 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor3;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento4 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor4;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }


                            $valor_total_ficha = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                            $desconto_total = $desconto_total + $item->desconto;
                            ?>
                            <tr>
                                <td ><?= $item->procedimento ?></td>                    
                                <td align="right">R$<?= number_format($item->valor_total * $item->quantidade, 2, ',', '.') ?></td>
                            </tr>
                            <?
                        }
                    endforeach;
                    ?>

                </table>
    <hr>
    Para sua segurança, não passamos resultado de exames por telefone.<br>
                TRAZER ESTA VIA PARA RECEBIMENTO DE EXAMES.
            </td>
        </tr>
    </table>


</div>











