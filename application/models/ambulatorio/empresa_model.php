<?php

class empresa_model extends Model {

    var $_empresa_id = null;
    var $_nome = null;
    var $_razao_social = null;
    var $_cnpj = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_municipio_id = null;
    var $_cep = null;
    var $_chat = null;
    var $_servicoemail = null;
    var $_servicosms = null;
    var $_cnes = null;
    var $_botao_faturar_guia = null;
    var $_botao_faturar_proc = null;

    function Empresa_model($exame_empresa_id = null) {
        parent::Model();
        if (isset($exame_empresa_id)) {
            $this->instanciar($exame_empresa_id);
        }
    }

    function listar($args = array()) {

        $perfil_id = $this->session->userdata('perfil_id');
//        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('empresa_id,
                            nome,
                            razao_social,
                            cnpj');
        $this->db->from('tb_empresa');
        if ($perfil_id != 1) {
            $this->db->where('empresa_id', $empresa_id);
        }
        $this->db->where('ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listartotensetor($args = array()) {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('ts.toten_setor_id,
                            ts.nome,
                            ts.sigla,
                            ts.toten_webService_id,
                            e.nome as empresa');
        $this->db->from('tb_toten_setor ts');
        $this->db->join('tb_empresa e', "e.empresa_id = ts.empresa_id", 'left');
        if ($operador_id != 1) {
            $this->db->where('empresa_id', $empresa_id);
        }
        $this->db->where('ts.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ts.nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarempresasativo() {

        $this->db->select('empresa_id,
            razao_social,
            producaomedicadinheiro,
            nome');
        $this->db->from('tb_empresa');
        $this->db->where("ativo", 't');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarlembretes($args = array()) {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(" el.empresa_lembretes_id,
                            el.texto,
                            el.perfil_destino,
                            el.operador_destino,
                            el.ativo,
                            o.nome as operador,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretes_visualizacao 
                                WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                            ) as visualizado");
        $this->db->from('tb_empresa_lembretes el');
        $this->db->join('tb_operador o', "o.operador_id = el.operador_destino");
        $this->db->where('el.empresa_id', $empresa_id);

        if (isset($args['texto']) && strlen(@$args['texto']) > 0) {
            $this->db->where('el.texto ilike', "%" . $args['texto'] . "%");
        }

        if (@$args['operador_id'] != '') {
            $this->db->where('el.operador_destino', $args['operador_id']);
        }

        if (@$args['perfil_id'] != '') {
            $this->db->where('el.perfil_destino', $args['perfil_id']);
        }

        return $this->db;
    }

    function listarnumeroindentificacaosms() {

        $this->db->select('nome_empresa, numero_indentificacao');
        $this->db->from('tb_empresas_indentificacao_sms');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressao() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_cabecalho_id,ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_cabecalho ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        return $this->db;
    }

    function listarconfiguracaoimpressaolaudo() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_laudo_id,ei.nome as nome_laudo, ei.cabecalho,ei.ativo,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_laudo ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        return $this->db;
    }

    function listarconfiguracaoimpressaolaudoform($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_laudo_id, ei.nome as nome_laudo,ei.texto,ei.adicional_cabecalho, ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_laudo ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_laudo_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaointernacao() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_internacao_id,ei.nome as nome_internacao, ei.cabecalho,ei.ativo,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_internacao ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
        $this->db->where('ei.ativo', 't');
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        return $this->db;
    }

    function listarconfiguracaoimpressaointernacaoform($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_internacao_id, ei.nome as nome_internacao,ei.texto,ei.adicional_cabecalho, ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_internacao ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_internacao_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaoorcamento() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_orcamento_id,ei.nome as nome_orcamento, ei.cabecalho,ei.ativo,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_orcamento ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        return $this->db;
    }

    function listarconfiguracaoimpressaorecibo() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_recibo_id,ei.nome as nome_recibo, ei.cabecalho,ei.ativo,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_recibo ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        return $this->db;
    }

    function listarconfiguracaoimpressaoorcamentoform($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_orcamento_id, ei.nome as nome_orcamento,ei.texto, ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_orcamento ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_orcamento_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaoreciboform($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_recibo_id, ei.repetir_recibo, ei.nome as nome_recibo,ei.texto, ei.cabecalho,ei.rodape, e.nome as empresa, linha_procedimento');
        $this->db->from('tb_empresa_impressao_recibo ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_recibo_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaoencaminhamento() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_encaminhamento_id,ei.nome as nome_encaminhamento, ei.cabecalho,ei.ativo,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_encaminhamento ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        return $this->db;
    }

    function listarconfiguracaoimpressaoencaminhamentoform($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_encaminhamento_id, ei.nome as nome_encaminhamento,ei.texto, ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_encaminhamento ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_encaminhamento_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaocabecalho($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_cabecalho_id,ei.cabecalho,ei.rodape,ei.timbrado, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_cabecalho ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_cabecalho_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function pacotesms() {

        $this->db->select('descricao_pacote, pacote_sms_id');
        $this->db->from('tb_pacote_sms');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacs() {

        $this->db->select('*');
        $this->db->from('tb_pacs');
//        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_empresa_id,
                            nome, tipo');
        $this->db->from('tb_exame_empresa');
        $this->db->orderby('nome');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresatoten() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('endereco_toten,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->orderby('nome');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresasprocedimento() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');

        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacaolembrete($empresa_id) {
//        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('texto');
        $this->db->from('tb_empresa_lembretes_aniversario');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarinformacaoemail($empresa_id) {
//        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' email_mensagem_confirmacao,
                            email_mensagem_agradecimento,
                            email_mensagem_falta');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacaosms($empresa_id) {
//        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' pacote_id,
                            empresa_sms_id,
                            numero_indentificacao_sms,
                            enviar_excedentes,
                            endereco_externo,
                            remetente_sms,
                            mensagem_revisao, 
                            mensagem_confirmacao, 
                            mensagem_agradecimento,
                            mensagem_aniversariante');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresamunicipio() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.razao_social,
                            e.logradouro,
                            e.numero,
                            e.nome,
                            m.nome as municipio,
                            e.bairro');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaripservidor() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('');
        $this->db->from('tb_empresas_acesso_servidores');
//        $this->db->where('empresa_id', $empresa_id);
//        $this->db->where('ativo', 't');
//        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }

    function buscandolembreteoperador() {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('empresa_lembretes_id,
                            texto,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretes_visualizacao 
                                WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                                AND ponto.tb_empresa_lembretes_visualizacao.operador_visualizacao = ' . $operador_id . '
                            ) as visualizado');
        $this->db->from('tb_empresa_lembretes el');
        $this->db->where('ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
    }
    
    function buscandolembreteaniversariooperador() {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('empresa_lembretes_aniversario_id,
                            texto,
                            aniversario,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretesaniv_visualizacao 
                                WHERE ponto.tb_empresa_lembretesaniv_visualizacao.empresa_lembretes_aniversario_id = ela.empresa_lembretes_aniversario_id 
                                AND ponto.tb_empresa_lembretesaniv_visualizacao.operador_visualizacao = ' . $operador_id . '
                            ) as visualizado');
        $this->db->from('tb_empresa_lembretes_aniversario ela');
        $this->db->where('ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('aniversario is not null');
        $this->db->orderby('visualizado');
        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
    }

    function visualizalembrete() {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");

        $this->db->set('empresa_lembretes_id', $_GET['lembretes_id']);
        $this->db->set('data_visualizacao', $horario);
        $this->db->set('operador_visualizacao', $operador_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->insert('tb_empresa_lembretes_visualizacao');
    }
    
    function visualizalembreteaniv() {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");

        $this->db->set('empresa_lembretes_aniversario_id', $_GET['lembretes_id']);
        $this->db->set('data_visualizacao', $horario);
        $this->db->set('operador_visualizacao', $operador_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->insert('tb_empresa_lembretesaniv_visualizacao');
    }

    function listarempresa($empresa_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_empresa_id,
                            nome,
                            impressao_orcamento,
                            tipo');
        $this->db->from('tb_exame_empresa');
        $this->db->where('exame_empresa_id', $empresa_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirlembrete($empresa_lembretes_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_lembretes_id', $empresa_lembretes_id);
        $this->db->update('tb_empresa_lembretes');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function ativarconfiguracaolaudo($impressao_id) {
//        var_dump($impressao_id); die;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_impressao_laudo_id', $impressao_id);
        $this->db->update('tb_empresa_impressao_laudo');


        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_impressao_laudo_id !=', $impressao_id);
        $this->db->update('tb_empresa_impressao_laudo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirconfiguracaointernacao($impressao_id) {
//        var_dump($impressao_id); die;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_impressao_internacao_id', $impressao_id);
        $this->db->update('tb_empresa_impressao_internacao');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function ativarconfiguracaoorcamento($impressao_id) {
//        var_dump($impressao_id); die;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_impressao_orcamento_id', $impressao_id);
        $this->db->update('tb_empresa_impressao_orcamento');


        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_impressao_orcamento_id !=', $impressao_id);
        $this->db->update('tb_empresa_impressao_orcamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($exame_empresa_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_empresa_id', $exame_empresa_id);
        $this->db->update('tb_exame_empresa');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarlembrete($empresa_lembretes_id) {
        
        $this->db->select('operador_id, nome, perfil_id');
        $this->db->from('tb_operador o');
        if(!in_array('TODOS', $_POST['perfil_id'])){
        $this->db->where_in('perfil_id', $_POST['perfil_id']);
        }
        if(!in_array('TODOS', $_POST['operador_id'])){
        $this->db->where_in('operador_id', $_POST['operador_id']);
        }
        $this->db->where('o.ativo', 't');
        $this->db->where('o.usuario IS NOT NULL');
        $return = $this->db->get()->result();
//
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
//        
//        echo'<pre>';
//        var_dump($return);die;        
        
            foreach ($return as $value) {
                if ($empresa_lembretes_id == "" || $empresa_lembretes_id == "0") {// insert
                    $this->db->set('texto', $_POST['descricao']);
                    $this->db->set('operador_destino', $value->operador_id);
                    $this->db->set('perfil_destino', $value->perfil_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_empresa_lembretes');
                } else { // update
                    $this->db->set('texto', $_POST['descricao']);
                    $this->db->set('operador_destino', $value->operador_id);
                    $this->db->set('perfil_destino', $value->perfil_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('empresa_lembretes_id', $empresa_lembretes_id);
                    $this->db->update('tb_empresa_lembretes');
                }
            }
        
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }
    
    function gravarlembreteaniversario($empresa_lembretes_aniversario_id) {
        
        $this->db->select('operador_id, nome, perfil_id, nascimento');
        $this->db->from('tb_operador o');

        $this->db->where('o.ativo', 't');
        $this->db->where('o.usuario IS NOT NULL');
        $return = $this->db->get()->result();
        
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
      
//        echo'<pre>';
//        var_dump($return);die;        
        
            foreach ($return as $value) {
                if ($empresa_lembretes_aniversario_id == "" || $empresa_lembretes_aniversario_id == "0") {// insert
                    $this->db->set('texto', $_POST['aniversario']);
                    $this->db->set('operador_destino', $value->operador_id);
                    $this->db->set('perfil_destino', $value->perfil_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('aniversario', $value->nascimento);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_empresa_lembretes_aniversario');
                } else { // update
                    $this->db->set('texto', $_POST['aniversario']);
                    $this->db->set('operador_destino', $value->operador_id);
                    $this->db->set('perfil_destino', $value->perfil_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('aniversario', $value->nascimento);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('empresa_lembretes_aniversario_id', $empresa_lembretes_aniversario_id);
                    $this->db->update('tb_empresa_lembretes_aniversario');
                }
            }
        
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarconfiguracaoimpressao() {
        try {
//            var_dump($_POST['impressao_id']); die;
            /* inicia o mapeamento no banco */
            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ei.empresa_impressao_cabecalho_id,');
            $this->db->from('tb_empresa_impressao_cabecalho ei');
            $this->db->where('ei.empresa_id', $empresa_id);
            $teste = $this->db->get()->result();
            if (count($teste) > 0) {
                $impressao_id = $teste[0]->empresa_impressao_cabecalho_id;
            }

            if (count($teste) == 0) {
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('timbrado', $_POST['timbrado']);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_impressao_cabecalho');
            } else {
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('timbrado', $_POST['timbrado']);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('empresa_impressao_cabecalho_id', $impressao_id);
                $this->db->update('tb_empresa_impressao_cabecalho');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarconfiguracaoimpressaoorcamento() {
        try {
//            var_dump($_POST['impressao_id']); die;
            /* inicia o mapeamento no banco */
            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ei.empresa_impressao_orcamento_id,');
            $this->db->from('tb_empresa_impressao_orcamento ei');
            $this->db->where('ei.empresa_impressao_orcamento_id', $_POST['impressao_id']);
            $teste = $this->db->get()->result();
            $this->db->select('ei.empresa_impressao_orcamento_id,');
            $this->db->from('tb_empresa_impressao_orcamento ei');
            $this->db->where('ei.empresa_id', $empresa_id);
            $teste2 = $this->db->get()->result();
            if (count($teste) > 0) {
                $impressao_id = $teste[0]->empresa_impressao_orcamento_id;
            }

            if (count($teste) == 0) {
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('empresa_id', $empresa_id);
                if (count($teste2) > 0) {
                    $this->db->set('ativo', 'f');
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_impressao_orcamento');
            } else {
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('empresa_impressao_orcamento_id', $impressao_id);
                $this->db->update('tb_empresa_impressao_orcamento');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarconfiguracaoimpressaorecibo() {
        try {
//            var_dump($_POST['impressao_id']); die;
            /* inicia o mapeamento no banco */
            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ei.empresa_impressao_recibo_id,');
            $this->db->from('tb_empresa_impressao_recibo ei');
            $this->db->where('ei.empresa_impressao_recibo_id', $_POST['impressao_id']);
            $teste = $this->db->get()->result();
            $this->db->select('ei.empresa_impressao_recibo_id,');
            $this->db->from('tb_empresa_impressao_recibo ei');
            $this->db->where('ei.empresa_id', $empresa_id);
            $teste2 = $this->db->get()->result();
            if (count($teste) > 0) {
                $impressao_id = $teste[0]->empresa_impressao_recibo_id;
            }
//            var_dump($_POST); die;
            if (count($teste) == 0) {
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('linha_procedimento', $_POST['linha_procedimento']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                if ($_POST['repetir_recibo'] > 0) {
                    $this->db->set('repetir_recibo', $_POST['repetir_recibo']);
                }
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('empresa_id', $empresa_id);
                if (count($teste2) > 0) {
                    $this->db->set('ativo', 'f');
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_impressao_recibo');
            } else {
                $this->db->set('nome', $_POST['nome']);
                if ($_POST['repetir_recibo'] > 0) {
                    $this->db->set('repetir_recibo', $_POST['repetir_recibo']);
                }
                $this->db->set('linha_procedimento', $_POST['linha_procedimento']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('empresa_impressao_recibo_id', $impressao_id);
                $this->db->update('tb_empresa_impressao_recibo');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarconfiguracaoimpressaolaudo() {
        try {
//            var_dump($_POST['impressao_id']); die;
            /* inicia o mapeamento no banco */
            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ei.empresa_impressao_laudo_id,');
            $this->db->from('tb_empresa_impressao_laudo ei');
            $this->db->where('ei.empresa_impressao_laudo_id', $_POST['impressao_id']);
            $teste = $this->db->get()->result();
            $this->db->select('ei.empresa_impressao_laudo_id,');
            $this->db->from('tb_empresa_impressao_laudo ei');
            $this->db->where('ei.empresa_id', $empresa_id);
            $teste2 = $this->db->get()->result();
            if (count($teste) > 0) {
                $impressao_id = $teste[0]->empresa_impressao_laudo_id;
            }

            if (count($teste) == 0) {
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('adicional_cabecalho', $_POST['adicional_cabecalho']);
                $this->db->set('empresa_id', $empresa_id);
                if (count($teste2) > 0) {
                    $this->db->set('ativo', 'f');
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_impressao_laudo');
            } else {
                $this->db->set('adicional_cabecalho', $_POST['adicional_cabecalho']);
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('empresa_impressao_laudo_id', $impressao_id);
                $this->db->update('tb_empresa_impressao_laudo');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarconfiguracaoimpressaointernacao() {
        try {
//            var_dump($_POST['impressao_id']); die;
            /* inicia o mapeamento no banco */
            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ei.empresa_impressao_internacao_id,');
            $this->db->from('tb_empresa_impressao_internacao ei');
            $this->db->where('ei.empresa_impressao_internacao_id', $_POST['impressao_id']);
            $teste = $this->db->get()->result();

            if (count($teste) > 0) {
                $impressao_id = $teste[0]->empresa_impressao_internacao_id;
            }

            if (count($teste) == 0) {
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('adicional_cabecalho', $_POST['adicional_cabecalho']);
                $this->db->set('empresa_id', $empresa_id);

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_impressao_internacao');
            } else {
                $this->db->set('adicional_cabecalho', $_POST['adicional_cabecalho']);
                $this->db->set('nome', $_POST['nome']);
                $this->db->set('cabecalho', $_POST['cabecalho']);
                $this->db->set('rodape', $_POST['rodape']);
                $this->db->set('texto', $_POST['texto']);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('empresa_impressao_internacao_id', $impressao_id);
                $this->db->update('tb_empresa_impressao_internacao');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravaripservidor($servidor_id) {

        $this->db->set('ip_externo', $_POST['ipservidor']);
        $this->db->set('nome_clinica', $_POST['nome_clinica']);
        $this->db->insert('tb_empresas_acesso_servidores');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluiripservidor($servidor_id) {

        $this->db->where('empresas_acesso_externo_id', $servidor_id);
        $this->db->delete('tb_empresas_acesso_servidores');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirempresa($servidor_id) {
        $this->db->set('ativo', 'f');
        $this->db->where('empresa_id', $servidor_id);
        $this->db->update('tb_empresa');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarlogomarca() {
        try {
            if (isset($_POST['mostrarLogo'])) {
                $this->db->set('mostrar_logo_clinica', 't');
            } else {
                $this->db->set('mostrar_logo_clinica', 'f');
            }
            $this->db->where('empresa_id', $_POST['empresa_id']);
            $this->db->update('tb_empresa');

            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconfiguracaoemail() {
        try {
//            var_dump($_POST['empresa_id']); die;

            $this->db->set('email_mensagem_confirmacao', $_POST['lembr']);
            $this->db->set('email_mensagem_agradecimento', $_POST['agrade']);
            $this->db->set('email_mensagem_falta', $_POST['falta']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->where('empresa_id', $_POST['empresa_id']);
            $this->db->update('tb_empresa');
            $empresa_id = $_POST['empresa_id'];

            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconfiguracaosms() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('pacote_id', $_POST['txtpacote']);
            $this->db->set('empresa_id', $_POST['empresa_id']);
            $this->db->set('endereco_externo', $_POST['endereco_externo']);
            $this->db->set('numero_indentificacao_sms', $_POST['numero_identificacao_sms']);

            if (isset($_POST['msgensExcedentes'])) {
                $this->db->set('enviar_excedentes', 't');
            } else {
                $this->db->set('enviar_excedentes', 'f');
            }

            $this->db->set('remetente_sms', $_POST['remetente_sms']);
            $this->db->set('mensagem_confirmacao', $_POST['txtMensagemConfirmacao']);
            $this->db->set('mensagem_agradecimento', $_POST['txtMensagemAgradecimento']);
            $this->db->set('mensagem_aniversariante', $_POST['txtMensagemAniversariantes']);
            $this->db->set('mensagem_revisao', $_POST['txtMensagemRevisao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['sms_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_sms');
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);

                $sms_id = $_POST['sms_id'];

                $this->db->where('empresa_sms_id', $sms_id);
                $this->db->update('tb_empresa_sms');
            }
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconfiguracaopacs() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('empresa_id', $_POST['empresa_id']);
//            $this->db->set('pacote_id', $_POST['txtpacote']);
//            if(isset($_POST['msgensExcedentes'])){
//                $this->db->set('enviar_excedentes', 't');
//            }
//            else{
//                $this->db->set('enviar_excedentes', 'f');
//            }
            $this->db->set('ip_local', $_POST['ip_local']);
            $this->db->set('ip_externo', $_POST['ip_externo']);
            $this->db->set('login', $_POST['login']);
            $this->db->set('senha', $_POST['senha']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['pacs_id'] == "") {// insert
//                $this->db->set('data_cadastro', $horario);
//                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_pacs');
            } else { // update
//                $this->db->set('data_atualizacao', $horario);
//                $this->db->set('operador_atualizacao', $operador_id);
                $pacs_id = $_POST['pacs_id'];

                $this->db->where('pacs_id', $pacs_id);
                $this->db->update('tb_pacs');
            }
//            echo 'something';
//            die;
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
//            echo'<pre>';
//            var_dump($_POST);
//            die;
            // Ativando/Desativando o Crédito
            if (isset($_POST['credito'])) {
                $this->db->set('ativo', 't');
                $this->db->where('forma_pagamento_id', 1000);
                $this->db->update('tb_forma_pagamento');
            } else {
                $this->db->set('ativo', 'f');
                $this->db->where('forma_pagamento_id', 1000);
                $this->db->update('tb_forma_pagamento');
            }
            $operador_id = $this->session->userdata('operador_id');
            /* inicia o mapeamento no banco */
            
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('razao_socialxml', $_POST['txtrazaosocialxml']);
            $this->db->set('cep', $_POST['CEP']);
            $this->db->set('cnes', $_POST['txtCNES']);
            $this->db->set('email', $_POST['email']);
            $this->db->set('endereco_integracao_lab', $_POST['endereco_integracao_lab']);
            $this->db->set('identificador_lis', $_POST['identificador_lis']);
            $this->db->set('origem_lis', $_POST['origem_lis']);


            if ($operador_id == 1) {

                if ($_POST['impressao_tipo'] != "") {
                    $this->db->set('impressao_tipo', $_POST['impressao_tipo']);
                } else {
                    $this->db->set('impressao_tipo', null);
                }
                if ($_POST['impressao_orcamento'] != "") {
                    $this->db->set('impressao_orcamento', $_POST['impressao_orcamento']);
                } else {
                    $this->db->set('impressao_orcamento', null);
                }

                if ($_POST['horSegSexta_i'] != "") {
                    $this->db->set('horario_seg_sex_inicio', $_POST['horSegSexta_i']);
                }
                if ($_POST['horSegSexta_f'] != "") {
                    $this->db->set('horario_seg_sex_fim', $_POST['horSegSexta_f']);
                }
                if ($_POST['horSegSexta_i'] != "" || $_POST['horSegSexta_f'] != "") {
                    $this->db->set('horario_seg_sex', $_POST['horSegSexta_i'] . " às " . $_POST['horSegSexta_f'] . " hr(s)");
                }

                if ($_POST['horSab_i'] != "") {
                    $this->db->set('horario_sab_inicio', $_POST['horSab_i']);
                }
                if ($_POST['horSab_f'] != "") {
                    $this->db->set('horario_sab_fim', $_POST['horSab_f']);
                }
                if ($_POST['horSab_i'] != "" || $_POST['horSab_f'] != "") {
                    $this->db->set('horario_sab', $_POST['horSab_i'] . " às " . $_POST['horSab_f'] . " hr(s)");
                }

                if ($_POST['impressao_laudo'] != "") {
                    $this->db->set('impressao_laudo', $_POST['impressao_laudo']);
                } else {
                    $this->db->set('impressao_laudo', null);
                }
                if ($_POST['impressao_recibo'] != "") {
                    $this->db->set('impressao_recibo', $_POST['impressao_recibo']);
                } else {
                    $this->db->set('impressao_recibo', null);
                }
                if ($_POST['numero_empresa_painel'] != "") {
                    $this->db->set('numero_empresa_painel', (int) $_POST['numero_empresa_painel']);
                }
                if ($_POST['impressao_declaracao'] != "") {
                    $this->db->set('impressao_declaracao', $_POST['impressao_declaracao']);
                } else {
                    $this->db->set('impressao_declaracao', null);
                }
                if ($_POST['impressao_internacao'] != "") {
                    $this->db->set('impressao_internacao', $_POST['impressao_internacao']);
                } else {
                    $this->db->set('impressao_internacao', null);
                }
            }

            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ']))));
            }
            if ($_POST['txtCNPJxml'] != '') {
                $this->db->set('cnpjxml', str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJxml']))));
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);

            $this->db->set('endereco_upload', $_POST['endereco_upload']);
            if ($operador_id == 1) {
                if (isset($_POST['sms'])) {
                    $this->db->set('servicosms', 't');
                } else {
                    $this->db->set('servicosms', 'f');
                }
                if (isset($_POST['servicoemail'])) {
                    $this->db->set('servicoemail', 't');
                } else {
                    $this->db->set('servicoemail', 'f');
                }
                if (isset($_POST['chat'])) {
                    $this->db->set('chat', 't');
                } else {
                    $this->db->set('chat', 'f');
                }
                if (isset($_POST['farmacia'])) {
                    $this->db->set('farmacia', 't');
                } else {
                    $this->db->set('farmacia', 'f');
                }
                if (isset($_POST['imagem'])) {
                    $this->db->set('imagem', 't');
                } else {
                    $this->db->set('imagem', 'f');
                }
                if (isset($_POST['fila_caixa'])) {
//                var_dump($_POST['fila_caixa']);die;
                    $this->db->set('caixa', 't');
                } else {
                    $this->db->set('caixa', 'f');
                }
                if (isset($_POST['data_contaspagar'])) {
                    $this->db->set('data_contaspagar', 't');
                } else {
                    $this->db->set('data_contaspagar', 'f');
                }
                if (isset($_POST['medico_laudodigitador'])) {
                    $this->db->set('medico_laudodigitador', 't');
                } else {
                    $this->db->set('medico_laudodigitador', 'f');
                }
                if (isset($_POST['chamar_consulta'])) {
                    $this->db->set('chamar_consulta', 't');
                } else {
                    $this->db->set('chamar_consulta', 'f');
                }
                if (isset($_POST['procedimentos_multiempresa'])) {
                    $this->db->set('procedimento_multiempresa', 't');
                } else {
                    $this->db->set('procedimento_multiempresa', 'f');
                }

                if (isset($_POST['consulta'])) {
                    $this->db->set('consulta', 't');
                } else {
                    $this->db->set('consulta', 'f');
                }
                if (isset($_POST['especialidade'])) {
                    $this->db->set('especialidade', 't');
                } else {
                    $this->db->set('especialidade', 'f');
                }
                if (isset($_POST['odontologia'])) {
                    $this->db->set('odontologia', 't');
                } else {
                    $this->db->set('odontologia', 'f');
                }
                if (isset($_POST['laboratorio'])) {
                    $this->db->set('laboratorio', 't');
                } else {
                    $this->db->set('laboratorio', 'f');
                }
                if (isset($_POST['geral'])) {
                    $this->db->set('geral', 't');
                } else {
                    $this->db->set('geral', 'f');
                }
                if (isset($_POST['faturamento'])) {
                    $this->db->set('faturamento', 't');
                } else {
                    $this->db->set('faturamento', 'f');
                }
                if (isset($_POST['estoque'])) {
                    $this->db->set('estoque', 't');
                } else {
                    $this->db->set('estoque', 'f');
                }
                if (isset($_POST['financeiro'])) {
                    $this->db->set('financeiro', 't');
                } else {
                    $this->db->set('financeiro', 'f');
                }
                if (isset($_POST['marketing'])) {
                    $this->db->set('marketing', 't');
                } else {
                    $this->db->set('marketing', 'f');
                }
                if (isset($_POST['internacao'])) {
                    $this->db->set('internacao', 't');
                } else {
                    $this->db->set('internacao', 'f');
                }
                if (isset($_POST['centro_cirurgico'])) {
                    $this->db->set('centrocirurgico', 't');
                } else {
                    $this->db->set('centrocirurgico', 'f');
                }
                if (isset($_POST['ponto'])) {
                    $this->db->set('ponto', 't');
                } else {
                    $this->db->set('ponto', 'f');
                }
                if (isset($_POST['calendario'])) {
                    $this->db->set('calendario', 't');
                } else {
                    $this->db->set('calendario', 'f');
                }
                if (isset($_POST['botao_faturar_guia'])) {
                    $this->db->set('botao_faturar_guia', 't');
                } else {
                    $this->db->set('botao_faturar_guia', 'f');
                }
                if (isset($_POST['botao_faturar_proc'])) {
                    $this->db->set('botao_faturar_procedimento', 't');
                } else {
                    $this->db->set('botao_faturar_procedimento', 'f');
                }
                if (isset($_POST['producao_medica_saida'])) {
                    $this->db->set('producao_medica_saida', 't');
                } else {
                    $this->db->set('producao_medica_saida', 'f');
                }
                if (isset($_POST['cabecalho_config'])) {
                    $this->db->set('cabecalho_config', 't');
                } else {
                    $this->db->set('cabecalho_config', 'f');
                }
                if (isset($_POST['rodape_config'])) {
                    $this->db->set('rodape_config', 't');
                } else {
                    $this->db->set('rodape_config', 'f');
                }
                if (isset($_POST['laudo_config'])) {
                    $this->db->set('laudo_config', 't');
                } else {
                    $this->db->set('laudo_config', 'f');
                }
                if (isset($_POST['recibo_config'])) {
                    $this->db->set('recibo_config', 't');
                } else {
                    $this->db->set('recibo_config', 'f');
                }
                if (isset($_POST['ficha_config'])) { // Ficha
                    $this->db->set('ficha_config', 't');
                } else {
                    $this->db->set('ficha_config', 'f');
                }
                if (isset($_POST['declaracao_config'])) { // Declaracao
                    $this->db->set('declaracao_config', 't');
                } else {
                    $this->db->set('declaracao_config', 'f');
                }
                if (isset($_POST['atestado_config'])) { // Atestado
                    $this->db->set('atestado_config', 't');
                } else {
                    $this->db->set('atestado_config', 'f');
                }
            }
            $horario = date("Y-m-d H:i:s");


            $perfil_id = $this->session->userdata('perfil_id');
            if ($_POST['txtempresaid'] == "") {// insert
                $this->db->set('endereco_externo', $_POST['endereco_externo']);
                $this->db->set('endereco_toten', $_POST['endereco_toten']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa');
                $empresa_id = $this->db->insert_id();
                if ($operador_id == 1) {
                    if (isset($_POST['procedimento_excecao'])) {
                        $this->db->set('procedimento_excecao', 't');
                    } else {
                        $this->db->set('procedimento_excecao', 'f');
                    }
                    if (isset($_POST['ordem_chegada'])) {
                        $this->db->set('ordem_chegada', 't');
                    } else {
                        $this->db->set('ordem_chegada', 'f');
                    }
                    if (isset($_POST['encaminhamento_email'])) {
                        $this->db->set('encaminhamento_email', 't');
                    } else {
                        $this->db->set('encaminhamento_email', 'f');
                    }
                    if (isset($_POST['valor_convenio_nao'])) {
                        $this->db->set('valor_convenio_nao', 't');
                    } else {
                        $this->db->set('valor_convenio_nao', 'f');
                    }
                    if (count($_POST['campos_obrigatorio']) > 0) {
                        $this->db->set('campos_cadastro', json_encode($_POST['campos_obrigatorio']));
                    } else {
                        $this->db->set('campos_cadastro', '');
                    }
                    if (count($_POST['opc_telatendimento']) > 0) {
                        $this->db->set('campos_atendimentomed', json_encode($_POST['opc_telatendimento']));
                    } else {
                        $this->db->set('campos_atendimentomed', '');
                    }
                    if (count($_POST['opc_dadospaciente']) > 0) {
                        $this->db->set('dados_atendimentomed', json_encode($_POST['opc_dadospaciente']));
                    } else {
                        $this->db->set('dados_atendimentomed', '');
                    }
                    if (isset($_POST['valor_autorizar'])) {
                        $this->db->set('valor_autorizar', 't');
                    } else {
                        $this->db->set('valor_autorizar', 'f');
                    }
                    if (isset($_POST['gerente_recepcao_top_saude'])) {
                        $this->db->set('gerente_recepcao_top_saude', 't');
                    } else {
                        $this->db->set('gerente_recepcao_top_saude', 'f');
                    }
                    if (isset($_POST['agenda_modelo2'])) {
                        $this->db->set('agenda_modelo2', 't');
                    } else {
                        $this->db->set('agenda_modelo2', 'f');
                    }
                    if (isset($_POST['orcamento_multiplo'])) {
                        $this->db->set('orcamento_multiplo', 't');
                    } else {
                        $this->db->set('orcamento_multiplo', 'f');
                    }
                    if (isset($_POST['modelo_laudo_medico'])) {
                        $this->db->set('modelo_laudo_medico', 't');
                    } else {
                        $this->db->set('modelo_laudo_medico', 'f');
                    }
                    if (isset($_POST['autorizar_sala_espera'])) {
                        $this->db->set('autorizar_sala_espera', 't');
                    } else {
                        $this->db->set('autorizar_sala_espera', 'f');
                    }
                    if (isset($_POST['profissional_agendar'])) {
                        $this->db->set('profissional_agendar', 't');
                    } else {
                        $this->db->set('profissional_agendar', 'f');
                    }
                    if (isset($_POST['profissional_externo'])) {
                        $this->db->set('profissional_externo', 't');
                    } else {
                        $this->db->set('profissional_externo', 'f');
                    }
                    if (isset($_POST['conjuge'])) {
                        $this->db->set('conjuge', 't');
                    } else {
                        $this->db->set('conjuge', 'f');
                    }
                    if (isset($_POST['producao_alternativo'])) {
                        $this->db->set('producao_alternativo', 't');
                    } else {
                        $this->db->set('producao_alternativo', 'f');
                    }
                    if (isset($_POST['gerente_cancelar'])) {
                        $this->db->set('gerente_cancelar', 't');
                    } else {
                        $this->db->set('gerente_cancelar', 'f');
                    }
                    if (isset($_POST['reservar_escolher_proc'])) {
                        $this->db->set('reservar_escolher_proc', 't');
                    } else {
                        $this->db->set('reservar_escolher_proc', 'f');
                    }
                    if (isset($_POST['valor_laboratorio'])) {
                        $this->db->set('valor_laboratorio', 't');
                    } else {
                        $this->db->set('valor_laboratorio', 'f');
                    }
                    if (isset($_POST['gerente_contasapagar'])) {
                        $this->db->set('gerente_contasapagar', 't');
                    } else {
                        $this->db->set('gerente_contasapagar', 'f');
                    }
                    if (isset($_POST['gerente_relatorio_financeiro'])) {
                        $this->db->set('gerente_relatorio_financeiro', 't');
                    } else {
                        $this->db->set('gerente_relatorio_financeiro', 'f');
                    }
                    if (isset($_POST['botao_imagem_paciente'])) {
                        $this->db->set('botao_imagem_paciente', 't');
                    } else {
                        $this->db->set('botao_imagem_paciente', 'f');
                    }
                    if (isset($_POST['botao_arquivos_paciente'])) {
                        $this->db->set('botao_arquivos_paciente', 't');
                    } else {
                        $this->db->set('botao_arquivos_paciente', 'f');
                    }
                    if (isset($_POST['botao_laudo_paciente'])) {
                        $this->db->set('botao_laudo_paciente', 't');
                    } else {
                        $this->db->set('botao_laudo_paciente', 'f');
                    }
                    if (isset($_POST['cpf_obrigatorio'])) {
                        $this->db->set('cpf_obrigatorio', 't');
                    } else {
                        $this->db->set('cpf_obrigatorio', 'f');
                    }
                    if (isset($_POST['subgrupo'])) {
                        $this->db->set('subgrupo', 't');
                    } else {
                        $this->db->set('subgrupo', 'f');
                    }
                    if (isset($_POST['orcamento_recepcao'])) {
                        $this->db->set('orcamento_recepcao', 't');
                    } else {
                        $this->db->set('orcamento_recepcao', 'f');
                    }
                    if (isset($_POST['relatorio_ordem'])) {
                        $this->db->set('relatorio_ordem', 't');
                    } else {
                        $this->db->set('relatorio_ordem', 'f');
                    }
                    if (isset($_POST['desativar_taxa_administracao'])) {
                        $this->db->set('desativar_taxa_administracao', 't');
                    } else {
                        $this->db->set('desativar_taxa_administracao', 'f');
                    }
                    if (isset($_POST['relatorio_producao'])) {
                        $this->db->set('relatorio_producao', 't');
                    } else {
                        $this->db->set('relatorio_producao', 'f');
                    }
                    if (isset($_POST['relatorios_recepcao'])) {
                        $this->db->set('relatorios_recepcao', 't');
                    } else {
                        $this->db->set('relatorios_recepcao', 'f');
                    }
                    if (isset($_POST['manter_indicacao'])) {
                        $this->db->set('manter_indicacao', 't');
                    } else {
                        $this->db->set('manter_indicacao', 'f');
                    }
                    if (isset($_POST['faturamento_novo'])) {
                        $this->db->set('faturamento_novo', 't');
                    } else {
                        $this->db->set('faturamento_novo', 'f');
                    }

                    if (isset($_POST['fila_impressao'])) {
                        $this->db->set('fila_impressao', 't');
                    } else {
                        $this->db->set('fila_impressao', 'f');
                    }
                    if (isset($_POST['medico_solicitante'])) {
                        $this->db->set('medico_solicitante', 't');
                    } else {
                        $this->db->set('medico_solicitante', 'f');
                    }
                    if (isset($_POST['relatorio_operadora'])) {
                        $this->db->set('relatorio_operadora', 't');
                    } else {
                        $this->db->set('relatorio_operadora', 'f');
                    }
                    if (isset($_POST['relatorio_rm'])) {
                        $this->db->set('relatorio_rm', 't');
                    } else {
                        $this->db->set('relatorio_rm', 'f');
                    }
                    if (isset($_POST['relatorio_caixa'])) {
                        $this->db->set('relatorio_caixa', 't');
                    } else {
                        $this->db->set('relatorio_caixa', 'f');
                    }
                    if (isset($_POST['relatorio_demandagrupo'])) {
                        $this->db->set('relatorio_demandagrupo', 't');
                    } else {
                        $this->db->set('relatorio_demandagrupo', 'f');
                    }
                    if (isset($_POST['uso_salas'])) {
                        $this->db->set('uso_salas', 't');
                    } else {
                        $this->db->set('uso_salas', 'f');
                    }
                    if (isset($_POST['enfermagem'])) {
                        $this->db->set('enfermagem', 't');
                    } else {
                        $this->db->set('enfermagem', 'f');
                    }
                    if (isset($_POST['integracaosollis'])) {
                        $this->db->set('integracaosollis', 't');
                    } else {
                        $this->db->set('integracaosollis', 'f');
                    }
                    if (isset($_POST['medicinadotrabalho'])) {
                        $this->db->set('medicinadotrabalho', 't');
                    } else {
                        $this->db->set('medicinadotrabalho', 'f');
                    }
                    if (isset($_POST['ocupacao_mae'])) {
                        $this->db->set('ocupacao_mae', 't');
                    } else {
                        $this->db->set('ocupacao_mae', 'f');
                    }
                    if (isset($_POST['ocupacao_pai'])) {
                        $this->db->set('ocupacao_pai', 't');
                    } else {
                        $this->db->set('ocupacao_pai', 'f');
                    }
                    if (isset($_POST['limitar_acesso'])) {
                        $this->db->set('limitar_acesso', 't');
                    } else {
                        $this->db->set('limitar_acesso', 'f');
                    }
                    if (isset($_POST['perfil_marketing_p'])) {
                        $this->db->set('perfil_marketing_p', 't');
                    } else {
                        $this->db->set('perfil_marketing_p', 'f');
                    }
                    if (isset($_POST['filtrar_agenda'])) {
                        $this->db->set('filtrar_agenda', 't');
                    } else {
                        $this->db->set('filtrar_agenda', 'f');
                    }
                    if (isset($_POST['manternota'])) {
                        $this->db->set('manternota', 't');
                    } else {
                        $this->db->set('manternota', 'f');
                    }
                    if (isset($_POST['laboratorio_sc'])) {
                        $this->db->set('laboratorio_sc', 't');
                    } else {
                        $this->db->set('laboratorio_sc', 'f');
                    }
                    if (isset($_POST['financeiro_cadastro'])) {
                        $this->db->set('financeiro_cadastro', 't');
                    } else {
                        $this->db->set('financeiro_cadastro', 'f');
                    }
                    if (isset($_POST['valor_recibo_guia'])) {
                        $this->db->set('valor_recibo_guia', 't');
                    } else {
                        $this->db->set('valor_recibo_guia', 'f');
                    }
                    if (isset($_POST['orcamento_config'])) {
                        $this->db->set('orcamento_config', 't');
                    } else {
                        $this->db->set('orcamento_config', 'f');
                    }

                    if (isset($_POST['odontologia_valor_alterar'])) {
                        $this->db->set('odontologia_valor_alterar', 't');
                    } else {
                        $this->db->set('odontologia_valor_alterar', 'f');
                    }
                    if (isset($_POST['selecionar_retorno'])) {
                        $this->db->set('selecionar_retorno', 't');
                    } else {
                        $this->db->set('selecionar_retorno', 'f');
                    }

                    if (isset($_POST['excluir_transferencia'])) {
                        $this->db->set('excluir_transferencia', 't');
                    } else {
                        $this->db->set('excluir_transferencia', 'f');
                    }
                    if (isset($_POST['login_paciente'])) {
                        $this->db->set('login_paciente', 't');
                    } else {
                        $this->db->set('login_paciente', 'f');
                    }
                    if (isset($_POST['credito'])) {
                        $this->db->set('credito', 't');
                    } else {
                        $this->db->set('credito', 'f');
                    }
                    if (isset($_POST['administrador_cancelar'])) {
                        $this->db->set('administrador_cancelar', 't');
                    } else {
                        $this->db->set('administrador_cancelar', 'f');
                    }
                    if (isset($_POST['calendario_layout'])) {
                        $this->db->set('calendario_layout', 't');
                    } else {
                        $this->db->set('calendario_layout', 'f');
                    }
                    if (isset($_POST['cancelar_sala_espera'])) {
                        $this->db->set('cancelar_sala_espera', 't');
                    } else {
                        $this->db->set('cancelar_sala_espera', 'f');
                    }
                    if (isset($_POST['oftamologia'])) {
                        $this->db->set('oftamologia', 't');
                    } else {
                        $this->db->set('oftamologia', 'f');
                    }
                    if (isset($_POST['recomendacao_configuravel'])) {
                        $this->db->set('recomendacao_configuravel', 't');
                    } else {
                        $this->db->set('recomendacao_configuravel', 'f');
                    }
                    if (isset($_POST['orcamento_cadastro'])) {
                        $this->db->set('orcamento_cadastro', 't');
                    } else {
                        $this->db->set('orcamento_cadastro', 'f');
                    }

                    if (isset($_POST['recomendacao_obrigatorio'])) {
                        $this->db->set('recomendacao_obrigatorio', 't');
                    } else {
                        $this->db->set('recomendacao_obrigatorio', 'f');
                    }

                    if (isset($_POST['botao_ativar_sala'])) {
                        $this->db->set('botao_ativar_sala', 't');
                    } else {
                        $this->db->set('botao_ativar_sala', 'f');
                    }
                    if (isset($_POST['promotor_medico'])) {
                        $this->db->set('promotor_medico', 't');
                    } else {
                        $this->db->set('promotor_medico', 'f');
                    }

                    if (isset($_POST['retirar_botao_ficha'])) {
                        $this->db->set('retirar_botao_ficha', 't');
                    } else {
                        $this->db->set('retirar_botao_ficha', 'f');
                    }

                    if (isset($_POST['desativar_personalizacao_impressao'])) {
                        $this->db->set('desativar_personalizacao_impressao', 't');
                    } else {
                        $this->db->set('desativar_personalizacao_impressao', 'f');
                    }

                    if (isset($_POST['carregar_modelo_receituario'])) {
                        $this->db->set('carregar_modelo_receituario', 't');
                    } else {
                        $this->db->set('carregar_modelo_receituario', 'f');
                    }
//                    if (isset($_POST['fila_caixa'])) {
//                        $this->db->set('caixa', 't');
//                    } else {
//                        $this->db->set('caixa', 'f');
//                    }

                    if (isset($_POST['caixa_personalizado'])) {
                        $this->db->set('caixa_personalizado', 't');
                    } else {
                        $this->db->set('caixa_personalizado', 'f');
                    }

                    if (isset($_POST['desabilitar_trava_retorno'])) {
                        $this->db->set('desabilitar_trava_retorno', 't');
                    } else {
                        $this->db->set('desabilitar_trava_retorno', 'f');
                    }

                    if (isset($_POST['associa_credito_procedimento'])) {
                        $this->db->set('associa_credito_procedimento', 't');
                    } else {
                        $this->db->set('associa_credito_procedimento', 'f');
                    }

                    if (in_array("dt_nascimento", $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_nascimento', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_nascimento', 'f');
                    }

                    if (in_array('sexo', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_sexo', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_sexo', 'f');
                    }

                    if (in_array('cpf', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_cpf', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_cpf', 'f');
                    }

                    if (in_array('telefone', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_telefone', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_telefone', 'f');
                    }

                    if (in_array('municipio', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_municipio', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_municipio', 'f');
                    }

                    if (isset($_POST['repetir_horarios_agenda'])) {
                        $this->db->set('repetir_horarios_agenda', 't');
                    } else {
                        $this->db->set('repetir_horarios_agenda', 'f');
                    }
                    if (isset($_POST['laudo_sigiloso'])) {
                        $this->db->set('laudo_sigiloso', 't');
                    } else {
                        $this->db->set('laudo_sigiloso', 'f');
                    }
                    if (isset($_POST['gerente_cancelar_sala'])) {
                        $this->db->set('gerente_cancelar_sala', 't');
                    } else {
                        $this->db->set('gerente_cancelar_sala', 'f');
                    }

                    if (isset($_POST['subgrupo_procedimento'])) {
                        $this->db->set('subgrupo_procedimento', 't');
                    } else {
                        $this->db->set('subgrupo_procedimento', 'f');
                    }

                    if (isset($_POST['senha_finalizar_laudo'])) {
                        $this->db->set('senha_finalizar_laudo', 't');
                    } else {
                        $this->db->set('senha_finalizar_laudo', 'f');
                    }

                    if (isset($_POST['retirar_flag_solicitante'])) {
                        $this->db->set('retirar_flag_solicitante', 't');
                    } else {
                        $this->db->set('retirar_flag_solicitante', 'f');
                    }

                    if (isset($_POST['cadastrar_painel_sala'])) {
                        $this->db->set('cadastrar_painel_sala', 't');
                    } else {
                        $this->db->set('cadastrar_painel_sala', 'f');
                    }

                    if (isset($_POST['apenas_procedimentos_multiplos'])) {
                        $this->db->set('apenas_procedimentos_multiplos', 't');
                    } else {
                        $this->db->set('apenas_procedimentos_multiplos', 'f');
                    }

                    if (isset($_POST['percentual_multiplo'])) {
                        $this->db->set('percentual_multiplo', 't');
                    } else {
                        $this->db->set('percentual_multiplo', 'f');
                    }

                    if (isset($_POST['ajuste_pagamento_procedimento'])) {
                        $this->db->set('ajuste_pagamento_procedimento', 't');
                    } else {
                        $this->db->set('ajuste_pagamento_procedimento', 'f');
                    }

                    if (isset($_POST['retirar_preco_procedimento'])) {
                        $this->db->set('retirar_preco_procedimento', 't');
                    } else {
                        $this->db->set('retirar_preco_procedimento', 'f');
                    }

                    if (isset($_POST['relatorios_clinica_med'])) {
                        $this->db->set('relatorios_clinica_med', 't');
                    } else {
                        $this->db->set('relatorios_clinica_med', 'f');
                    }
                    if (isset($_POST['impressao_cimetra'])) {
                        $this->db->set('impressao_cimetra', 't');
                    } else {
                        $this->db->set('impressao_cimetra', 'f');
                    }
                    if (isset($_POST['botao_ficha_convenio'])) {
                        $this->db->set('botao_ficha_convenio', 't');
                    } else {
                        $this->db->set('botao_ficha_convenio', 'f');
                    }
                    if (isset($_POST['ordenacao_situacao'])) {
                        $this->db->set('ordenacao_situacao', 't');
                    } else {
                        $this->db->set('ordenacao_situacao', 'f');
                    }
                    if (isset($_POST['grupo_convenio_proc'])) {
                        $this->db->set('grupo_convenio_proc', 't');
                    } else {
                        $this->db->set('grupo_convenio_proc', 'f');
                    }
                }


                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_permissoes');

                $this->db->select('*');
                $this->db->from('tb_empresa_permissoes');
                $this->db->where('ativo', 't');
                $this->db->orderby('empresa_id desc');
                $return_perm = $this->db->get()->result_array();
//                echo '<pre>';
//                var_dump($return_perm);
//                die;
                if (count($return_perm) > 0) {

                    foreach ($return_perm[1] as $key_select => $value_select) {
                        if ($key_select != 'empresa_permissoes_id' && $key_select != 'empresa_id') {
                            $this->db->set("$key_select", $value_select);
                        }
                    }
                }
                $this->db->where('empresa_id', $empresa_id);
                $this->db->update('tb_empresa_permissoes');

                $this->db->select('internacao,
                                    chat,
                                    impressao_declaracao,
                                    impressao_recibo,
                                    email,
                                    impressao_laudo,
                                    centrocirurgico,
                                    relatoriorm,
                                    servicosms,
                                    servicoemail,
                                    email_mensagem_confirmacao,
                                    email_mensagem_agradecimento,
                                    imagem,
                                    consulta,
                                    especialidade,
                                    geral,
                                    faturamento,
                                    estoque,
                                    financeiro,
                                    marketing,
                                    laboratorio,
                                    ponto,
                                    calendario,
                                    email_mensagem_falta,
                                    botao_faturar_guia,
                                    botao_faturar_procedimento,
                                    chamar_consulta,
                                    procedimento_multiempresa,
                                    data_contaspagar,
                                    medico_laudodigitador,
                                    cabecalho_config,
                                    rodape_config,
                                    laudo_config,
                                    recibo_config,
                                    ficha_config,
                                    odontologia,
                                    producao_medica_saida,

                                    impressao_orcamento,
                                    mostrar_logo_clinica,
                                    declaracao_config,
                                    atestado_config,
                                    horario_sab,
                                    horario_seg_sex,
                                    farmacia,
                                    numero_empresa_painel,
                                    endereco_toten,
                                    horario_seg_sex_inicio,
                                    horario_seg_sex_fim,
                                    horario_sab_inicio,
                                    horario_sab_fim,
                                    endereco_upload,
                                    impressao_internacao');
                $this->db->from('tb_empresa');
                $this->db->where('ativo', 't');
                $this->db->where('empresa_id !=', $empresa_id);
                $this->db->orderby('empresa_id desc');
                $return_emp = $this->db->get()->result_array();

                if (count($return_emp) > 0) {

                    foreach ($return_emp[0] as $key_select => $value_select) {
                        if ($key_select != 'empresa_id') {
                            $this->db->set("$key_select", $value_select);
                        }
                    }
                }

                $this->db->where('empresa_id', $empresa_id);
                $this->db->update('tb_empresa');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $empresa_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('endereco_externo', $_POST['endereco_externo']);
                $this->db->set('endereco_toten', $_POST['endereco_toten']);
                $empresa_id = $_POST['txtempresaid'];
                $this->db->where('empresa_id', $empresa_id);
                $this->db->update('tb_empresa');
                if ($operador_id == 1) {
                    if (isset($_POST['procedimento_excecao'])) {
                        $this->db->set('procedimento_excecao', 't');
                    } else {
                        $this->db->set('procedimento_excecao', 'f');
                    }
                    if (isset($_POST['valor_autorizar'])) {
                        $this->db->set('valor_autorizar', 't');
                    } else {
                        $this->db->set('valor_autorizar', 'f');
                    }
                    if (count($_POST['campos_obrigatorio']) > 0) {
                        $this->db->set('campos_cadastro', json_encode($_POST['campos_obrigatorio']));
                    } else {
                        $this->db->set('campos_cadastro', '');
                    }
                    if (isset($_POST['gerente_cancelar'])) {
                        $this->db->set('gerente_cancelar', 't');
                    } else {
                        $this->db->set('gerente_cancelar', 'f');
                    }
                    if (isset($_POST['profissional_agendar'])) {
                        $this->db->set('profissional_agendar', 't');
                    } else {
                        $this->db->set('profissional_agendar', 'f');
                    }
                    if (isset($_POST['profissional_externo'])) {
                        $this->db->set('profissional_externo', 't');
                    } else {
                        $this->db->set('profissional_externo', 'f');
                    }
                    if (count($_POST['opc_telatendimento']) > 0) {
                        $this->db->set('campos_atendimentomed', json_encode($_POST['opc_telatendimento']));
                    } else {
                        $this->db->set('campos_atendimentomed', '');
                    }
                    if (count($_POST['opc_dadospaciente']) > 0) {
                        $this->db->set('dados_atendimentomed', json_encode($_POST['opc_dadospaciente']));
                    } else {
                        $this->db->set('dados_atendimentomed', '');
                    }
                    if (isset($_POST['modelo_laudo_medico'])) {
                        $this->db->set('modelo_laudo_medico', 't');
                    } else {
                        $this->db->set('modelo_laudo_medico', 'f');
                    }
                    if (isset($_POST['orcamento_multiplo'])) {
                        $this->db->set('orcamento_multiplo', 't');
                    } else {
                        $this->db->set('orcamento_multiplo', 'f');
                    }
                    if (isset($_POST['profissional_completo'])) {
                        $this->db->set('profissional_completo', 't');
                    } else {
                        $this->db->set('profissional_completo', 'f');
                    }
                    if (isset($_POST['agenda_modelo2'])) {
                        $this->db->set('agenda_modelo2', 't');
                    } else {
                        $this->db->set('agenda_modelo2', 'f');
                    }
                    if (isset($_POST['autorizar_sala_espera'])) {
                        $this->db->set('autorizar_sala_espera', 't');
                    } else {
                        $this->db->set('autorizar_sala_espera', 'f');
                    }
                    if (isset($_POST['reservar_escolher_proc'])) {
                        $this->db->set('reservar_escolher_proc', 't');
                    } else {
                        $this->db->set('reservar_escolher_proc', 'f');
                    }
                    if (isset($_POST['gerente_cancelar_sala'])) {
                        $this->db->set('gerente_cancelar_sala', 't');
                    } else {
                        $this->db->set('gerente_cancelar_sala', 'f');
                    }
                    if (isset($_POST['tecnica_promotor'])) {
                        $this->db->set('tecnica_promotor', 't');
                    } else {
                        $this->db->set('tecnica_promotor', 'f');
                    }
                    if (isset($_POST['botao_imagem_paciente'])) {
                        $this->db->set('botao_imagem_paciente', 't');
                    } else {
                        $this->db->set('botao_imagem_paciente', 'f');
                    }
                    if (isset($_POST['botao_arquivos_paciente'])) {
                        $this->db->set('botao_arquivos_paciente', 't');
                    } else {
                        $this->db->set('botao_arquivos_paciente', 'f');
                    }
//                    if (isset($_POST['fila_caixa'])) {
//                        $this->db->set('caixa', 't');
//                    } else {
//                        $this->db->set('caixa', 'f');
//                    }
                    if (isset($_POST['botao_laudo_paciente'])) {
                        $this->db->set('botao_laudo_paciente', 't');
                    } else {
                        $this->db->set('botao_laudo_paciente', 'f');
                    }
                    if (isset($_POST['gerente_recepcao_top_saude'])) {
                        $this->db->set('gerente_recepcao_top_saude', 't');
                    } else {
                        $this->db->set('gerente_recepcao_top_saude', 'f');
                    }
                    if (isset($_POST['gerente_relatorio_financeiro'])) {
                        $this->db->set('gerente_relatorio_financeiro', 't');
                    } else {
                        $this->db->set('gerente_relatorio_financeiro', 'f');
                    }
                    if (isset($_POST['valor_convenio_nao'])) {
                        $this->db->set('valor_convenio_nao', 't');
                    } else {
                        $this->db->set('valor_convenio_nao', 'f');
                    }
                    if (isset($_POST['orcamento_cadastro'])) {
                        $this->db->set('orcamento_cadastro', 't');
                    } else {
                        $this->db->set('orcamento_cadastro', 'f');
                    }
                    if (isset($_POST['desativar_taxa_administracao'])) {
                        $this->db->set('desativar_taxa_administracao', 't');
                    } else {
                        $this->db->set('desativar_taxa_administracao', 'f');
                    }
                    if (isset($_POST['producao_alternativo'])) {
                        $this->db->set('producao_alternativo', 't');
                    } else {
                        $this->db->set('producao_alternativo', 'f');
                    }
                    if (isset($_POST['tecnica_enviar'])) {
                        $this->db->set('tecnica_enviar', 't');
                    } else {
                        $this->db->set('tecnica_enviar', 'f');
                    }
                    if (isset($_POST['subgrupo'])) {
                        $this->db->set('subgrupo', 't');
                    } else {
                        $this->db->set('subgrupo', 'f');
                    }
                    if (isset($_POST['conjuge'])) {
                        $this->db->set('conjuge', 't');
                    } else {
                        $this->db->set('conjuge', 'f');
                    }
                    if (isset($_POST['valor_laboratorio'])) {
                        $this->db->set('valor_laboratorio', 't');
                    } else {
                        $this->db->set('valor_laboratorio', 'f');
                    }
                    if (isset($_POST['laudo_sigiloso'])) {
                        $this->db->set('laudo_sigiloso', 't');
                    } else {
                        $this->db->set('laudo_sigiloso', 'f');
                    }
                    if (isset($_POST['faturamento_novo'])) {
                        $this->db->set('faturamento_novo', 't');
                    } else {
                        $this->db->set('faturamento_novo', 'f');
                    }
                    if (isset($_POST['gerente_contasapagar'])) {
                        $this->db->set('gerente_contasapagar', 't');
                    } else {
                        $this->db->set('gerente_contasapagar', 'f');
                    }
                    if (isset($_POST['encaminhamento_email'])) {
                        $this->db->set('encaminhamento_email', 't');
                    } else {
                        $this->db->set('encaminhamento_email', 'f');
                    }
                    if (isset($_POST['cpf_obrigatorio'])) {
                        $this->db->set('cpf_obrigatorio', 't');
                    } else {
                        $this->db->set('cpf_obrigatorio', 'f');
                    }
                    if (isset($_POST['orcamento_recepcao'])) {
                        $this->db->set('orcamento_recepcao', 't');
                    } else {
                        $this->db->set('orcamento_recepcao', 'f');
                    }
                    if (isset($_POST['relatorio_ordem'])) {
                        $this->db->set('relatorio_ordem', 't');
                    } else {
                        $this->db->set('relatorio_ordem', 'f');
                    }
                    if (isset($_POST['relatorio_producao'])) {
                        $this->db->set('relatorio_producao', 't');
                    } else {
                        $this->db->set('relatorio_producao', 'f');
                    }
                    if (isset($_POST['relatorios_recepcao'])) {
                        $this->db->set('relatorios_recepcao', 't');
                    } else {
                        $this->db->set('relatorios_recepcao', 'f');
                    }
                    if (isset($_POST['financeiro_cadastro'])) {
                        $this->db->set('financeiro_cadastro', 't');
                    } else {
                        $this->db->set('financeiro_cadastro', 'f');
                    }

                    if (isset($_POST['ordem_chegada'])) {
                        $this->db->set('ordem_chegada', 't');
                    } else {
                        $this->db->set('ordem_chegada', 'f');
                    }
                    if (isset($_POST['login_paciente'])) {
                        $this->db->set('login_paciente', 't');
                    } else {
                        $this->db->set('login_paciente', 'f');
                    }

                    if (isset($_POST['credito'])) {
                        $this->db->set('credito', 't');
                    } else {
                        $this->db->set('credito', 'f');
                    }

                    if (isset($_POST['orcamento_config'])) {
                        $this->db->set('orcamento_config', 't');
                    } else {
                        $this->db->set('orcamento_config', 'f');
                    }

                    if (isset($_POST['subgrupo'])) {
                        $this->db->set('subgrupo', 't');
                    } else {
                        $this->db->set('subgrupo', 'f');
                    }

                    if (isset($_POST['odontologia_valor_alterar'])) {
                        $this->db->set('odontologia_valor_alterar', 't');
                    } else {
                        $this->db->set('odontologia_valor_alterar', 'f');
                    }
                    if (isset($_POST['selecionar_retorno'])) {
                        $this->db->set('selecionar_retorno', 't');
                    } else {
                        $this->db->set('selecionar_retorno', 'f');
                    }
                    if (isset($_POST['administrador_cancelar'])) {
                        $this->db->set('administrador_cancelar', 't');
                    } else {
                        $this->db->set('administrador_cancelar', 'f');
                    }
                    if (isset($_POST['valor_recibo_guia'])) {
                        $this->db->set('valor_recibo_guia', 't');
                    } else {
                        $this->db->set('valor_recibo_guia', 'f');
                    }
                    if (isset($_POST['calendario_layout'])) {
                        $this->db->set('calendario_layout', 't');
                    } else {
                        $this->db->set('calendario_layout', 'f');
                    }
                    if (isset($_POST['excluir_transferencia'])) {
                        $this->db->set('excluir_transferencia', 't');
                    } else {
                        $this->db->set('excluir_transferencia', 'f');
                    }
                    if (isset($_POST['recomendacao_configuravel'])) {
                        $this->db->set('recomendacao_configuravel', 't');
                    } else {
                        $this->db->set('recomendacao_configuravel', 'f');
                    }
                    if (isset($_POST['recomendacao_obrigatorio'])) {
                        $this->db->set('recomendacao_obrigatorio', 't');
                    } else {
                        $this->db->set('recomendacao_obrigatorio', 'f');
                    }
                    if (isset($_POST['botao_ativar_sala'])) {
                        $this->db->set('botao_ativar_sala', 't');
                    } else {
                        $this->db->set('botao_ativar_sala', 'f');
                    }
                    if (isset($_POST['cancelar_sala_espera'])) {
                        $this->db->set('cancelar_sala_espera', 't');
                    } else {
                        $this->db->set('cancelar_sala_espera', 'f');
                    }
                    if (isset($_POST['oftamologia'])) {
                        $this->db->set('oftamologia', 't');
                    } else {
                        $this->db->set('oftamologia', 'f');
                    }
                    if (isset($_POST['promotor_medico'])) {
                        $this->db->set('promotor_medico', 't');
                    } else {
                        $this->db->set('promotor_medico', 'f');
                    }

                    if (isset($_POST['retirar_botao_ficha'])) {
                        $this->db->set('retirar_botao_ficha', 't');
                    } else {
                        $this->db->set('retirar_botao_ficha', 'f');
                    }

                    if (isset($_POST['desativar_personalizacao_impressao'])) {
                        $this->db->set('desativar_personalizacao_impressao', 't');
                    } else {
                        $this->db->set('desativar_personalizacao_impressao', 'f');
                    }

                    if (isset($_POST['carregar_modelo_receituario'])) {
                        $this->db->set('carregar_modelo_receituario', 't');
                    } else {
                        $this->db->set('carregar_modelo_receituario', 'f');
                    }

                    if (isset($_POST['caixa_personalizado'])) {
                        $this->db->set('caixa_personalizado', 't');
                    } else {
                        $this->db->set('caixa_personalizado', 'f');
                    }

                    if (isset($_POST['desabilitar_trava_retorno'])) {
                        $this->db->set('desabilitar_trava_retorno', 't');
                    } else {
                        $this->db->set('desabilitar_trava_retorno', 'f');
                    }

                    if (isset($_POST['associa_credito_procedimento'])) {
                        $this->db->set('associa_credito_procedimento', 't');
                    } else {
                        $this->db->set('associa_credito_procedimento', 'f');
                    }

                    if (in_array("dt_nascimento", $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_nascimento', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_nascimento', 'f');
                    }

                    if (in_array('sexo', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_sexo', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_sexo', 'f');
                    }

                    if (in_array('cpf', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_cpf', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_cpf', 'f');
                    }

                    if (in_array('telefone', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_telefone', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_telefone', 'f');
                    }

                    if (in_array('municipio', $_POST['campos_obrigatorio'])) {
                        $this->db->set('campos_obrigatorios_pac_municipio', 't');
                    } else {
                        $this->db->set('campos_obrigatorios_pac_municipio', 'f');
                    }

                    if (isset($_POST['repetir_horarios_agenda'])) {
                        $this->db->set('repetir_horarios_agenda', 't');
                    } else {
                        $this->db->set('repetir_horarios_agenda', 'f');
                    }

                    if (isset($_POST['subgrupo_procedimento'])) {
                        $this->db->set('subgrupo_procedimento', 't');
                    } else {
                        $this->db->set('subgrupo_procedimento', 'f');
                    }

                    if (isset($_POST['senha_finalizar_laudo'])) {
                        $this->db->set('senha_finalizar_laudo', 't');
                    } else {
                        $this->db->set('senha_finalizar_laudo', 'f');
                    }

                    if (isset($_POST['retirar_flag_solicitante'])) {
                        $this->db->set('retirar_flag_solicitante', 't');
                    } else {
                        $this->db->set('retirar_flag_solicitante', 'f');
                    }

                    if (isset($_POST['cadastrar_painel_sala'])) {
                        $this->db->set('cadastrar_painel_sala', 't');
                    } else {
                        $this->db->set('cadastrar_painel_sala', 'f');
                    }

                    if (isset($_POST['apenas_procedimentos_multiplos'])) {
                        $this->db->set('apenas_procedimentos_multiplos', 't');
                    } else {
                        $this->db->set('apenas_procedimentos_multiplos', 'f');
                    }

                    if (isset($_POST['percentual_multiplo'])) {
                        $this->db->set('percentual_multiplo', 't');
                    } else {
                        $this->db->set('percentual_multiplo', 'f');
                    }

                    if (isset($_POST['ajuste_pagamento_procedimento'])) {
                        $this->db->set('ajuste_pagamento_procedimento', 't');
                    } else {
                        $this->db->set('ajuste_pagamento_procedimento', 'f');
                    }

                    if (isset($_POST['retirar_preco_procedimento'])) {
                        $this->db->set('retirar_preco_procedimento', 't');
                    } else {
                        $this->db->set('retirar_preco_procedimento', 'f');
                    }

                    if (isset($_POST['relatorios_clinica_med'])) {
                        $this->db->set('relatorios_clinica_med', 't');
                    } else {
                        $this->db->set('relatorios_clinica_med', 'f');
                    }
                    if (isset($_POST['impressao_cimetra'])) {
                        $this->db->set('impressao_cimetra', 't');
                    } else {
                        $this->db->set('impressao_cimetra', 'f');
                    }
                    if (isset($_POST['botao_ficha_convenio'])) {
                        $this->db->set('botao_ficha_convenio', 't');
                    } else {
                        $this->db->set('botao_ficha_convenio', 'f');
                    }
                    if (isset($_POST['manter_indicacao'])) {
                        $this->db->set('manter_indicacao', 't');
                    } else {
                        $this->db->set('manter_indicacao', 'f');
                    }
                    if (isset($_POST['fila_impressao'])) {
                        $this->db->set('fila_impressao', 't');
                    } else {
                        $this->db->set('fila_impressao', 'f');
                    }
                    if (isset($_POST['medico_solicitante'])) {
                        $this->db->set('medico_solicitante', 't');
                    } else {
                        $this->db->set('medico_solicitante', 'f');
                    }
                    if (isset($_POST['relatorio_operadora'])) {
                        $this->db->set('relatorio_operadora', 't');
                    } else {
                        $this->db->set('relatorio_operadora', 'f');
                    }
                    if (isset($_POST['relatorio_demandagrupo'])) {
                        $this->db->set('relatorio_demandagrupo', 't');
                    } else {
                        $this->db->set('relatorio_demandagrupo', 'f');
                    }
                    if (isset($_POST['relatorio_rm'])) {
                        $this->db->set('relatorio_rm', 't');
                    } else {
                        $this->db->set('relatorio_rm', 'f');
                    }
                    if (isset($_POST['relatorio_caixa'])) {
                        $this->db->set('relatorio_caixa', 't');
                    } else {
                        $this->db->set('relatorio_caixa', 'f');
                    }
                    if (isset($_POST['uso_salas'])) {
                        $this->db->set('uso_salas', 't');
                    } else {
                        $this->db->set('uso_salas', 'f');
                    }
                    if (isset($_POST['enfermagem'])) {
                        $this->db->set('enfermagem', 't');
                    } else {
                        $this->db->set('enfermagem', 'f');
                    }
                    if (isset($_POST['integracaosollis'])) {
                        $this->db->set('integracaosollis', 't');
                    } else {
                        $this->db->set('integracaosollis', 'f');
                    }
                    if (isset($_POST['medicinadotrabalho'])) {
                        $this->db->set('medicinadotrabalho', 't');
                    } else {
                        $this->db->set('medicinadotrabalho', 'f');
                    }
                    if (isset($_POST['ocupacao_pai'])) {
                        $this->db->set('ocupacao_pai', 't');
                    } else {
                        $this->db->set('ocupacao_pai', 'f');
                    }
                    if (isset($_POST['ocupacao_mae'])) {
                        $this->db->set('ocupacao_mae', 't');
                    } else {
                        $this->db->set('ocupacao_mae', 'f');
                    }
                    if (isset($_POST['limitar_acesso'])) {
                        $this->db->set('limitar_acesso', 't');
                    } else {
                        $this->db->set('limitar_acesso', 'f');
                    }
                    if (isset($_POST['perfil_marketing_p'])) {
                        $this->db->set('perfil_marketing_p', 't');
                    } else {
                        $this->db->set('perfil_marketing_p', 'f');
                    }
                    if (isset($_POST['filtrar_agenda'])) {
                        $this->db->set('filtrar_agenda', 't');
                    } else {
                        $this->db->set('filtrar_agenda', 'f');
                    }
                    if (isset($_POST['manternota'])) {
                        $this->db->set('manternota', 't');
                    } else {
                        $this->db->set('manternota', 'f');
                    }
                    if (isset($_POST['laboratorio_sc'])) {
                        $this->db->set('laboratorio_sc', 't');
                    } else {
                        $this->db->set('laboratorio_sc', 'f');
                    }
                    if (isset($_POST['ordenacao_situacao'])) {
                        $this->db->set('ordenacao_situacao', 't');
                    } else {
                        $this->db->set('ordenacao_situacao', 'f');
                    }
                    if (isset($_POST['grupo_convenio_proc'])) {
                        $this->db->set('grupo_convenio_proc', 't');
                    } else {
                        $this->db->set('grupo_convenio_proc', 'f');
                    }
                }

                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('empresa_id', $empresa_id);
                $this->db->update('tb_empresa_permissoes');
            }
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($empresa_id) {

        if ($empresa_id != 0) {
            $this->db->select('f.empresa_id, 
                               f.nome,
                               razao_social,
                               cnpj,
                               celular,
                               telefone,
                               email,
                               cep,
                               logradouro,
                               numero,
                               bairro,
                               cnes,
                               f.municipio_id,
                               c.nome as municipio,
                               c.estado,
                               cep,
                               consulta,
                               internacao,
                               centrocirurgico,
                               especialidade,
                               geral,
                               faturamento,
                               estoque,
                               chamar_consulta,
                               procedimento_multiempresa,
                               financeiro,
                               data_contaspagar,
                               medico_laudodigitador,
                               laboratorio,
                               ep.laboratorio_sc,
                               ponto,
                               marketing,
                               imagem,
                               odontologia,
                               impressao_tipo,
                               impressao_laudo,
                               impressao_recibo,
                               impressao_declaracao,
                               cabecalho_config,
                               rodape_config,
                               laudo_config,
                               recibo_config,
                               ficha_config,
                               declaracao_config,
                               atestado_config,
                               oftamologia,
                               farmacia,
                               caixa,
                               cancelar_sala_espera,
                               promotor_medico,
                               calendario,
                               login_paciente,
                               servicosms,
                               orcamento_config,
                               impressao_internacao,
                               credito,
                               valor_recibo_guia,
                               impressao_orcamento,
                               odontologia_valor_alterar,
                               selecionar_retorno,
                               administrador_cancelar,
                               servicoemail,
                               endereco_toten,
                               endereco_externo,
                               excluir_transferencia,
                               chat,
                               procedimento_excecao,
                               ordem_chegada,
                               f.horario_sab,
                               f.horario_seg_sex,
                               ep.valor_autorizar,
                               ep.gerente_contasapagar,
                               ep.cpf_obrigatorio,
                               ep.orcamento_recepcao,
                               ep.relatorio_ordem,
                               ep.relatorio_producao,
                               ep.relatorios_recepcao,
                               ep.financeiro_cadastro,
                               ep.ocupacao_mae,
                               ep.ocupacao_pai,
                               botao_faturar_guia,
                               botao_faturar_procedimento,
                               producao_medica_saida,
                               ep.procedimento_excecao,
                               ep.calendario_layout,
                               ep.botao_ativar_sala,
                               ep.retirar_botao_ficha,
                               ep.encaminhamento_email,
                               ep.desativar_personalizacao_impressao,
                               ep.recomendacao_configuravel,
                               f.mostrar_logo_clinica,
                               ep.recomendacao_obrigatorio,
                               ep.caixa_personalizado,
                               ep.carregar_modelo_receituario,
                               ep.desabilitar_trava_retorno,
                               ep.associa_credito_procedimento,
                               ep.valor_convenio_nao,
                               ep.conjuge,
                               ep.subgrupo,
                               ep.laudo_sigiloso,
                               f.numero_empresa_painel,
                               ep.campos_obrigatorios_pac_cpf,
                               ep.valor_laboratorio,
                               ep.profissional_completo,
                               ep.tecnica_promotor,
                               ep.tecnica_enviar,
                               ep.campos_obrigatorios_pac_sexo,
                               ep.campos_obrigatorios_pac_nascimento,
                               ep.campos_obrigatorios_pac_telefone,
                               ep.campos_obrigatorios_pac_municipio,
                               ep.repetir_horarios_agenda,
                               ep.desativar_taxa_administracao,
                               ep.producao_alternativo,
                               ep.modelo_laudo_medico,
                               ep.subgrupo_procedimento,
                               ep.senha_finalizar_laudo,
                               ep.retirar_flag_solicitante,
                               ep.campos_cadastro,
                               ep.orcamento_multiplo,
                               ep.campos_atendimentomed,
                               ep.dados_atendimentomed,
                               ep.cadastrar_painel_sala,
                               ep.apenas_procedimentos_multiplos,
                               ep.orcamento_cadastro,
                               ep.gerente_cancelar,
                               ep.gerente_relatorio_financeiro,
                               ep.botao_arquivos_paciente,
                               ep.botao_imagem_paciente,
                               ep.gerente_cancelar_sala,
                               ep.autorizar_sala_espera,
                               f.endereco_upload,
                               f.horario_seg_sex_inicio,
                               f.horario_seg_sex_fim,
                               f.horario_sab_inicio,
                               f.horario_sab_fim,
                               f.endereco_integracao_lab,
                               f.identificador_lis,
                               f.origem_lis,
                               ep.percentual_multiplo,
                               ep.botao_laudo_paciente,
                               ep.ajuste_pagamento_procedimento,
                               ep.retirar_preco_procedimento,
                               ep.relatorios_clinica_med,
                               ep.reservar_escolher_proc,
                               ep.impressao_cimetra,
                               ep.gerente_recepcao_top_saude,
                               ep.manter_indicacao,
                               ep.fila_impressao,
                               ep.medico_solicitante,
                               ep.uso_salas,
                               ep.relatorio_operadora,
                               ep.profissional_externo,
                               ep.profissional_agendar,
                               ep.relatorio_demandagrupo,
                               ep.relatorio_rm,
                               ep.relatorio_caixa,
                               ep.enfermagem,
                               ep.integracaosollis,
                               ep.medicinadotrabalho,
                               ep.limitar_acesso,
                               ep.faturamento_novo,
                               ep.manternota,
                               ep.grupo_convenio_proc,
                               ep.agenda_modelo2,
                               ep.perfil_marketing_p,
                               ep.ordenacao_situacao,
                               ep.filtrar_agenda,
                               ep.botao_ficha_convenio
                               ');
            $this->db->from('tb_empresa f');
            $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = f.empresa_id', 'left');
            $this->db->where("f.empresa_id", $empresa_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_empresa_id = $empresa_id;
            $this->_nome = $return[0]->nome;
            $this->_cnpj = $return[0]->cnpj;
            $this->_razao_social = $return[0]->razao_social;
            $this->_celular = $return[0]->celular;
            $this->_farmacia = $return[0]->farmacia;
            $this->_telefone = $return[0]->telefone;
            $this->_orcamento_multiplo = $return[0]->orcamento_multiplo;
            $this->_profissional_agendar = $return[0]->profissional_agendar;
            $this->_profissional_externo = $return[0]->profissional_externo;
            $this->_grupo_convenio_proc = $return[0]->grupo_convenio_proc;
            $this->_faturamento_novo = $return[0]->faturamento_novo;
            $this->_email = $return[0]->email;
            $this->_cep = $return[0]->cep;
            $this->_agenda_modelo2 = $return[0]->agenda_modelo2;
            $this->_endereco_integracao_lab = $return[0]->endereco_integracao_lab;
            $this->_identificador_lis = $return[0]->identificador_lis;
            $this->_origem_lis = $return[0]->origem_lis;
            $this->_subgrupo = $return[0]->subgrupo;
            $this->_ordenacao_situacao = $return[0]->ordenacao_situacao;
            $this->_botao_imagem_paciente = $return[0]->botao_imagem_paciente;
            $this->_reservar_escolher_proc = $return[0]->reservar_escolher_proc;
            $this->_botao_arquivos_paciente = $return[0]->botao_arquivos_paciente;
            $this->_gerente_relatorio_financeiro = $return[0]->gerente_relatorio_financeiro;
            $this->_laudo_sigiloso = $return[0]->laudo_sigiloso;
            $this->_gerente_cancelar = $return[0]->gerente_cancelar;
            $this->_impressao_internacao = $return[0]->impressao_internacao;
            $this->_campos_cadastro = $return[0]->campos_cadastro;
            $this->_gerente_cancelar_sala = $return[0]->gerente_cancelar_sala;
            $this->_campos_atendimentomed = $return[0]->campos_atendimentomed;
            $this->_dados_atendimentomed = $return[0]->dados_atendimentomed;
            $this->_modelo_laudo_medico = $return[0]->modelo_laudo_medico;
            $this->_orcamento_cadastro = $return[0]->orcamento_cadastro;
            $this->_endereco_upload = $return[0]->endereco_upload;
            $this->_conjuge = $return[0]->conjuge;
            $this->_horario_seg_sex = $return[0]->horario_seg_sex;
            $this->_horario_sab = $return[0]->horario_sab;
            $this->_logradouro = $return[0]->logradouro;
            $this->_numero = $return[0]->numero;
            $this->_producao_alternativo = $return[0]->producao_alternativo;
            $this->_autorizar_sala_espera = $return[0]->autorizar_sala_espera;
            $this->_bairro = $return[0]->bairro;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_caixa = $return[0]->caixa;
            $this->_gerente_recepcao_top_saude = $return[0]->gerente_recepcao_top_saude;
            $this->_valor_convenio_nao = $return[0]->valor_convenio_nao;
            $this->_desativar_taxa_administracao = $return[0]->desativar_taxa_administracao;
            $this->_promotor_medico = $return[0]->promotor_medico;
            $this->_municipio = $return[0]->municipio;
            $this->_encaminhamento_email = $return[0]->encaminhamento_email;
            $this->_nome = $return[0]->nome;
            $this->_orcamento_config = $return[0]->orcamento_config;
            $this->_odontologia_valor_alterar = $return[0]->odontologia_valor_alterar;
            $this->_selecionar_retorno = $return[0]->selecionar_retorno;
            $this->_impressao_orcamento = $return[0]->impressao_orcamento;
            $this->_administrador_cancelar = $return[0]->administrador_cancelar;
            $this->_profissional_completo = $return[0]->profissional_completo;
            $this->_tecnica_promotor = $return[0]->tecnica_promotor;
            $this->_tecnica_enviar = $return[0]->tecnica_enviar;
            $this->_endereco_toten = $return[0]->endereco_toten;
            $this->_estado = $return[0]->estado;
            $this->_cep = $return[0]->cep;
            $this->_chat = $return[0]->chat;
            $this->_valor_laboratorio = $return[0]->valor_laboratorio;
            $this->_servicoemail = $return[0]->servicoemail;
            $this->_servicosms = $return[0]->servicosms;
            $this->_cnes = $return[0]->cnes;
            $this->_internacao = $return[0]->internacao;
            $this->_centro_cirurgico = $return[0]->centrocirurgico;
            $this->_consulta = $return[0]->consulta;
            $this->_especialidade = $return[0]->especialidade;
            $this->_odontologia = $return[0]->odontologia;
            $this->_geral = $return[0]->geral;
            $this->_faturamento = $return[0]->faturamento;
            $this->_estoque = $return[0]->estoque;
            $this->_financeiro = $return[0]->financeiro;
            $this->_marketing = $return[0]->marketing;
            $this->_excluir_transferencia = $return[0]->excluir_transferencia;
            $this->_imagem = $return[0]->imagem;
            $this->_laboratorio = $return[0]->laboratorio;
            $this->_laboratorio_sc = $return[0]->laboratorio_sc;
            $this->_ponto = $return[0]->ponto;
            $this->_impressao_tipo = $return[0]->impressao_tipo;
            $this->_impressao_laudo = $return[0]->impressao_laudo;
            $this->_impressao_declaracao = $return[0]->impressao_declaracao;
            $this->_impressao_recibo = $return[0]->impressao_recibo;
            $this->_calendario = $return[0]->calendario;
            $this->_botao_faturar_guia = $return[0]->botao_faturar_guia;
            $this->_data_contaspagar = $return[0]->data_contaspagar;
            $this->_login_paciente = $return[0]->login_paciente;
            $this->_endereco_externo = $return[0]->endereco_externo;
            $this->_medico_laudodigitador = $return[0]->medico_laudodigitador;
            $this->_botao_faturar_proc = $return[0]->botao_faturar_procedimento;
            $this->_chamar_consulta = $return[0]->chamar_consulta;
            $this->_procedimento_multiempresa = $return[0]->procedimento_multiempresa;
            $this->_cabecalho_config = $return[0]->cabecalho_config;
            $this->_rodape_config = $return[0]->rodape_config;
            $this->_laudo_config = $return[0]->laudo_config;
            $this->_recibo_config = $return[0]->recibo_config;
            $this->_ficha_config = $return[0]->ficha_config;
            $this->_declaracao_config = $return[0]->declaracao_config;
            $this->_atestado_config = $return[0]->atestado_config;
            $this->_producao_medica_saida = $return[0]->producao_medica_saida;
            $this->_procedimento_excecao = $return[0]->procedimento_excecao;
            $this->_ordem_chegada = $return[0]->ordem_chegada;
            $this->_calendario_layout = $return[0]->calendario_layout;
            $this->_recomendacao_configuravel = $return[0]->recomendacao_configuravel;
            $this->_credito = $return[0]->credito;
            $this->_valor_recibo_guia = $return[0]->valor_recibo_guia;
            $this->_recomendacao_obrigatorio = $return[0]->recomendacao_obrigatorio;
            $this->_botao_ativar_sala = $return[0]->botao_ativar_sala;
            $this->_oftamologia = $return[0]->oftamologia;
            $this->_valor_autorizar = $return[0]->valor_autorizar;
            $this->_gerente_contasapagar = $return[0]->gerente_contasapagar;
            $this->_cpf_obrigatorio = $return[0]->cpf_obrigatorio;
            $this->_orcamento_recepcao = $return[0]->orcamento_recepcao;
            $this->_relatorio_ordem = $return[0]->relatorio_ordem;
            $this->_relatorio_producao = $return[0]->relatorio_producao;
            $this->_relatorios_recepcao = $return[0]->relatorios_recepcao;
            $this->_financeiro_cadastro = $return[0]->financeiro_cadastro;
            $this->_retirar_botao_ficha = $return[0]->retirar_botao_ficha;
            $this->_desativar_personalizacao_impressao = $return[0]->desativar_personalizacao_impressao;
            $this->_mostrar_logo_clinica = $return[0]->mostrar_logo_clinica;
            $this->_carregar_modelo_receituario = $return[0]->carregar_modelo_receituario;
            $this->_caixa_personalizado = $return[0]->caixa_personalizado;
            $this->_desabilitar_trava_retorno = $return[0]->desabilitar_trava_retorno;
            $this->_numero_empresa_painel = $return[0]->numero_empresa_painel;
            $this->_associa_credito_procedimento = $return[0]->associa_credito_procedimento;
            $this->_campos_obrigatorios_pac_municipio = $return[0]->campos_obrigatorios_pac_municipio;
            $this->_campos_obrigatorios_pac_telefone = $return[0]->campos_obrigatorios_pac_telefone;
            $this->_campos_obrigatorios_pac_nascimento = $return[0]->campos_obrigatorios_pac_nascimento;
            $this->_campos_obrigatorios_pac_sexo = $return[0]->campos_obrigatorios_pac_sexo;
            $this->_campos_obrigatorios_pac_cpf = $return[0]->campos_obrigatorios_pac_cpf;
            $this->_repetir_horarios_agenda = $return[0]->repetir_horarios_agenda;
            $this->_subgrupo_procedimento = $return[0]->subgrupo_procedimento;
            $this->_senha_finalizar_laudo = $return[0]->senha_finalizar_laudo;
            $this->_retirar_flag_solicitante = $return[0]->retirar_flag_solicitante;
            $this->_cadastrar_painel_sala = $return[0]->cadastrar_painel_sala;
            $this->_apenas_procedimentos_multiplos = $return[0]->apenas_procedimentos_multiplos;
            $this->_horario_seg_sex_inicio = $return[0]->horario_seg_sex_inicio;
            $this->_horario_seg_sex_fim = $return[0]->horario_seg_sex_fim;
            $this->_horario_sab_inicio = $return[0]->horario_sab_inicio;
            $this->_horario_sab_fim = $return[0]->horario_sab_fim;
            $this->_percentual_multiplo = $return[0]->percentual_multiplo;
            $this->_ajuste_pagamento_procedimento = $return[0]->ajuste_pagamento_procedimento;
            $this->_retirar_preco_procedimento = $return[0]->retirar_preco_procedimento;
            $this->_relatorios_clinica_med = $return[0]->relatorios_clinica_med;
            $this->_botao_ficha_convenio = $return[0]->botao_ficha_convenio;
            $this->_impressao_cimetra = $return[0]->impressao_cimetra;
            $this->_manter_indicacao = $return[0]->manter_indicacao;
            $this->_fila_impressao = $return[0]->fila_impressao;
            $this->_medico_solicitante = $return[0]->medico_solicitante;
            $this->_uso_salas = $return[0]->uso_salas;
            $this->_relatorio_operadora = $return[0]->relatorio_operadora;
            $this->_relatorio_demandagrupo = $return[0]->relatorio_demandagrupo;
            $this->_relatorio_rm = $return[0]->relatorio_rm;
            $this->_relatorio_caixa = $return[0]->relatorio_caixa;
            $this->_enfermagem = $return[0]->enfermagem;
            $this->_integracaosollis = $return[0]->integracaosollis;
            $this->_medicinadotrabalho = $return[0]->medicinadotrabalho;
            $this->_ocupacao_mae = $return[0]->ocupacao_mae;
            $this->_ocupacao_pai = $return[0]->ocupacao_pai;
            $this->_manternota = $return[0]->manternota;
            $this->_limitar_acesso = $return[0]->limitar_acesso;
            $this->_perfil_marketing_p = $return[0]->perfil_marketing_p;
            $this->_filtrar_agenda = $return[0]->filtrar_agenda;
        } else {
            $this->_empresa_id = null;
        }
    }

}

?>
