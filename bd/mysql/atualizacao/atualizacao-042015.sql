-- Incluir o campo de preferência do usuário Exibir IDs
ALTER TABLE dl_painel_usuarios ADD usuario_pref_exibir_id BIT NOT NULL DEFAULT 1 AFTER usuario_pref_num_registros;

-- Incluir o campo de preferencia Filtro Menu
ALTER TABLE dl_painel_usuarios ADD usuario_pref_filtro_menu BIT NOT NULL DEFAULT 0 AFTER usuario_pref_exibir_id;

-- Incluir campo para armazenar o último login
ALTER TABLE dl_painel_usuarios ADD usuario_ultimo_login DATETIME AFTER usuario_perfil_foto;


-- Alterações na base de cadastros do Google Analytics
ALTER TABLE dl_site_google_analytics CHANGE ga_ativar ga_principal BIT NOT NULL DEFAULT 0;
ALTER TABLE dl_site_google_analytics ADD ga_publicar BIT NOT NULL DEFAULT 1 AFTER ga_principal;
ALTER TABLE dl_site_google_analytics ADD ga_apelido VARCHAR(100) AFTER ga_id;

-- Incluir o idioma Inglês (USA)
INSERT INTO dl_painel_idiomas (idioma_descr, idioma_sigla) VALUES ('Inglês (USA)', 'en_US');
