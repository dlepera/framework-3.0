-- Ajustar o nome dos arquivos
UPDATE dl_site_albuns_fotos SET foto_album_imagem = REPLACE(foto_album_imagem, '/web/', 'web/');
UPDATE dl_painel_usuarios SET usuario_perfil_foto = REPLACE(usuario_perfil_foto, '/web/', 'web/');


-- Alterar a forma de autenticação do Google Analytics
ALTER TABLE dl_site_google_analytics ADD ga_p12 VARCHAR(200) NOT NULL AFTER ga_usuario;
ALTER TABLE dl_site_google_analytics DROP ga_senha;
