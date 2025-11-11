<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>
        <style>
          
        body{
            background-color: rgba(255, 255, 255, 1);
        }
        H1{
            color: rgb(118, 152, 197);
       
            margin-top: 20px;
        }
        H2{
            color: rgba(0, 0, 0, 1);
       
            margin-top: 20px;
        }

        /*#div_busca{
            margin-top: 30px;
            margin-right: 20px;
            position: absolute;
            top: 10px;
            right:0px;
            display: flex;
            align-items: center;
            gap: 5px;
            size: 25px;
         }*/
 
        #div_busca {
          position: absolute;
          top: 10px;
          right: 10px;
          display: flex;
          align-items: center;
          gap: 20px;
          width: 300px;
          height: 45px;
         }

        #txt_busca {
         flex: 1;
         padding: 10px 12px;
         font-size: 16px;
         border-radius: 6px;
         border: 1px solid #aaa;
         outline: none;
        }

        #btn_Busca {
         width: 40px;
        height: 40px;
        cursor: pointer;
     } 
    </style>
    
</head>
<body>
    <H1>Bem Vindo!</H1>
    <H2> Aqui você pode registrar os livros e filmes que você quer ou já assistiu, tudo num lugar só!</H2>

    <div id = "div_busca" >
        <input type = "text" id = "txt_busca" placeholder= "Buscar..." />
        <img src="../Imagens_HTML/Lupa.png" id="btn_Busca" alt="Buscar"/>
    </div>
    <div id = "barra_comandos">
        <form action = "perfil.php" method = "post">
            <input type="submit" value="Perfil">
        </form>
    </div>
</body>
</html>
