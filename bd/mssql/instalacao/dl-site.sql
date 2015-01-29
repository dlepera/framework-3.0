-- Estrutura de contato
CREATE TABLE dl_site_assuntos_contato(
    assunto_contato_id BIGINT NOT NULL IDENTITY,
    assunto_contato_descr VARCHAR(80) NOT NULL,
    assunto_contato_email VARCHAR(100) NOT NULL,
    assunto_contato_publicar INT NOT NULL DEFAULT 1,
    assunto_contato_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(assunto_contato_id),
    CONSTRAINT CK_assunto_contato_publicar CHECK( assunto_contato_publicar IN(0,1) ),
    CONSTRAINT CK_assunto_contato_delete CHECK( assunto_contato_delete IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE dl_site_contatos(
    contato_site_id BIGINT NOT NULL IDENTITY,
    contato_site_nome VARCHAR(80) NOT NULL,
    contato_site_email VARCHAR(100) NOT NULL,
    contato_site_telefone VARCHAR(16),
    contato_site_assunto BIGINT NOT NULL,
    contato_site_mensagem LONGVARCHAR(255) NOT NULL, 
    contato_site_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(contato_site_id),
    CONSTRAINT FK_contato_site_assunto FOREIGN KEY(contato_site_assunto) REFERENCES dl_site_assuntos_contato(assunto_contato_id),
    CONSTRAINT CK_contato_site_delete CHECK( contato_site_delete IN(0,1) )
) ENGINE=INNODB;

-- Estrutura de dados para contato
CREATE TABLE dl_site_dados_contato_tipos(
    tipo_dado_id BIGINT NOT NULL IDENTITY,
    tipo_dado_descr VARCHAR(30) NOT NULL,
    tipo_dado_icone VARCHAR(255),
    tipo_dado_rede_social INT NOT NULL DEFAULT 0,
    tipo_dado_publicar INT NOT NULL DEFAULT 1,
    tipo_dado_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(tipo_dado_id),
    CONSTRAINT CK_tipo_dado_rede_social CHECK( tipo_dado_rede_social IN(0,1) ),
    CONSTRAINT CK_tipo_dado_publicar CHECK( tipo_dado_publicar IN(0,1) ),
    CONSTRAINT CK_tipo_dado_delete CHECK( tipo_dado_delete IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE dl_site_dados_contato(
    dado_contato_id BIGINT NOT NULL IDENTITY,
    dado_contato_tipo BIGINT NOT NULL,
    dado_contato_descr VARCHAR(100) NOT NULL,
    dado_contato_publicar INT NOT NULL DEFAULT 1,
    dado_contato_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(dado_contato_id),
    CONSTRAINT FK_dado_contato_tipo FOREIGN KEY(dado_contato_tipo) REFERENCES dl_site_dados_contato_tipos(tipo_dado_id),
    CONSTRAINT CK_dado_contato_publicar CHECK( dado_contato_publicar IN(0,1) ),
    CONSTRAINT CK_dado_contato_delete CHECK( dado_contato_delete IN(0,1) )
) ENGINE=INNODB;
    
-- Galeria de fotos
CREATE TABLE dl_site_albuns(
    album_id BIGINT NOT NULL IDENTITY,
    album_nome VARCHAR(50) NOT NULL,
    album_publicar INT NOT NULL DEFAULT 1,
    album_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(album_id),
    CONSTRAINT CK_album_publicar CHECK( album_publicar IN(0,1) ),
    CONSTRAINT CK_album_delete CHECK( album_delete IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE dl_site_albuns_fotos(
    foto_album BIGINT NOT NULL,
    foto_album_id BIGINT NOT NULL IDENTITY,
    foto_album_titulo VARCHAR(50),
    foto_album_descr VARCHAR(255),
    foto_album_imagem VARCHAR(255) NOT NULL,
    foto_album_capa INT NOT NULL DEFAULT 0,
    foto_album_publicar INT NOT NULL DEFAULT 1,
    foto_album_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(foto_album_id),
    CONSTRAINT FK_foto_album FOREIGN KEY(foto_album) REFERENCES dl_site_albuns(album_id),
    CONSTRAINT CK_foto_album_publicar CHECK( foto_album_publicar IN(0,1) ),
    CONSTRAINT CK_foto_album_capa CHECK( foto_album_capa IN(0,1) ),
    CONSTRAINT CK_foto_album_delete CHECK( foto_album_delete IN(0,1) )
) ENGINE=INNODB;