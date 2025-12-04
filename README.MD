INTRODUÇÃO
O presente relatório apresenta a modelagem do sistema “Site de Avaliações e Catálogo de Obras”, cujo objetivo é permitir que usuários avaliem e consultem informações sobre filmes, séries e livros. O documento descreve o mini-mundo, os cenários envolvidos, os casos de uso que representam as funcionalidades principais e o comportamento do sistema, conforme solicitado pela disciplina de Programação.

1.1 Cenário Principal
O usuário acessa o site e visualiza uma tela inicial onde pode realizar login utilizando nome de usuário, e-mail e senha. Ao entrar na plataforma, ele tem acesso à página inicial com recomendações de filmes, séries e livros, além de uma barra de pesquisa que permite filtrar obras por título, gênero ou autor.
Ao selecionar uma obra, o usuário é direcionado para uma página específica onde pode visualizar suas informações e realizar uma avaliação, composta por nota e comentário. O comentário fica visível tanto na página da obra quanto no perfil do usuário.
A aba “Minhas Avaliações” permite ao usuário visualizar todas as avaliações feitas, com a opção de editar ou excluir cada registro. Na seção “Meu Perfil”, é possível modificar dados pessoais, como nome de usuário e e-mail.

1.2 Cenário Alternativo
Caso o usuário tente acessar páginas restritas sem estar autenticado, o sistema exibe uma mensagem informando que é necessário realizar login e o redireciona para a área de autenticação.
Se os dados informados no login estiverem incorretos, o sistema apresenta mensagem de erro, permitindo nova tentativa ou acionando a recuperação de senha por e-mail. Caso o usuário não possua cadastro, ele é orientado a criar uma conta para continuar.
