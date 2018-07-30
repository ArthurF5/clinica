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