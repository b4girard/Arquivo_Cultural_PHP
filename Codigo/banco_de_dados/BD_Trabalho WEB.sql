CREATE DATABASE REGISTRADOR_FILMES_LIVROS_WEB;
USE REGISTRADOR_FILMES_LIVROS_WEB;

-- Tabela de usuários
CREATE TABLE usuario (
  ID_usuario INT NOT NULL AUTO_INCREMENT,
  Usuario VARCHAR(100) NOT NULL,
  Nome VARCHAR(100) NOT NULL,
  E_mail VARCHAR(100) NOT NULL UNIQUE,
  Senha VARCHAR(255) NOT NULL,
  Tipo_usuario ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (ID_usuario)
);

-- Tabela de livros
CREATE TABLE livro (
  ID_Livro INT NOT NULL AUTO_INCREMENT,
  ISBN VARCHAR(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Autor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(9999) NOT NULL,
  Idioma VARCHAR(50) NOT NULL,
  Editora VARCHAR(100),
  N_Paginas INT,
  Capa VARCHAR(255),
  PRIMARY KEY (ID_Livro)
);

-- Tabela de sugestões de livros
CREATE TABLE sugestaolivro (
  ID_Livro INT NOT NULL AUTO_INCREMENT,
  ISBN VARCHAR(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Autor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(9999) NOT NULL,
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

-- Tabela de filmes
CREATE TABLE filme (
  ID_filme INT NOT NULL AUTO_INCREMENT,
  IMDb_ID VARCHAR(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Diretor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(9999) NOT NULL,
  Idioma_original VARCHAR(50) NOT NULL,
  Ano_de_lancamento INT,
  Poster VARCHAR(255),
  PRIMARY KEY (ID_filme)
);

-- Tabela de sugestões de filmes
CREATE TABLE sugestaofilme (
  ID_filme INT NOT NULL AUTO_INCREMENT,
  IMDb_ID VARCHAR(20) NOT NULL,
  Titulo VARCHAR(150) NOT NULL,
  Diretor VARCHAR(100) NOT NULL,
  Descricao VARCHAR(9999) NOT NULL,
  Idioma_original VARCHAR(50) NOT NULL,
  Ano_de_lancamento INT,
  Poster VARCHAR(255),
  Status ENUM('validado', 'não validado') NOT NULL DEFAULT 'não validado',
  ID_usuario INT NOT NULL,
  PRIMARY KEY (ID_filme)
);
ALTER TABLE sugestaofilme
ADD CONSTRAINT fk_usuario_filme
FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

-- Tabela de listas
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

-- Tabela de relacionamento lista x mídia (livros e filmes)
CREATE TABLE lista_midia (
  ID_lista_midia INT NOT NULL AUTO_INCREMENT,
  ID_lista INT NOT NULL,
  ID_livro INT NULL,
  ID_filme INT NULL,
  PRIMARY KEY (ID_lista_midia),
  FOREIGN KEY (ID_lista) REFERENCES lista(ID_lista)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_livro) REFERENCES livro(ID_Livro)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (ID_filme) REFERENCES filme(ID_filme)
    ON DELETE SET NULL ON UPDATE CASCADE
);

-- Tabela de avaliações
CREATE TABLE avaliacao (
  ID_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
  ID_usuario INT NOT NULL,
  ID_livro INT NULL,
  ID_filme INT NULL,
  Nota TINYINT NOT NULL,         -- 1 a 5
  Comentario TEXT,
  Data_avaliacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ID_usuario) REFERENCES usuario(ID_usuario),
  FOREIGN KEY (ID_livro) REFERENCES livro(ID_livro),
  FOREIGN KEY (ID_filme) REFERENCES filme(ID_filme)
);
select * from usuario;
select * from sugestaolivro;
UPDATE usuario SET Tipo_usuario = "administrador" WHERE ID_usuario=2;

delete from sugestaolivro where ID_Livro = 1;


