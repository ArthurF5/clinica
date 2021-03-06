-- Dia 26/07/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN autorizado boolean DEFAULT false;
UPDATE ponto.tb_ambulatorio_orcamento_item SET autorizado = ao.autorizado 
FROM ( 
    ponto.tb_ambulatorio_orcamento_item aoi 
    INNER JOIN ponto.tb_ambulatorio_orcamento ao
    ON aoi.orcamento_id = ao.ambulatorio_orcamento_id
)
WHERE ponto.tb_ambulatorio_orcamento_item.ambulatorio_orcamento_item_id = aoi.ambulatorio_orcamento_item_id
AND ponto.tb_ambulatorio_orcamento_item.autorizado != true;

UPDATE ponto.tb_ambulatorio_orcamento_item SET data_preferencia = ao.data_criacao 
FROM ( 
    ponto.tb_ambulatorio_orcamento_item aoi 
    INNER JOIN ponto.tb_ambulatorio_orcamento ao
    ON aoi.orcamento_id = ao.ambulatorio_orcamento_id
)
WHERE ponto.tb_ambulatorio_orcamento_item.ambulatorio_orcamento_item_id = aoi.ambulatorio_orcamento_item_id
AND ponto.tb_ambulatorio_orcamento_item.data_preferencia IS NULL;

ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN observacao TEXT;

-- Dia 27/07/2018
ALTER TABLE ponto.tb_toten_senha ADD COLUMN chamada boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN idfila_painel TEXT;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_atendimentomed text;

-- Dia 30/07/2018
ALTER TABLE ponto.tb_internacao ADD COLUMN faturado boolean DEFAULT false;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor1 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor2 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor3 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor4 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento1 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento2 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento3 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento4 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN operador_faturamento integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN data_faturamento timestamp without time zone;
ALTER TABLE ponto.tb_internacao ADD COLUMN desconto numeric(10,2) DEFAULT 0;

ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto_laudo TYPE TEXT;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto_revisor TYPE TEXT;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto TYPE TEXT;

-- Dia 31/07/2018

CREATE TABLE ponto.tb_laudo_form
(
  obesidade character varying(3),
  diabetes character varying(3),
  sedentarismo character varying(3),
  hipertensao character varying(3),
  dac character varying(3),
  tabagismo character varying(3),
  dislipidemia character varying(3),
  diabetespe character varying(3),
  haspe character varying(3),
  dacpe character varying(3),
  ircpe character varying(3),
  sopros character varying(3),
  questoes text,
  paciente_id integer,
  guia_id integer,
  laudo_form_id serial primary key
  );

-- Dia 03/08/2018

CREATE TABLE ponto.tb_laudo_avaliacao
(
  avaliacao_tabela1 text,
  avaliacao_tabela2 text,
  avaliacao_tabela3 text,
  avaliacao_tabela4 text,
  paciente_id integer,
  guia_id integer,
  laudo_avaliacao_id serial primary key  
);

CREATE TABLE ponto.tb_internacao_procedimentos
(
  internacao_procedimentos_id SERIAL NOT NULL,
  internacao_id integer,
  procedimento_convenio_id integer,
  empresa_id integer,
  medico_id integer,
  quantidade integer,
  valor_total numeric(10,2) DEFAULT 0,
  forma_pagamento1 integer,
  valor1 numeric(10,2) DEFAULT 0,
  forma_pagamento2 integer,
  valor2 numeric(10,2) DEFAULT 0,
  forma_pagamento3 integer,
  valor3 numeric(10,2) DEFAULT 0,
  forma_pagamento4 integer,
  valor4 numeric(10,2) DEFAULT 0,
  operador_faturamento integer,
  data_faturamento timestamp without time zone,
  desconto numeric(10,2) DEFAULT 0,
  faturado boolean NOT NULL DEFAULT false,
  autorizacao character varying(50),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_internacao_procedimentos_pkey PRIMARY KEY (internacao_procedimentos_id)
);


