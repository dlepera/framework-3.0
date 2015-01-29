-- Incluir o módulo Admin e seus sub-módulos
INSERT INTO dl_painel_modulos(modulo_pai, modulo_nome, modulo_descr, modulo_link) VALUES
(NULL, 'Admin', 'Módulo de administração do sistema. Gerencia opções como configurações de e-mail, usuários e permissionamentos.', 'admin'),
(1, 'Usuários', 'Gerencia as contas de usuário do sistema.', 'admin/usuarios/lista'),
(1, 'Envio de e-mails', 'Configurações de envios de e-mails pelo sistema.\nConfigurar servidores SMTP para enviar e-mails.', 'admin/emails/lista'),
(1, 'Grupos de usuários', 'Gerenciar grupos de usuários, podendo definir permissionamentos padrões para os usuário que forem incluídos no grupo.', 'admin/grupos-de-usuarios/lista');


-- Incluir módulo web-site e seus sub-módulos
INSERT INTO dl_painel_modulos(modulo_pai, modulo_nome, modulo_descr, modulo_link) VALUES
(NULL, 'Website', 'Gerenciar conteúdo exibido e recebido no site, como formas de contato, contatos recebidos, galerias de fotos e muito mais!', 'web-site'),
(5, 'Contatos recebidos', 'Lista dos contatos recebidos através do formulário de contato do site. É possível verificar se houve falha no envio do e-mail, qual foi a falha encontrada e remover contatos não desejados.', 'web-site/contatos-recebidos/lista'),
(5, 'Dados para contato', 'Dados para contato que serão exibidos no site.\nEx.: e-mails, telefones e redes sociais.', 'web-site/dados-para-contato/lista'),
(5, 'Assuntos de contatos', 'Assuntos de contatos estão disponíveis na tela de contato do site e cada assunto pode direcionar para um e-mail diferente. Ideal para vínculo com gerenciadores de chamado ou segmentação dos retornos.', 'web-site/assuntos-de-contatos/lista'),
(5, 'Álbuns de fotos', 'Criar, editar e/ou remover álbuns de fotos que deverão ser exibidas no site.', 'web-site/albuns-de-fotos/lista'),
(5, 'Formas de contato', 'Define os tipos de dados para contato, por exemplo, telefone, e-mail, skype, etc...\nEssas opções serão exibidas na combobox Tipo de dado" do cadastro de "Dados para contato".', 'web-site/formas-de-contato/lista');