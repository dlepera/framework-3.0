-- Incluir foto no cadastro do usuário
ALTER TABLE dl_painel_usuarios ADD usuario_perfil_foto VARCHAR(255) NOT NULL DEFAULT '/aplicacao/imgs/usuario-sem-foto.png' AFTER usuario_conf_reset;
