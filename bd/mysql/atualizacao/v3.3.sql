INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr) VALUES (
    (SELECT func_modulo_id FROM dl_painel_modulos_funcs WHERE func_modulo_classe = 'Admin\\Controle\\Usuario' AND func_modulo_descr = 'Editar conta de usuário'), '_salvar_foto');

ALTER TABLE dl_painel_email_config ADD config_email_debug BOOL NOT NULL DEFAULT 0 AFTER config_email_principal;