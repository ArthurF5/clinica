
<div class="content ficha_ceatox">
    <div>
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>internacao/internacao/gravarsaida" method="post" >
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$paciente[0]->paciente ?>" readonly/>
                </div>

                <div>
                    <label>Leito</label>
                    <input type="text"  name="leito" id="leito" class="texto09" value="<?= @$paciente[0]->leito; ?>" readonly/>
                    <input type="hidden"  name="leito_id" id="leito" class="texto09" value="<?= @$paciente[0]->leito_id; ?>" readonly/>
                    <input type="hidden"  name="internacao_id" id="leito" class="texto09" value="<?= @$paciente[0]->internacao_id; ?>" readonly/>
                    <input type="hidden"  name="ativo_internacao" id="ativo_internacao" class="texto09" value="<?= @$paciente[0]->ativo; ?>" readonly/>
                </div>


                <div>
                    <label>Data da Internacao</label>                      
                    <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= date("d/m/Y H:i:s", strtotime(@$paciente[0]->data_internacao)); ?>" readonly/>
                </div>
                <div>
                    <label>Médico Responsável Internação</label>                      
                    <input type="text" id="data_internacao" name="medico_responsavel"  class="texto09" value="<?= @$paciente[0]->medico; ?>" readonly/>
                </div>

                <div>
                    <label>Data de Nascimento</label>                      
                    <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>" readonly/>
                </div>

                <div>
                    <label>Sexo</label>
                    <input type="text" id="sexo" name="sexo"  class="texto09" value="<?
                    if (@$paciente[0]->sexo == "M"):echo 'Masculino';
                    endif;
                    if (@$paciente[0]->sexo == "F"):echo 'Feminino';
                    endif;
                    if (@$paciente[0]->sexo == "O"):echo 'Outro';
                    endif;
                    ?>" readonly/>
                </div> 

                <div>

                    <input type="hidden" id="txtidpaciente" name="idpaciente"  class="texto09" value="<?= @$paciente[0]->paciente_id ?>" readonly/>
                    <input type="hidden" id="txtidpaciente" name="internacao_id"  class="texto09" value="<?= @$paciente[0]->internacao_id ?>" readonly/>
                </div>
            </fieldset>

            <fieldset>
                <div>
                    <label>Medico</label>
                    <select name="medico_saida" id="medico_saida" class="size2" selected="<?= @$internacao[0]->forma_de_entrada; ?>" required>
                        <option value="">Selecione</option>   
                        <? foreach ($medicos as $item) { ?>
                            <option <?=(@$paciente[0]->medico_saida == $item->operador_id)? 'selected': '';?> value="<?= $item->operador_id ?>" ><?= $item->nome ?></option>   
                        <? }
                        ?>
                    </select>

                </div>
                <div>
                    <label>Data/hora ex.( 20/01/2010 14:30:21)</label>
                    <input type="text" required id="txtdata" class="texto04" name="data_saida" alt="39/19/9999 29:59:59" value="<?=(@$paciente[0]->data_saida != '')?date('d/m/Y H:i:s',strtotime(@$paciente[0]->data_saida)): '';?>" required/>
                </div>
                <div>
                    <label>Motivo de Saida</label>
                    <select name="motivosaida" required="">
                        <option value="">Selecione</option>
                        <? foreach (@$motivosaida as $item) { ?>
                        <option <?=(@$paciente[0]->motivo_saida == $item->internacao_motivosaida_id)? 'selected': '';?> onclick="document.getElementById('hospital').style.display = 'none', document.getElementById('labelhospital').style.display = 'none';" value="<?= $item->internacao_motivosaida_id ?>"><? echo $item->nome ?> </option>
                        <? } ?>
                        <option name="motivosaida" onclick="document.getElementById('hospital').style.display = 'inline', document.getElementById('labelhospital').style.display = 'inline';" value="transferencia" >Transferência</option>

                    </select>
                    <br>
                    <label id="labelhospital">Hospital da transferência</label>  
                    <br>
                    <input type="text" id="hospital" name="hospital"  class="texto09" value=""/>

                </div>
                <div>
                    <label>Observações</label>
                    <textarea cols="" rows="" name="observacao" id="txtobservacao" class="texto_area" value=""></textarea><br/>
                </div>
            </fieldset>

            <button onclick="javascript: return confirm('Deseja realmente aplicar saida ao paciente <?= @$paciente[0]->paciente ?>');" type="submit">Enviar</button>
            <button  type="reset">Limpar</button>
        </form>


    </div>
    <body onload="deixarOculto(), deixarOculto2();">
    </body>
    <div class="clear"></div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
<script>
        function deixarOculto() {
            document.getElementById('hospital').style.display = "none";
        }
</script>
<script>
    function deixarOculto2() {
        document.getElementById('labelhospital').style.display = "none";
    }
</script>
