-- Incluir campos na tabela dl_site_dados_contato_tipos
ALTER TABLE dl_site_dados_contato_tipos ADD tipo_dado_mascara VARCHAR(100) AFTER tipo_dado_rede_social;
ALTER TABLE dl_site_dados_contato_tipos ADD tipo_dado_expreg VARCHAR(200) AFTER tipo_dado_mascara;