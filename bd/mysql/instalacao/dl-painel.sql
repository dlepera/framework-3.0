    -- Gravar informações do registro
CREATE TABLE IF NOT EXISTS dl_painel_registros_logs(
    log_registro_tabela VARCHAR(100) NOT NULL,
    log_registro_idreg INT NOT NULL,
    log_registro_data_criacao DATETIME NOT NULL,
    log_registro_data_alteracao DATETIME NULL,
    log_registro_data_exclusao DATETIME NULL,
    log_registro_usuario_criacao INT NOT NULL,
    log_registro_usuario_nome_criacao VARCHAR(50) NOT NULL,
    log_registro_usuario_alteracao INT NULL,
    log_registro_usuario_nome_alteracao VARCHAR(50) NOT NULL,
    log_registro_usuario_exclusao INT NULL,
    log_registro_usuario_nome_exclusao VARCHAR(50) NOT NULL,
    log_registro_ip_criacao VARCHAR(15) NOT NULL,
    log_registro_ip_alteracao VARCHAR(15) NULL,
    log_registro_ip_exclusao VARCHAR(15) NULL,
    PRIMARY KEY(log_registro_tabela, log_registro_idreg)
) ENGINE=INNODB;

-- Estrutura da configuração de e-mails
CREATE TABLE IF NOT EXISTS dl_painel_email_config(
    config_email_id INT NOT NULL AUTO_INCREMENT,
    config_email_titulo VARCHAR(30) NOT NULL,
    config_email_host VARCHAR(80) NOT NULL,
    config_email_porta INT NOT NULL DEFAULT 25,
    config_email_autent INT NOT NULL,
    config_email_cripto VARCHAR(5) NOT NULL,
    config_email_conta VARCHAR(100) NOT NULL,
    config_email_senha VARCHAR(20) NOT NULL,
    config_email_de_email VARCHAR(100),
    config_email_de_nome VARCHAR(100),
    config_email_responder_para VARCHAR(100),
    config_email_html BIT NOT NULL DEFAULT 1,
    config_email_principal BIT NOT NULL DEFAULT 0,
    config_email_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(config_email_id)
) ENGINE=INNODB;

-- Logs de tentativas e envios de e-mails
CREATE TABLE IF NOT EXISTS dl_painel_email_logs(
    log_email_id INT NOT NULL AUTO_INCREMENT,
    log_email_config INT NULL,
    log_email_ip VARCHAR(80) NOT NULL,
    log_email_classe VARCHAR(20) NOT NULL,
    log_email_tabela VARCHAR(30),
    log_email_idreg INT,
    log_email_status CHAR(1) NOT NULL DEFAULT 'S',
    log_email_mensagem TEXT,
    PRIMARY KEY(log_email_id),
    CONSTRAINT FK_log_email_config FOREIGN KEY(log_email_config) REFERENCES dl_painel_email_config(config_email_id) ON DELETE SET NULL,
    CONSTRAINT CK_log_email_status CHECK( log_email_status IN('S', 'E', 'F') )
) ENGINE=INNODB;

-- Pacotes de idiomas do sistema
CREATE TABLE IF NOT EXISTS dl_painel_idiomas(
    idioma_id INT NOT NULL AUTO_INCREMENT,
    idioma_descr VARCHAR(20) NOT NULL,
    idioma_sigla VARCHAR(5) NOT NULL,
    idioma_publicar BIT NOT NULL DEFAULT 1,
    idioma_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(idioma_id)
) ENGINE=INNODB;

