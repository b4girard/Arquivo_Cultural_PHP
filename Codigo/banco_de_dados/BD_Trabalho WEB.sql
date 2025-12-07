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

insert into livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa) values
("978-8535928358",	"Jantar Secreto", "Raphael Montes", 
" Romance com mais de 100 mil exemplares vendidos, Jantar secreto conta a história de um grupo de amigos que se muda para o Rio de Janeiro
 e passa a organizar jantares misteriosos. Do autor da novela “Beleza Fatal”, da Max e criador da série original Netflix Bom dia, Verônica.
 Um grupo de jovens deixa uma pequena cidade no Paraná para viver no Rio de Janeiro. Eles alugam um apartamento em Copacabana e fazem o 
 possível para pagar a faculdade e manter vivos seus sonhos de sucesso na capital fluminense. Mas o dinheiro está curto e o aluguel 
 está vencido. Para sair do buraco e manter o apartamento, os amigos adotam uma estratégia heterodoxa: arrecadar fundos por meio de 
 jantares secretos, divulgados pela internet para uma clientela exclusiva da elite carioca. A partir daí, eles se envolvem em uma espiral 
 de crimes, descobrem uma rede de contrabando de corpos, matadouros clandestinos e grã-finos excêntricos, e levam ao limite uma índole 
 perversa que jamais imaginaram existir em cada um deles.",	"Português", "Companhia das Letras", 368, 
 "imagens_livro/692b7bc6a845e_jantar_secreto.jpg");
 
 insert into livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa) values
 ("978-8584391509",	"Os sete maridos de Evelyn Hugo", "Taylor Jenkins Reid",	
 "Com todo o esplendor que só a Hollywood do século passado pode oferecer, esta é uma narrativa inesquecível sobre os sacrifícios que 
 fazemos por amor, o perigo dos segredos e o preço da fama. Lendária estrela de Hollywood, Evelyn Hugo sempre esteve sob os holofotes
 ― seja estrelando uma produção vencedora do Oscar, protagonizando algum escândalo ou aparecendo com um novo marido… pela sétima vez.
 Agora, prestes a completar oitenta anos e reclusa em seu apartamento no Upper East Side, a famigerada atriz decide contar a própria
 história ― ou sua “verdadeira história” ―, mas com uma condição: que Monique Grant, jornalista iniciante e até então desconhecida, 
 seja a entrevistadora. Ao embarcar nessa misteriosa empreitada, a jovem repórter começa a se dar conta de que nada é por acaso
 ― e que suas trajetórias podem estar profunda e irreversivelmente conectadas. “Evelyn Hugo faz Elizabeth Taylor parecer sem graça.
 Você vai rir com ela, chorar, sofrer, e então voltar para a primeira página e fazer tudo de novo.” ― Heather Cocks e Jessica Morgan,
 autoras de The Royal We","	Português",	"Paralela",	360,	"imagens_livro/692f852725be3_evelyn_hugo.jpg");
 
 insert into livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa) values
