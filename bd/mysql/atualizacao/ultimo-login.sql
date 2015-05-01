-- Incluir campo para armazenar o último login
ALTER TABLE dl_painel_usuarios ADD usuario_ultimo_login DATETIME AFTER usuario_perfil_foto;
