CREATE DATABASE db_acme_tunes;

USE db_acme_tunes;

CREATE TABLE tbl_fale_conosco(
	cod_sugestao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(100) NOT NULL,
	telefone VARCHAR(100),
	celular VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	home_page VARCHAR(100),
	link_facebook VARCHAR(255),
	sugestao VARCHAR(255) NOT NULL,
	info_produtos VARCHAR(255),
	sexo CHAR NOT NULL,
	profissao VARCHAR(100)
);

CREATE TABLE tbl_sobre(
  cod_pagina INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  titulo_sobre VARCHAR(50) NOT NULL,
  imagem_sobre VARCHAR(50) NOT NULL,
  sub_titulo VARCHAR(25) NOT NULL,
  texto VARCHAR(315) NOT NULL,
  texto_missao VARCHAR(255) NOT NULL,
  texto_visao VARCHAR(255) NOT NULL,
  texto_valores VARCHAR(255) NOT NULL,
  status TINYINT(1) NOT NULL
);

CREATE TABLE tbl_ator(
  cod_ator INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nome_ator VARCHAR(100) NOT NULL,
  sexo CHAR(1) NOT NULL,
  idade INT(3) NOT NULL,
  nacionalidade VARCHAR(50) NOT NULL,
  atividades VARCHAR(255) NOT NULL,
  foto VARCHAR(50) NOT NULL,
  status TINYINT(1) NOT NULL
);

CREATE TABLE tbl_ator_do_mes(
  cod_pagina INT(11) PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  status TINYINT NOT NULL,
  cod_ator INT(11) NOT NULL
);

ALTER TABLE tbl_ator_do_mes ADD CONSTRAINT fk_cod_ator FOREIGN KEY (cod_ator) 
  REFERENCES tbl_ator (cod_ator);

CREATE TABLE tbl_nivel_usuario (
  cod_nivel INT(11) PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  nome_nivel VARCHAR(40) NOT NULL,
  adm_conteudo TINYINT(1) NULL,
  adm_contato TINYINT(1) NULL,
  adm_produto TINYINT(1) NULL,
  adm_usuario TINYINT(1) NULL,
  essencial TINYINT(1) NULL,
  status TINYINT(1) NULL
);

CREATE TABLE tbl_usuario (
  cod_usuario INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nome_usuario VARCHAR(64) NOT NULL,
  email VARCHAR(255) NOT NULL,
  senha VARCHAR(100) NOT NULL,
  status TINYINT(1) NOT NULL,
  cod_nivel INT(11) NOT NULL
);

ALTER TABLE tbl_usuario ADD CONSTRAINT fk_cod_nivel FOREIGN KEY (cod_nivel) 
  REFERENCES tbl_nivel_usuario (cod_nivel);

CREATE TABLE tbl_nossas_lojas (
  cod_pagina INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  titulo_lojas VARCHAR(50) NOT NULL,
  status TINYINT(1) NOT NULL
);

CREATE TABLE tbl_loja (
  cod_loja INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  rua VARCHAR(150) NOT NULL,
  numero VARCHAR(5) NOT NULL,
  cidade VARCHAR(26) NOT NULL,
  descricao VARCHAR(25) NOT NULL,
  status TINYINT NOT NULL
  );

CREATE TABLE tbl_rel_loja(
  cod_pagina INT(11) NOT NULL,
  cod_loja INT(11) NOT NULL
);

ALTER TABLE tbl_rel_loja ADD CONSTRAINT fk_cod_pagina FOREIGN KEY (cod_pagina) 
  REFERENCES tbl_nossas_lojas (cod_pagina);

ALTER TABLE tbl_rel_loja ADD CONSTRAINT fk_cod_loja FOREIGN KEY (cod_loja) 
  REFERENCES tbl_loja (cod_loja);


CREATE TABLE tbl_produto(
    cod_produto INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(50) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    imagem_filme VARCHAR(60) NOT NULL,
    status TINYINT(1) NOT NULL,
    duracao VARCHAR(10) NOT NULL,
    preco FLOAT NOT NULL,
    dt_lancamento VARCHAR(10) NOT NULL,
    diretor VARCHAR(100) NOT NULL,
    status_promocao TINYINT(1) NOT NULL,
    status_destaque TINYINT(1) NOT NULL,
    imagem_filme_destaque VARCHAR(60) NOT NULL
);

CREATE TABLE tbl_clicks(
    cod_click INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    quantidade_clicks INT(20) NOT NULL,
    cod_produto INT(11) NOT NULL
);

