-- Configurações do web-site
DECLARE @MOD INT;
DECLARE @FUNC INT;

SET @MOD := (SELECT MAX(modulo_id) + 1 FROM dl_painel_modulos);
SET @FUNC := (SELECT MAX(func_modulo_id) + 1 FROM dl_painel_modulos_funcs);

CREATE TABLE IF NOT EXISTS dl_site_configuracoes(
    configuracao_id INT NOT NULL,
    configuracao_tema INT NOT NULL DEFAULT 1,
    configuracao_formato_data INT NOT NULL DEFAULT 1,
    PRIMARY KEY(configuracao_id),
    CONSTRAINT FK_configuracao_tema FOREIGN KEY(configuracao_tema) REFERENCES dl_painel_temas(tema_id),
    CONSTRAINT FK_configuracao_formato_data FOREIGN KEY(configuracao_formato_data) REFERENCES dl_painel_formatos_data(formato_data_id)
) ENGINE=INNODB;

-- Configurar o módulo
INSERT INTO dl_painel_modulos (modulo_id, modulo_pai, modulo_nome, modulo_descr, modulo_link) VALUES (@MOD, 30, 'Configurações do website', 'Define algumas configurções para o website, como tema, formato para as data, entre outros.', 'website/configuracoes');
INSERT INTO dl_painel_modulos_funcs (func_modulo, func_modulo_id, func_modulo_descr, func_modulo_classe) VALUES (@MOD, @FUNC, 'Editar as configurções do site', 'WebSite\\Controle\\ConfiguracaoSite');
INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr) VALUES (@FUNC, '_mo strarform'), (@FUNC, '_mostrarlista'), (@FUNC, '_salvar');

INSERT INTO dl_site_configuracoes VALUES (1,1,1);

-- Alternar publicação
INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr)
SELECT func_modulo_id, '_alternarpublicacao'  FROM dl_painel_modulos_funcs WHERE func_modulo_descr LIKE 'Cadastrar e editar%';

-- Corrigir métodos do módulo Institucional
BEGIN
    DECLARE @INST INT;
    DECLARE @VER INT;
    DECLARE @EDIT INT;

    SET @INST := (SELECT modulo_id FROM dl_painel_modulos WHERE modulo_nome = 'Institucional');
    SET @VER := (SELECT func_modulo_id FROM dl_painel_modulos_funcs WHERE func_modulo = @INST AND func_modulo_descr LIKE 'ver%');
    SET @EDIT := (SELECT func_modulo_id FROM dl_painel_modulos_funcs WHERE func_modulo = @INST AND func_modulo_descr LIKE 'editar%');

    DELETE FROM dl_painel_funcs_metodos WHERE metodo_func IN( SELECT func_modulo_id FROM dl_painel_modulos_funcs WHERE func_modulo = @INST );

    INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr) VALUE
    (@VER, '_mostrarlista'), (@VER, '_mostrarinfos'),
    (@EDIT, '_mostrarform'), (@EDIT, '_salvar');
END;
