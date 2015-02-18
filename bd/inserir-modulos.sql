-- Módulo Desenvolvedor e seus sub-módulos
INSERT INTO dl_painel_modulos VALUES
(22,NULL,'Desenvolvedor','Área para desenvolvedores adicionarem módulos, temas e pacote de idiomas.','','desenvolvedor',99,'','\0'),
(23,22,'Temas','Gerenciar temas do Painel-DL instalados.','','desenvolvedor/temas',0,'','\0'),
(24,22,'Módulos','Gerenciar módulos instalados, ou informar novos módulos do Painel-DL.','','desenvolvedor/modulos',0,'','\0'),
(25,22,'Idiomas','Informar pacotes de idiomas instalados.','','desenvolvedor/idiomas',0,'','\0');

-- Módulo Admin e seus sub-módulos
INSERT INTO dl_painel_modulos VALUES
(26,NULL,'Admin','','','admin',98,'','\0'),
(27,26,'Usuários','Gerenciar contas de usuário.','','admin/usuarios',0,'','\0'),
(28,26,'Grupos de usuários','Gerenciar grupos de usuários e suas permissões.','','admin/grupos-de-usuarios',0,'','\0'),
(29,26,'Envio de e-mails','Configuração SMTP para envios de e-mails através do sistema.','','admin/envio-de-emails',0,'','\0');

-- Módulo Website e seus sub-módulos
INSERT INTO dl_painel_modulos VALUES
(30,NULL,'Website','','','website',0,'','\0'),
(31,30,'Álbuns de fotos','Incluir, editar e remover álbuns de fotos para o site.','','website/albuns-de-fotos',0,'\0','\0'),
(32,30,'Dados para contato','Dados para entrar em contato com o proprietário do site.','','website/dados-para-contato',0,'','\0'),
(33,30,'Contatos recebidos','Lista com todos os contatos recebidos através do formulário do web-site.','','website/contatos-recebidos',0,'','\0'),
(34,30,'Assuntos de contatos','Assuntos que são exibidos no formulário de contato. São utilizados para categorizar  os contatos recebidos, podendo encaminhar cada assunto para um e-mail específico.','','website/assuntos-contato',0,'','\0'),
(35,30,'Google Analytics','Configurações do Google Analytics.','\0','website/google-analytics',0,'','\0'),
(36,30,'Tipos de dados para contato','Tipos de dados para contato. Redes sociais, e-mails, telefones, etc.','\0','website/tipos-de-dados',0,'','\0');