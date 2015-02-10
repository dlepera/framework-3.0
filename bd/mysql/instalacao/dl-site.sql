-- Estrutura de contato
CREATE TABLE IF NOT EXISTS dl_site_assuntos_contato(
    assunto_contato_id INT NOT NULL AUTO_INCREMENT,
    assunto_contato_descr VARCHAR(80) NOT NULL,
    assunto_contato_email VARCHAR(100) NOT NULL,
    assunto_contato_cor VARCHAR(7) NOT NULL DEFAULT '#000',
    assunto_contato_publicar BIT NOT NULL DEFAULT 1,
    assunto_contato_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(assunto_contato_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_site_contatos(
    contato_site_id INT NOT NULL AUTO_INCREMENT,
    contato_site_nome VARCHAR(80) NOT NULL,
    contato_site_email VARCHAR(100) NOT NULL,
    contato_site_telefone VARCHAR(16),
    contato_site_assunto INT NULL,
    contato_site_mensagem LONGTEXT NOT NULL, 
    contato_site_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(contato_site_id),
    CONSTRAINT FK_contato_site_assunto FOREIGN KEY(contato_site_assunto) REFERENCES dl_site_assuntos_contato(assunto_contato_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_site_contatos_leitura(
    leitura_contato INT NOT NULL,
    leitura_contato_id INT NOT NULL AUTO_INCREMENT,
    leitura_contato_usuario INT NOT NULL,
    leitura_contato_data DATETIME NOT NULL,
    PRIMARY KEY(leitura_contato_id),
    CONSTRAINT FK_leitura_contato FOREIGN KEY(leitura_contato) REFERENCES dl_site_contatos(contato_site_id) ON DELETE CASCADE,
    UNIQUE KEY(leitura_contato, leitura_contato_usuario)
) ENGINE=INNODB;

-- Estrutura de dados para contato
CREATE TABLE IF NOT EXISTS dl_site_dados_contato_tipos(
    tipo_dado_id INT NOT NULL AUTO_INCREMENT,
    tipo_dado_descr VARCHAR(30) NOT NULL,
    tipo_dado_icone VARCHAR(255),
    tipo_dado_rede_social BIT NOT NULL DEFAULT 0,
    tipo_dado_mascara VARCHAR(100),
    tipo_dado_expreg VARCHAR(200),
    tipo_dado_publicar BIT NOT NULL DEFAULT 1,
    tipo_dado_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(tipo_dado_id),
    CONSTRAINT CK_tipo_dado_rede_social CHECK( tipo_dado_rede_social IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_site_dados_contato(
    dado_contato_id INT NOT NULL AUTO_INCREMENT,
    dado_contato_tipo INT NOT NULL,
    dado_contato_descr VARCHAR(100) NOT NULL,
    dado_contato_publicar BIT NOT NULL DEFAULT 1,
    dado_contato_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(dado_contato_id),
    CONSTRAINT FK_dado_contato_tipo FOREIGN KEY(dado_contato_tipo) REFERENCES dl_site_dados_contato_tipos(tipo_dado_id)
) ENGINE=INNODB;
    
-- Galeria de fotos
CREATE TABLE IF NOT EXISTS dl_site_albuns(
    album_id INT NOT NULL AUTO_INCREMENT,
    album_nome VARCHAR(50) NOT NULL,
    album_publicar BIT NOT NULL DEFAULT 1,
    album_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(album_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_site_albuns_fotos(
    foto_album INT NOT NULL,
    foto_album_id INT NOT NULL AUTO_INCREMENT,
    foto_album_titulo VARCHAR(50),
    foto_album_descr TEXT,
    foto_album_imagem TEXT NOT NULL,
    foto_album_capa BIT NOT NULL DEFAULT 0,
    foto_album_publicar BIT NOT NULL DEFAULT 1,
    foto_album_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(foto_album_id),
    CONSTRAINT FK_foto_album FOREIGN KEY(foto_album) REFERENCES dl_site_albuns(album_id)
) ENGINE=INNODB;

-- Google Analytics
CREATE TABLE IF NOT EXISTS dl_site_google_analytics(
    ga_id INT NOT NULL AUTO_INCREMENT,
    ga_usuario VARCHAR(100) NOT NULL,
    ga_senha VARCHAR(100) NOT NULL,
    ga_perfil_id INT NOT NULL,
    ga_codigo_ua VARCHAR(15) NOT NULL,
    ga_ativar BIT NOT NULL DEFAULT 1,
    ga_delete BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(ga_id)
) ENGINE=INNODB;