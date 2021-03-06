<?php

class sala_model extends Model {

    var $_exame_sala_id = null;
    var $_nome = null;
    var $_tipo = null;
    var $_nome_chamada = null;

    function Sala_model($exame_sala_id = null) {
        parent::Model();
        if (isset($exame_sala_id)) {
            $this->instanciar($exame_sala_id);
        }
    }

    function listar($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->where('excluido', 'f');
        $this->db->where('empresa_id', $empresa_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listararmazem() {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->orderby('nome');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsalapainel($sala_id) {

        $this->db->select('exame_sala_painel_id,
                            nome_chamada, painel_id');
        $this->db->from('tb_exame_sala_painel');
        $this->db->where('exame_sala_id', $sala_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsalagrupo($sala_id) {

        $this->db->select('exame_sala_grupo_id,
                            exame_sala_id, grupo');
        $this->db->from('tb_exame_sala_grupo');
        $this->db->where('exame_sala_id', $sala_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsala($sala_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->where('exame_sala_id', $sala_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($exame_sala_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_sala_id', $exame_sala_id);
        $this->db->update('tb_exame_sala');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirsalapainel($sala_painel_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_sala_painel_id', $sala_painel_id);
        $this->db->update('tb_exame_sala_painel');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirmultiplossalagrupo() {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        foreach ($_POST['selecionado'] as $key => $value){
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exame_sala_grupo_id', $key);
            $this->db->update('tb_exame_sala_grupo');
        }
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirsalagrupo($sala_grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_sala_grupo_id', $sala_grupo_id);
        $this->db->update('tb_exame_sala_grupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirsala($exame_sala_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('excluido', 't');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_sala_id', $exame_sala_id);
        $this->db->update('tb_exame_sala');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarsalapainel() {
        try {
            $this->db->select('exame_sala_id');
            $this->db->from('tb_exame_sala_painel');
            $this->db->where('ativo', 't');
            $this->db->where('painel_id', $_POST['painel_numero']);
            $this->db->where('exame_sala_id', $_POST['exame_sala_id']);
            $return = $this->db->get()->result();

            if (count($return) == 0) {
                $this->db->set('nome_chamada', $_POST['txtnomechamada']);
                $this->db->set('painel_id', $_POST['painel_numero']);
                $this->db->set('exame_sala_id', $_POST['exame_sala_id']);

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exame_sala_painel');
            }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsalagrupo() {
        try {

            $this->db->set('grupo', $_POST['grupo']);
            $this->db->set('exame_sala_id', $_POST['exame_sala_id']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_exame_sala_grupo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $exame_sala_id = $this->db->insert_id();
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($grupos) {
        try {
            /* inicia o mapeamento no banco */
            $empresa_id = $this->session->userdata('empresa_id');
            $exame_sala_id = $_POST['txtexamesalaid'];
            if ($_POST['armazem'] != '') {
                $this->db->set('armazem_id', $_POST['armazem']);
            }

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('nome', $_POST['txtNome']);
            if($_POST['toten_sala_id'] > 0){
               $this->db->set('toten_sala_id', $_POST['toten_sala_id']);  
            }
           
//            $this->db->set('nome_chamada', $_POST['txtnomechamada']);
//            $this->db->set('tipo', $_POST['tipo']);
//            $this->db->set('painel_id', $_POST['painel_id']);
//            $this->db->set('grupo', $_POST['grupo']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtexamesalaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exame_sala');
                $exame_sala_id = $this->db->insert_id();
                foreach ($grupos as $item) {
                    
                    $this->db->set('grupo', $item->nome);
                    $this->db->set('exame_sala_id', $exame_sala_id);

                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_exame_sala_grupo');
                }
                
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->select('cadastrar_painel_sala')->from('tb_empresa_permissoes')->where('empresa_id', $empresa_id);
                $return = $this->db->get()->result();
                if($return[0]->cadastrar_painel_sala == 't'){
                    for($i = 1; $i <= 10; $i++){
                        $this->db->set('nome_chamada', $_POST['txtNome']);
                        $this->db->set('painel_id', $i);
                        $this->db->set('exame_sala_id', $exame_sala_id);

                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_exame_sala_painel');
                    }
                }
                
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sala_id = $_POST['txtexamesalaid'];
                $this->db->where('exame_sala_id', $exame_sala_id);
                $this->db->update('tb_exame_sala');
            }
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function ativar($exame_sala_id) {
        try {
            /* inicia o mapeamento no banco */

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $exame_sala_id);
            $this->db->update('tb_exame_sala');
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($exame_sala_id) {

        if ($exame_sala_id != 0) {
            $this->db->select('exame_sala_id, nome, tipo, nome_chamada, armazem_id, grupo, painel_id, toten_sala_id');
            $this->db->from('tb_exame_sala');
            $this->db->where("exame_sala_id", $exame_sala_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_exame_sala_id = $exame_sala_id;
            $this->_nome = $return[0]->nome;
            $this->_tipo = $return[0]->tipo;
            $this->_toten_sala_id = $return[0]->toten_sala_id;
            $this->_grupo = $return[0]->grupo;
            $this->_painel_id = $return[0]->painel_id;
            $this->_armazem_id = $return[0]->armazem_id;
            $this->_nome_chamada = $return[0]->nome_chamada;
        } else {
            $this->_exame_sala_id = null;
        }
    }

}

?>