ALTER TABLE ponto.tb_internacao_procedimentos ADD COLUMN financeiro boolean DEFAULT false;

ALTER TABLE ponto.tb_internacao_procedimentos ADD COLUMN operador_financeiro integer;
ALTER TABLE ponto.tb_internacao_procedimentos ADD COLUMN data_financeiro timestamp without time zone;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2338');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Na lista de saídas é possível re-internar o paciente e foram adicionados mais filtros na busca',
            '2338',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2581');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Criado o faturamento de internações em Faturamento->Rotinas->Faturar e Faturamento->Rotinas->Faturamento Manual',
            '2581',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

-- Dia 04/08/2018

CREATE TABLE ponto.tb_laudo_parecer
(
  dados text,
  exames text,
  exames_complementares text,
  guia_id integer,
  paciente_id integer,
  laudo_parecer_id serial NOT NULL,
  hipotese_diagnostica text,
  antibiotico text,
  CONSTRAINT tb_laudo_parecer_pkey PRIMARY KEY (laudo_parecer_id)
);

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN gerente_cancelar boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN autorizar_sala_espera boolean DEFAULT true;

-- Dia 09/08/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN dados_atendimentomed text;

-- Dia 10/08/2018

CREATE TABLE ponto.tb_laudo_cirurgias
(
  cirurgias text,
  complicacoes text,
  ressonanciamag text,
  guia_id integer,
  paciente_id integer,
  laudo_cirurgia_id serial primary key  
  
);

-- Dia 11/08/2018

CREATE TABLE ponto.tb_laudo_exameslab
(
  exames_laboratoriais text,  
  guia_id integer,
  paciente_id integer,
  laudo_exameslab_id serial primary key  
  
);

-- Dia 13/08/2018

CREATE TABLE ponto.tb_laudo_ecocardio
(
  ecocardio text,  
  guia_id integer,
  paciente_id integer,
  laudo_ecocardio_id serial primary key  
  
);

CREATE TABLE ponto.tb_laudo_cate
(
  cate text,
  guia_id integer,
  paciente_id integer,
  laudo_cate_id serial primary key 
);

CREATE TABLE ponto.tb_laudo_ecostress
(
  ecostress text,
  guia_id integer,
  paciente_id integer,
  laudo_ecostress_id serial primary key 
);

-- Dia 14/08/2018

CREATE TABLE ponto.tb_aso_setor
(
  aso_setor_id serial primary key,
  descricao_setor character varying(200),  
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  aso_funcao_id text
);

CREATE TABLE ponto.tb_aso_funcao
(
  aso_funcao_id serial primary key,
  descricao_funcao character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  aso_risco_id text
 
);

CREATE TABLE ponto.tb_aso_risco
(
  aso_risco_id serial primary key,
  descricao_risco character varying(200),  
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer  
);
-- Dia 08/08/2018
ALTER TABLE ponto.tb_financeiro_credor_devedor ADD COLUMN tipo_pessoa text;
ALTER TABLE ponto.tb_financeiro_credor_devedor ADD COLUMN email text;
ALTER TABLE ponto.tb_financeiro_credor_devedor ADD COLUMN observacao text;


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN gerente_cancelar_sala boolean DEFAULT true;


ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN horario_preferencia time without time zone;


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN gerente_recepcao_top_saude boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_impressao_recibo ADD COLUMN repetir_recibo integer;

ALTER TABLE ponto.tb_operador ADD COLUMN endereco_sistema text;

CREATE TABLE ponto.tb_ambulatorio_laudo_integracao
(
  ambulatorio_laudo_integracao_id serial NOT NULL,
  paciente_id integer,
  paciente_web_id integer,
  ambulatorio_laudoweb_id integer,
  procedimento text,
  empresa text,
  tipo text,
  medico_id integer,
  convenio text,
  data date,
  data_cadastro timestamp without time zone,
  data_atualizacao timestamp without time zone,
  texto text,
  laudo_json text,
  paciente_json text,
  CONSTRAINT tb_ambulatorio_laudo_integracao_pkey PRIMARY KEY (ambulatorio_laudo_integracao_id)
);