("8535924015", "Dias Perfeitos", "Raphael Montes", "Sombrio e claustrofóbico, Dias perfeitos narra uma história de amor obsessivo e 
paranoico que consolida Raphael Montes como uma das mais gratas surpresas da literatura nacional. Do autor da novela “Beleza Fatal”,
da Max e criador da série original Netflix 'Bom dia, Verônica'. Aos 20 anos, o carioca Raphael Montes impressionou crítica e público 
com Suicidas, um caudaloso romance policial que lhe garantiu vaga entre os dez finalistas do prêmio São Paulo de Literatura na categoria
 autor estreante. Após ler seu primeiro livro, Scott Turow, um dos autores policiais de maior prestígio no mundo, disse que Raphael está
 “entre os mais brilhantes ficcionistas jovens” da atualidade. “Ele certamente redefinirá a literatura policial brasileira e vai surgir 
 como uma figura da cena literária mundial.” Agora, aos 23 anos, ele lança seu segundo livro, Dias perfeitos, romance que confirma seu 
 talento e certamente vai expandir sua já considerável cota de fãs. O protagonista do livro é Téo, um jovem e solitário estudante de 
 medicina que divide seu tempo entre cuidar da mãe paraplégica e dissecar cadáveres nas aulas de anatomia. Num churrasco a que vai com
 a mãe contrariado, Téo conhece Clarice, uma jovem de espírito livre que sonha tornar-se roteirista de cinema. Clarice está escrevendo 
 um road movie de nome “Dias perfeitos”. O texto ainda está cru, mas ela já sabe a história que quer contar: as desventuras de três 
 amigas que viajam de carro pelo país em busca de experiências amorosas. Téo fica viciado em Clarice: quer desvendar aquela menina 
 diferente de todas que conheceu. Começa, então, a se aproximar de forma insistente. Diante das seguidas negativas, opta por uma atitude
 extrema: desfere um golpe na cabeça dela e, ato contínuo, sequestra a garota. Elabora então um plano para conquistá-la: coloca-a sedada
 no banco carona de seu carro e inicia uma viagem pelas estradas do Rio de Janeiro - a mesma viagem feita pelas personagens do roteiro
 de Clarice. Passando por cenários oníricos, entre os quais um chalé em Teresópolis administrado por anões e uma praia deserta e 
 paradisíaca em Ilha Grande, o casal estabelece uma rotina insólita: Téo a obriga a escrever a seu lado e está pronto para sedá-la
 ou prendê-la à menor tentativa de resistência. Clarice oscila entre momentos de desespero e resignação, nos quais corresponde aos 
 delírios conjugais de seu sequestrador. O efeito é tão mais perturbador quanto maior a naturalidade de Téo. Ele fala com calma, 
 planeja os atos com frieza e justifica suas decisões com lógica impecável. A capacidade do autor de explorar uma psique doentia é 
 impressionante - e o mergulho psicológico não impede que o livro siga um ritmo eletrizante, digno dos melhores thrillers da atualidade. 
 Dias perfeitos tem clima sombrio e claustrofóbico, personagens em tensão permanente e diálogos afiados. Angustiante e repleto de 
 reviravoltas, o livro é uma história de amor obsessivo e paranoico que consolida Raphael Montes como uma das mais gratas surpresas da 
 literatura brasileira. “Raphael Montes está entre os mais brilhantes ficcionistas jovens que conheço. Ele certamente redefinirá a 
 literatura policial brasileira e vai surgir como uma figura da cena literária mundial.” - Scott Turowp", 
 "Português","Companhia das Letras",280,"imagens_livro/692f883889df1_dias_perfeitos.jpg");
 
 insert into livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa) values
 ("978-8501112514", "É Assim que Acaba: 1", "Colleen Hoover", 
 " Considerado o livro do ano, que virou febre no TikTok e sozinho já acumulou mais de um milhão de exemplares vendidos no Brasil. 
 É assim que acaba é o romance mais pessoal da carreira de Colleen Hoover, discutindo temas como violência doméstica e abuso psicológico
 de forma sensível e direta. Em É assim que acaba, Colleen Hoover nos apresenta Lily, uma jovem que se mudou de uma cidadezinha do Maine
 para Boston, se formou em marketing e abriu a própria floricultura. E é em um dos terraços de Boston que ela conhece Ryle, um 
 neurocirurgião confiante, teimoso e talvez até um pouco arrogante, com uma grande aversão a relacionamentos, mas que se sente muito
 atraído por ela. Quando os dois se apaixonam, Lily se vê no meio de um relacionamento turbulento que não é o que ela esperava. 
 Mas será que ela conseguirá enxergar isso, por mais doloroso que seja? É assim que acaba é uma narrativa poderosa sobre a força
 necessária para fazer as escolhas certas nas situações mais difíceis. Considerada a obra mais pessoal de Hoover, o livro aborda sem 
 medo alguns tabus da sociedade para explorar a complexidade das relações tóxicas, e como o amor e o abuso muitas vezes coexistem em 
 uma confusão de sentimentos. “Um romance corajoso, de partir o coração, que enfia as garras em você e não te solta... Ninguém escreve
 sobre sentimentos tão bem quanto Colleen Hoover.” -Anna Todd, autora da série After “...Você vai sorrir em meio às lágrimas.”
 - Sarah Pekkanen, autora de Perfect Neighbors “Imperdível. Com um drama fascinante e verdades dolorosas, esse livro retrata de maneira 
 poderosa a devastação que o abuso pode causar - e a força de quem sobrevive a ele...” - Kirkus Review", 
 "Português", "Galera", 368, "imagens_livro/692f88f5f0788_e_assim_que_acaba.jpg");
 
 insert into livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa) values
 ("978-6559101238","Castella", "Min-gyu Park", 
 "Tido como um dos mais inovadores expoentes da literatura coreana moderna, 
 Park Min-Gyu espanta os leitores com sua escrita criativa, cheia de elementos fantásticos. 
 Com uma linguagem coloquial e, ao mesmo tempo, literária, o caráter lúdico de sua escrita, 
 misturado com uma boa dose de cinismo e ironia, presenteia os leitores de 'Castella'
 com contos que revelam as idiossincrasias e a desigualdade social na Coreia do Sul, 
mas que transcendem o espaço físico da península, reverberando até nossas encostas tropicais brasileiras.", 
"Português", "Martin Claret", 416, "imagens_livro/692f898510266_castella.jpg");