ALTER TABLE tbl_clicks ADD CONSTRAINT fk_cod_produto_click FOREIGN KEY (cod_produto)
    REFERENCES tbl_produto (cod_produto);

CREATE TABLE tbl_promocao(
  cod_promocao INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  valor_promocao INT(2) NOT NULL,
  status TINYINT(1) NOT NULL,
  cod_produto INT(11) NOT NULL,
	valor_promocional DOUBLE NULL
);

ALTER TABLE tbl_promocao ADD CONSTRAINT fk_cod_produto FOREIGN KEY (cod_produto)
   REFERENCES tbl_produto (cod_produto);


CREATE TABLE tbl_categoria(
  cod_categoria INT NOT NULL PRIMARY KEY  AUTO_INCREMENT,
  nome_categoria VARCHAR(60) NOT NULL,
  descricao VARCHAR(500) NULL,
  status TINYINT(1) NOT NULL
);


CREATE TABLE tbl_sub_categoria(
  cod_sub_categoria INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome_sub_categoria VARCHAR(60) NOT NULL,
  descricao VARCHAR(500) NULL,
  cod_categoria INT(11) NULL,
  status TINYINT(1) NOT NULL
);

CREATE TABLE tbl_relacao_produto(
  cod_relacao_produto INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cod_sub_categoria INT(11) NOT NULL,
  cod_produto INT(11) NOT NULL,
  cod_categoria INT(11) NOT NULL,
  status TINYINT(1) NOT NULL
);


ALTER TABLE tbl_sub_categoria ADD CONSTRAINT fk_cod_categoria FOREIGN KEY (cod_categoria)
    REFERENCES tbl_categoria (cod_categoria);
  
ALTER TABLE tbl_relacao_produto ADD CONSTRAINT fk_cod_sub_categoria FOREIGN KEY (cod_sub_categoria) 
    REFERENCES tbl_sub_categoria (cod_sub_categoria);

ALTER TABLE tbl_relacao_produto ADD CONSTRAINT fk_cod_relacao_produto FOREIGN KEY (cod_produto)
    REFERENCES tbl_produto (cod_produto);