ALTER TABLE ponto.tb_paciente ADD COLUMN paciente_web_id integer;

-- Dia 21/08/2018

ALTER TABLE ponto.tb_aso_setor ADD COLUMN convenio_id integer;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN aso_id integer;

-- Dia 22/08/2018

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'ASO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('ASO', 'CONSULTA');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_paciente ALTER COLUMN convenionumero TYPE text;
ALTER TABLE ponto.tb_paciente ALTER COLUMN cns TYPE text;


CREATE TABLE ponto.tb_laudo_holter
(
  holter text,
  guia_id integer,
  paciente_id integer,
  laudo_holter_id serial primary key  
);

-- Dia 23/08/2018

CREATE TABLE ponto.tb_laudo_cintil
(
  cintil text,
  guia_id integer,
  paciente_id integer,
  laudo_cintil_id serial primary key  
);

CREATE TABLE ponto.tb_laudo_mapa
(
  mapa text,
  guia_id integer,
  paciente_id integer,
  laudo_mapa_id serial primary key  
);

CREATE TABLE ponto.tb_laudo_tergometrico
(
  tergometrico text,
  guia_id integer,
  paciente_id integer,
  laudo_tergometrico_id serial primary key  
);


ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN tipo_aso text;

-- Dia 24/08/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN impressao_cimetra boolean DEFAULT false;

--Dia 27/08/2018

ALTER TABLE ponto.tb_procedimentos_agrupados_ambulatorial ADD COLUMN quantidade_agrupador integer;


UPDATE ponto.tb_procedimentos_agrupados_ambulatorial
   SET  quantidade_agrupador = 1
 WHERE quantidade_agrupador is null;

UPDATE ponto.tb_empresa_permissoes
    SET dados_atendimentomed = '["paciente","idade","sexo","indicacao","exame","nascimento","ocupacao","endereco","estadocivil","convenio","solicitante","sala","telefone"]'
 WHERE dados_atendimentomed is null;

UPDATE ponto.tb_empresa_permissoes
   SET campos_cadastro='["sexo","telefone1"]' 
 WHERE campos_cadastro is null OR campos_cadastro = '';

--Dia 30/08/2018

ALTER TABLE ponto.tb_tuss ADD COLUMN valorfilme numeric(10,4);
ALTER TABLE ponto.tb_tuss ADD COLUMN qtdefilme numeric(10,4);

ALTER TABLE ponto.tb_tuss ADD COLUMN qtdeuco numeric(10,4);
ALTER TABLE ponto.tb_tuss ADD COLUMN valoruco numeric(10,4);

ALTER TABLE ponto.tb_tuss ADD COLUMN qtdeporte text;
ALTER TABLE ponto.tb_tuss ADD COLUMN valorporte numeric(10,4);

ALTER TABLE ponto.tb_tuss ADD COLUMN valor_total numeric(10,4);



ALTER TABLE ponto.tb_convenio ADD COLUMN valor_ajuste_cbhpm_uco numeric;
ALTER TABLE ponto.tb_convenio ADD COLUMN valor_ajuste_cbhpm_filme numeric;

UPDATE ponto.tb_tuss
   SET valor_porte= valorporte
 WHERE valor_porte is null;

SELECT setval('ponto.tb_tuss_tuss_id_seq', (SELECT MAX(tuss_id) FROM ponto.tb_tuss)+1);

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN modelo_laudo_medico boolean DEFAULT false;

--Dia 30/08/2018

CREATE TABLE ponto.tb_setor_cadastro
(
  setor_cadastro_id serial primary key,
  setor_id integer,
  funcao_id integer,
  risco_id text,
  empresa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer  
);

