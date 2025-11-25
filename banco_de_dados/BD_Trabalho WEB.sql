
CREATE DATABASE IF NOT EXISTS REGISTRADOR_FILMES_LIVROS_WEB;
USE REGISTRADOR_FILMES_LIVROS_WEB;

CREATE TABLE usuario (
  ID_usuario INT NOT NULL AUTO_INCREMENT,
  Usuario VARCHAR(100) NOT NULL,
  Nome VARCHAR(100) NOT NULL,
  E_mail VARCHAR(100) NOT NULL UNIQUE,
  Senha VARCHAR(255) NOT NULL,
  Tipo_usuario ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (ID_usuario)
);

CREATE TABLE livro (
  ID_Livro INT NOT NULL AUTO_INCREMENT,
  ISBN varchar(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Autor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(999) NOT NULL,
  Idioma VARCHAR(50) NOT NULL,
  Editora VARCHAR(100),
  N_Paginas INT,
  Capa VARCHAR(255),
  PRIMARY KEY (ID_Livro)
);

CREATE TABLE sugestaolivro (
  ID_Livro INT NOT NULL AUTO_INCREMENT,
  ISBN varchar(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Autor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(999) NOT NULL,
  Idioma VARCHAR(50) NOT NULL,
  Editora VARCHAR(100),
  N_Paginas INT,
  Capa VARCHAR(255),
  Status ENUM('validado', 'não validado') NOT NULL DEFAULT 'não validado',
  ID_usuario INT NOT NULL,
  PRIMARY KEY (ID_Livro)
);
ALTER TABLE sugestaolivro
ADD CONSTRAINT fk_usuario_livro
FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE filme (
  ID_filme INT NOT NULL AUTO_INCREMENT,
  IMDb_ID VARCHAR(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Diretor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(999) NOT NULL,
  Idioma_original VARCHAR(50) NOT NULL,
  Ano_de_lancamento INT,
  Poster VARCHAR(255),
  PRIMARY KEY (ID_filme)
);

CREATE TABLE sugestaofilme (
  ID_filme INT NOT NULL AUTO_INCREMENT,
  IMDb_ID VARCHAR(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Diretor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(999) NOT NULL,
  Idioma_original VARCHAR(50) NOT NULL,
  Ano_de_lancamento INT,
  Poster VARCHAR(255),
  status ENUM('validado', 'não validado') NOT NULL DEFAULT 'não validado',
  ID_usuario INT NOT NULL,
  PRIMARY KEY (ID_filme)
);
ALTER TABLE sugestaofilme
ADD CONSTRAINT fk_usuario_filme
FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE lista (
  ID_lista INT NOT NULL AUTO_INCREMENT,
  ID_usuario INT NOT NULL,
  Nome_lista VARCHAR(100) NOT NULL,
  Descricao TEXT NULL,
  Data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID_lista),
  FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE lista_midia (
  ID_lista_midia INT NOT NULL AUTO_INCREMENT,
  ID_lista INT NOT NULL,
  ID_livro INT NULL,
  ID_filme INT NULL,
  Data_consumo DATE NULL,
  Avaliacao INT DEFAULT NULL,
  Resenha TEXT,
  PRIMARY KEY (ID_lista_midia),
  FOREIGN KEY (ID_lista) REFERENCES lista(ID_lista)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_livro) REFERENCES livro(ID_Livro)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (ID_filme) REFERENCES filme(ID_filme)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT chk_avaliacao CHECK (Avaliacao BETWEEN 0 AND 5 OR Avaliacao IS NULL)
);
 select * from livro;
 delete from slivro where ID_usuario = 2;
#UPDATE usuario SET Tipo_usuario = "administrador" WHERE ID_usuario = 1;
#UPDATE usuario SET Tipo_usuario = "administrador" WHERE ID_usuario = 2;
#select * from usuario;


#insert into livro (ISBN, Titulo, Autor,Descricao, Idioma, Editora, N_Paginas, Capa) value (9788584391509, "Os sete maridos de Evelyn Hugo", "Taylor Jenkins Reid",
#"Lendária estrela de Hollywood, Evelyn Hugo sempre esteve sob os holofotes ― seja estrelando uma produção vencedora do Oscar, protagonizando algum escândalo ou aparecendo com um novo marido… pela sétima vez. Agora, prestes a completar oitenta anos e reclusa em seu apartamento no Upper East Side, a famigerada atriz decide contar a própria história ― ou sua “verdadeira história” ―, mas com uma condição: que Monique Grant, jornalista iniciante e até então desconhecida, seja a entrevistadora. Ao embarcar nessa misteriosa empreitada, a jovem repórter começa a se dar conta de que nada é por acaso ― e que suas trajetórias podem estar profunda e irreversivelmente conectadas.
####select * from sugestaolivro;
#delete from livro where ID_Livro = 1;