insert into livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa) values
("978-6555323283", "Amêndoas", " Won-pyung Sohn",
"Livro recomendado pelo BTS!
 Eu tenho amêndoas em mim.
 Assim como você.
 Assim como quem você ama e quem odeia.
 Mas ninguém consegue senti-las.
 Você só sabe que elas existem.
 Esta história é, em resumo, sobre um monstro encontrando outro monstro. Um dos monstros sou eu.
 Yunjae nasceu com uma condição neurológica chamada alexitimia, ou a incapacidade de identificar e expressar sentimentos, como medo, 
 tristeza, desejo ou raiva. Ele não tem amigos ― as duas estruturas em forma de amêndoas localizadas no fundo de seu cérebro causaram 
 isso ―, mas a mãe e a avó lhe proporcionam uma vida segura e tranquila. O pequeno apartamento em que moram, acima do sebo da mãe, 
 é decorado com cartazes coloridos com lembretes de quando sorrir, quando agradecer e quando demonstrar preocupação.
 Então, no seu décimo sexto aniversário, véspera de Natal, tudo muda. Um ato chocante de violência destrói tudo que Yunjae conhece, deixando-o sozinho. Lutando para lidar com a perda, o garoto se isola no silêncio, até a chegada do problemático colega de escola Gon.
 Conforme começa a se abrir para novas pessoas, algo se modifica lentamente dentro dele. Quando suas novas amizades passam a apresentar níveis de complexidade, Yunjae precisará aprender a lidar com um mundo que não compreende e até se colocar em risco para sair de sua zona de conforto.
 Livro vencedor do Prêmio Changbi de Ficção para Jovens Adultos e Prêmio Jeju 4.3 Peace Literary.
 'Uma obra de ficção ousada e original que mergulha nas profundezas da condição humana com muito humor.' ― Entertainment Weekly",
 "Português", "Rocco", 288, "imagens_livro/692f8a0d832d3_amendoas.jpg");
 
 select *from livro;
 
 insert into filme (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster) values
 ("tt19847976", "Wicked: For Good", "Jon M. Chu",
 "Acompanha Elphaba, a futura Bruxa Má do Oeste, e seu relacionamento com Glinda, a Bruxa Boa do Norte. O segundo de uma adaptação cinematográfica em
 duas partes do musical da Broadway.",
 "Inglês", 2025, "imagens_filme/693055c050206_692f96f3d21eb_wicked2");
 
 
 insert into filme (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster) values
 ("tt0068646" ,"The Godfather", "Francis Ford Coppola", 
 "O patriarca idoso de uma dinastia do crime organizado transfere o controle de seu império clandestino para seu filho relutante.",
 "Inglês", 1972, "imagens_filme/693055b21cded_692f95314498f_o_poderoso_cgefao");
 
 