-- Módulos do sistema
CREATE TABLE IF NOT EXISTS dl_painel_modulos(
    modulo_id INT NOT NULL AUTO_INCREMENT,
    modulo_pai INT DEFAULT NULL,
    modulo_nome VARCHAR(30) NOT NULL,
    modulo_descr TEXT,
    modulo_menu BIT NOT NULL DEFAULT 1,
    modulo_link VARCHAR(100) NOT NULL,
    modulo_ordem INT NOT NULL DEFAULT 0,
    modulo_publicar BIT NOT NULL DEFAULT 1,
    modulo_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY (modulo_id),
    CONSTRAINT FK_modulo_pai FOREIGN KEY(modulo_pai) REFERENCES dl_painel_modulos(modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_painel_modulos_funcs(
    func_modulo INT NOT NULL,
    func_modulo_id INT NOT NULL AUTO_INCREMENT,
    func_modulo_descr VARCHAR(100) NOT NULL,
    func_modulo_classe VARCHAR(100) NOT NULL,
    -- func_modulo_metodo VARCHAR(20) NOT NULL,
    func_modulo_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(func_modulo_id),
    CONSTRAINT FK_func_modulo FOREIGN KEY(func_modulo) REFERENCES dl_painel_modulos(modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_painel_funcs_metodos(
    metodo_func INT NOT NULL,
    metodo_func_id INT NOT NULL AUTO_INCREMENT,
    metodo_func_descr VARCHAR(20) NOT NULL,
    PRIMARY KEY(metodo_func_id),
    CONSTRAINT FK_metodo_func FOREIGN KEY(metodo_func) REFERENCES dl_painel_modulos_funcs(func_modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;

-- Temas do sistema
CREATE TABLE IF NOT EXISTS dl_painel_temas(
    tema_id INT NOT NULL AUTO_INCREMENT,
    tema_descr VARCHAR(20) NOT NULL,
    tema_diretorio VARCHAR(10) NOT NULL,
    tema_padrao BIT NOT NULL DEFAULT 0,
    tema_publicar BIT NOT NULL DEFAULT 1,
    tema_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(tema_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_painel_formatos_data(
    formato_data_id INT NOT NULL AUTO_INCREMENT,
    formato_data_descr VARCHAR(20) NOT NULL,
    formato_data_completo VARCHAR(20) NOT NULL,
    formato_data_data VARCHAR(10) NOT NULL,
    formato_data_hora VARCHAR(10) NOT NULL,
    formato_data_publicar BIT NOT NULL DEFAULT 1,
    formato_data_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(formato_data_id)
) ENGINE=INNODB;

-- Grupos de usuários
CREATE TABLE IF NOT EXISTS dl_painel_grupos_usuarios(
    grupo_usuario_id INT NOT NULL AUTO_INCREMENT,
    grupo_usuario_descr VARCHAR(30) NOT NULL,   
    grupo_usuario_publicar BIT NOT NULL DEFAULT 1,
    grupo_usuario_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(grupo_usuario_id)
) ENGINE=INNODB;

-- Permissionamento padrão por grupo de usuários
CREATE TABLE IF NOT EXISTS dl_painel_grupos_funcs(
    grupo_usuario_id INT NOT NULL,
    func_modulo_id INT NOT NULL,
    PRIMARY KEY(grupo_usuario_id, func_modulo_id),
    CONSTRAINT FK_grupo_usuario_id FOREIGN KEY(grupo_usuario_id) REFERENCES dl_painel_grupos_usuarios(grupo_usuario_id) ON DELETE CASCADE,
    CONSTRAINT FK_func_modulo_id FOREIGN KEY(func_modulo_id) REFERENCES dl_painel_modulos_funcs(func_modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;

-- Cadastro de usuários
CREATE TABLE IF NOT EXISTS dl_painel_usuarios(
    usuario_id INT NOT NULL AUTO_INCREMENT,
    usuario_info_grupo INT NOT NULL,
    usuario_info_nome VARCHAR(50) NOT NULL,
    usuario_info_email VARCHAR(100) NOT NULL,
    usuario_info_telefone VARCHAR(16),
    usuario_info_sexo CHAR(1) NOT NULL,
    usuario_info_login VARCHAR(20) NOT NULL,
    usuario_info_senha VARCHAR(32) NOT NULL, -- 'Hash MD5 dupla da senha do usuário'
    usuario_pref_idioma INT NOT NULL DEFAULT 1,
    usuario_pref_tema INT NOT NULL DEFAULT 1,
    usuario_pref_formato_data INT NOT NULL DEFAULT 1,
    usuario_pref_num_registros INT NOT NULL DEFAULT 20,
    usuario_conf_bloq BIT NOT NULL DEFAULT 0,
    usuario_conf_reset BIT NOT NULL DEFAULT 0,
    usuario_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(usuario_id),
    UNIQUE KEY(usuario_info_email),
    UNIQUE KEY(usuario_info_login),
    CONSTRAINT CK_usuario_info_sexo CHECK( usuario_info_sexo IN('F','M') ),
    CONSTRAINT FK_usuario_info_grupo FOREIGN KEY(usuario_info_grupo) REFERENCES dl_painel_grupos_usuarios(grupo_usuario_id),
    CONSTRAINT FK_usuario_pref_idioma FOREIGN KEY(usuario_pref_idioma) REFERENCES dl_painel_idiomas(idioma_id),
    CONSTRAINT FK_usuario_pref_tema FOREIGN KEY(usuario_pref_tema) REFERENCES dl_painel_temas(tema_id),
    CONSTRAINT FK_usuario_pref_formato_data FOREIGN KEY(usuario_pref_formato_data) REFERENCES dl_painel_formatos_data(formato_data_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_painel_usuarios_recuperacoes(
    recuperacao_id INT NOT NULL AUTO_INCREMENT,
    recuperacao_usuario INT NOT NULL,
    recuperacao_hash VARCHAR(32) NOT NULL,
    recuperacao_status CHAR(1) DEFAULT 'E',  -- 'E => Enviado; C => Cancelado; R => Recuperado; X => Expirado',
    PRIMARY KEY(recuperacao_id),
    UNIQUE KEY(recuperacao_hash),
    CONSTRAINT CK_recuperacao_status CHECK( recuperacao_status IN('E', 'C', 'R', 'X') ),
    CONSTRAINT FK_recuperacao_usuario FOREIGN KEY(recuperacao_usuario) REFERENCES dl_painel_usuarios(usuario_id) ON DELETE CASCADE
) ENGINE=INNODB;