-- Incluir os idiomas padrões
INSERT INTO dl_painel_idiomas (idioma_descr, idioma_sigla) VALUES
('Português (Brasil)', 'pt-BR'), ('Inglês (EUA)', 'en-US');

-- Incluir os temas disponíveis
INSERT INTO dl_painel_temas (tema_descr, tema_diretorio, tema_padrao) VALUES
('Painel-DL 2.0', 'painel-2/', 1), ('DL-Admin', 'dladmin/', 0), ('Painel-DL 1.0', 'painel/', 0);

-- Inserir os formatos de datas
INSERT INTO dl_painel_formatos_data (formato_data_descr, formato_data_completo, formato_data_data, formato_data_hora) VALUES
('dd/mm/aaaa hh:mm', 'd/m/Y H:i', 'd/m/Y', 'H:i'), ('aaaa-mm-dd hh:mm:ss', 'Y-m-d H:i:s', 'Y-m-d', 'H:i:s');