--Dia 03/09/2018

ALTER TABLE ponto.tb_empresa
ALTER COLUMN celular TYPE character varying(16),
ALTER COLUMN telefone TYPE character varying(16);

--Dia 06/09/2018


--Dia 06/09/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN reservar_escolher_proc boolean DEFAULT false;


ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN carimbo boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN manter_indicacao boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN fila_impressao boolean DEFAULT false;

--Dia 08/09/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN medico_solicitante boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN uso_salas boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorio_operadora boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorio_demandagrupo boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorio_rm boolean DEFAULT false;

--Dia 10/09/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorio_caixa boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN enfermagem boolean DEFAULT false;


--------------------------------- FECHANDO A VERSAO 27-----------------------------------------------------

-- Versão 27 


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2806');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Em caso de a clinica possuir procedimentos com valor diferente por empresas, o ajuste no Manter Forma de pagamento deixa de existir.',
            '2806',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2796');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'O cadastro de ASO, Setor e Função é agora relacionado diretamente a Empresa (Convênio). Obs: Apenas para clinicas que trabalham com medicina do trabalho',
            '2796',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2787');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Criado um botão para excluir o modelo de laudo. Configurações->Imagem->Manter Modelo Laudo',
            '2787',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2756');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Na opção de Reservar foi criado a possibilidade de escolher o procedimento caso a opção esteja ativa. (É preciso ser ativo pelo suporte para funcionar)',
            '2756',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2757');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Opção de Reagendar adicionada na multifunção exame',
            '2757',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2761');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'É possível associar o modelo de laudo diretamente ao médico. Então no laudo só aparecem os modelos para aquele médico. Necessário pedir ativação disso em caso de querer utilizar',
            '2761',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2762');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Ao marcar carimbo no laudo é adicionado automaticamente o carimbo cadastrado no médico no texto',
            '2762',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2772');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Antes o agrupador de procedimentos funcionava pegando procedimentos do mesmo grupo do agrupador, ou seja, o agrupador PACOTE necessitava de procedimentos do grupo PACOTE para serem associados a ele. A melhoria consiste na quebra desse requisito e que os procedimentos de diversos grupos possam ser adicionados ao grupo PACOTE.',
            '2772',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2772');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Antes o agrupador de procedimentos funcionava pegando procedimentos do mesmo grupo do agrupador, ou seja, o agrupador PACOTE necessitava de procedimentos do grupo PACOTE para serem associados a ele. A melhoria consiste na quebra desse requisito e que os procedimentos de diversos grupos possam ser adicionados ao grupo PACOTE.',
            '2772',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2781');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'É possível adicionar Agrupadores de procedimento no Gasto de Sala',
            '2781',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2751');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Ao selecionar um modelo de laudo no atendimento médico, você pode clicar para abrir uma tela e mostrar o modelo sem as alterações feitas no laudo',
            '2751',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2752');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'As informações na tela de atendimento de Imagem (Laudo) são configuráveis, então é possível escolher quais opções aparecerão como nome do paciente, convênio e etc.',
            '2752',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2752');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'As informações na tela de atendimento de Imagem (Laudo) são configuráveis, então é possível escolher quais opções aparecerão como nome do paciente, convênio e etc.',
            '2752',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2571');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'No "Mais Opções" na Lista de internação aparecem as informações de Leito, Enfermaria e Unidade, antigamente aparecia apenas unidade',
            '2571',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2653');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Adicionadas várias telas com formulários para a consulta (Necessário pedir ativação para as mesmas). Seguem elas: teste ergometrico, mapa, cintilografia, holter 24h, cateterismo cardíaco, ecocardiograma, exames laboratoriais e cirurgias',
            '2653',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2605');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'No cadastro de pacientes só é permitido o cadastro de CPFs válidos em caso de CPF obrigatório',
            '2605',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();




CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000027');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000027', '1.0.000027');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