INSERT INTO tbl_nivel_usuario(nome_nivel, adm_conteudo, adm_contato, adm_produto, adm_usuario, essencial, status) VALUES ('Administrador', 1, 1, 1, 1, 1, 1);
INSERT INTO tbl_nivel_usuario(nome_nivel, adm_conteudo, adm_contato, adm_produto, adm_usuario, essencial, status) VALUES ('Cataloguista', 0, 0, 1, 0, 1, 1);
INSERT INTO tbl_nivel_usuario(nome_nivel, adm_conteudo, adm_contato, adm_produto, adm_usuario, essencial, status) VALUES ('Operador Básico', 1, 1, 0, 1, 1, 1);
INSERT INTO tbl_usuario(nome_usuario, email, senha, status, cod_nivel) VALUES ('Davi','davi@gmail.com', '698dc19d489c4e4db73e28a713eab07b', 1, 1);
INSERT INTO tbl_usuario(nome_usuario, email, senha, status, cod_nivel) VALUES ('root','root@root.com', '63a9f0ea7bb98050796b649e85481845', 1, 1);
INSERT INTO tbl_sobre (titulo_sobre, imagem_sobre, sub_titulo,texto_missao, texto_visao, texto_valores, status, texto) VALUES ('Sobre a Empresa', '60c926c1d671e696e65b4f10f66462ea.jpg', 'Acme Tunes', 'Entregar o melhor produto para nossos clientes.', 'Ser um modelo no mercado de venda e locação de filmes na internet.', 'Qualidade, Agilidade,Fidelidade e Comprometimento com nossos clientes.', 1, 'A Acme Tunes é uma empresa de Locação e Venda de Filmes. A Acme iniciou seu serviços em 2002 e permanece até os dias de hoje, sempre visando a melhoria do nosso modelo de negocio. Recentemente a empresa decidiu expandir seu negócio para o e-commerce afim de utilizar a internet a seu favor.');
INSERT INTO tbl_ator (nome_ator, sexo, idade, nacionalidade, atividades, foto, status) VALUES ('Jhonny Depp', 'M', '55', 'Americano', 'Ator, Diretor, Músico', 'fc8c246a5861fbdcad4cabf5cff46314.jpg', 1);
INSERT INTO tbl_loja (rua, numero, cidade,descricao,status) VALUES ('Av. Luis Carlos Berrini', '1511', 'São Paulo','Matriz', 0);
INSERT INTO tbl_rel_loja (cod_pagina,cod_loja) VALUES ((SELECT MAX(cod_pagina) FROM tbl_nossas_lojas), '2');
INSERT INTO tbl_categoria (nome_categoria, descricao, status) VALUES ('Filmes em VHS', 'Filmes em VHS' , '1');
INSERT INTO tbl_categoria (nome_categoria, descricao, status) VALUES ('Filmes em DVD', ' Filmes em DVD ' , '1');
INSERT INTO tbl_categoria (nome_categoria, descricao, status) VALUES ('Filmes em Blu-Ray', 'Filmes em Blu-Ray' , '1');
INSERT INTO tbl_sub_categoria (nome_sub_categoria, descricao, cod_categoria, status) VALUES ('Aventura', 'aventura ' , '1', '1');
INSERT INTO tbl_sub_categoria (nome_sub_categoria, descricao, cod_categoria, status) VALUES ('Ação', ' Ação' , '2', '1');
INSERT INTO tbl_sub_categoria (nome_sub_categoria, descricao, cod_categoria, status) VALUES ('Suspense', 'Suspense' , '3', '1');
INSERT INTO tbl_produto (titulo, descricao, duracao, preco, dt_lancamento, diretor, status, imagem_filme, status_promocao, status_destaque, imagem_filme_destaque) VALUES ('Vingadores Ultimato', 'Após Thanos eliminar metade das criaturas vivas, os Vingadores têm de lidar com a perda de amigos e entes queridos. Com Tony Stark vagando perdido no espaço sem água e comida, Steve Rogers e Natasha Romanov lideram a resistência contra o titã louco.', '03:20', '55.55', '25/04/2019', 'Anthony Russo e Joe Russo', 1, 'fd1f6695b6fa9ca8a4694f92c4a41848.jpg', 0, 0, '5b8e929f1db80c075a8fd3f402288a65.jpg');
INSERT INTO tbl_clicks (quantidade_clicks, cod_produto) VALUES (0, (SELECT MAX(cod_produto) FROM tbl_produto));
INSERT INTO tbl_produto (titulo, descricao, duracao, preco, dt_lancamento, diretor, status, imagem_filme, status_promocao, status_destaque, imagem_filme_destaque) VALUES ('Wifi Ralph', 'Ralph, o mais famoso vilão dos videogames, e Vanellope, sua companheira atrapalhada, iniciam mais uma arriscada aventura. Após a gloriosa vitória no Fliperama Litwak, a dupla viaja para a world wide web, no universo expansivo e desconhecido da internet. Dessa vez, a missão é achar uma peça reserva para salvar o videogame Corrida Doce, de Vanellope.', '01:56', '33.33', '03/01/2019', ' Rich Moore e Phil Johnston', 1, 'f62eb22ace34e240dfbb4661d3f4a8d6.png', 0, 0, 'bd57026322ee5b3e8b7168392b0a8932.jpg');
INSERT INTO tbl_clicks (quantidade_clicks, cod_produto) VALUES (0, (SELECT MAX(cod_produto) FROM tbl_produto));
INSERT INTO tbl_produto (titulo, descricao, duracao, preco, dt_lancamento, diretor, status, imagem_filme, status_promocao, status_destaque, imagem_filme_destaque) VALUES ('Alita Anjo de Combate', 'Uma ciborgue é descoberta por um cientista. Ela não tem memórias de sua criação, mas possui grande conhecimento de artes marciais. Enquanto busca informações sobre seu passado, trabalha como caçadora de recompensas e descobre um interesse amoroso', '02:20', '40.40', '14/02/2019', 'Robert Rodriguez', 1, 'f9da261a2fe2440037040d06339ae3f4.jpg', 0, 0, '357e40e867c94007a9e75a479ba2e4a2.png');
INSERT INTO tbl_clicks (quantidade_clicks, cod_produto) VALUES (0, (SELECT MAX(cod_produto) FROM tbl_produto));
INSERT INTO tbl_relacao_produto (cod_sub_categoria, cod_categoria, cod_produto, status) VALUES ('1', '1', '1', '1');
INSERT INTO tbl_relacao_produto (cod_sub_categoria, cod_categoria, cod_produto, status) VALUES ('3', '2', '2', '1');
INSERT INTO tbl_relacao_produto (cod_sub_categoria, cod_categoria, cod_produto, status) VALUES ('4', '3', '3', '1');




SELECT * FROM tbl_usuario;





SELECT promo.cod_promocao, promo.valor_promocao, promo.status, filme.titulo FROM tbl_promocao AS promo INNER JOIN tbl_filme AS filme ON promo.cod_filme = filme.cod_filme;

select * from tbl_promocao;


DELETE FROM tbl_usuario WHERE cod_usuario = 1;
SELECT * FROM tbl_usuario;