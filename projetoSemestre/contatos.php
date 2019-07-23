<?php

    //Conexão com o Banco
    require_once("bd/conexao.php");
    $conexao = conexaoMysql();

    //Declaração de Variáveis
    $nome = null;
    $telefone = null;
    $celular = null;
    $email = null;
    $homePage = null;
    $linkFacebook = null;
    $infoProdutos = null;
    $sexo = null;
    $profissao = null;
    $sugestao = null;


    if(isset($_GET['btn-enviar'])){
        $nome = $_GET['txt-nome'];
        $telefone = $_GET['txt-telefone'];
        $celular = $_GET['txt-celular'];
        $email = $_GET['txt-email'];
        $homePage = $_GET['txt-home-page'];
        $linkFacebook = $_GET['txt-facebook'];
        $infoProdutos = $_GET['txt-info-produtos'];
        $sexo = $_GET['rdo-sexo'];
        $profissao = $_GET['txt-profissao'];
        $sugestao = $_GET['txt-sugestao'];

        //variável sql
        $sqlInsert = 
        "INSERT INTO tbl_fale_conosco(
            nome,
            telefone,
            celular,
            email,
            home_page,
            link_facebook,
            info_produtos,
            sexo,
            profissao,
            sugestao
        )VALUES(
            '".$nome."',
            '".$telefone."',
            '".$celular."',
            '".$email."',
            '".$homePage."',
            '".$linkFacebook."',
            '".$infoProdutos."',
            '".$sexo."',
            '".$profissao."',
            '".$sugestao."'
        )";
        //Execução do script SQL
        if(mysqli_query($conexao, $sqlInsert)){
            echo(
                "<script>
                    alert('Seu Registro foi Enviado com Sucesso!');
                </script>"
            );
        }else{
            echo(
                "<script>
                    alert('Erro de Envio!');
                </script>"
            );
        }
       
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Fale Conosco | Acme Tunes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style-padrao.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/contChar.js"></script>
        <script src="js/validaCaixa.js"></script>
    </head>
    <body>
        <div id="all" >
            <?php include_once("header.php");?>
            <div class="con"></div>
            <div id="container_contato" class="center" style="margin-bottom:200px;">
                <div id="section-conteudo_contato">
                    <div id="area-contato">
                        <section id="email">
                            <div class="caixa-titulo-contato">
                                <div class="icone-contato">
                                    <figure>
                                        <img src="icones/email.png" alt="Email">
                                    </figure>    
                                </div>
                                <div id="titulo-contato1">
                                    <h2 class="formatacao-contato">
                                        Email
                                    </h2>
                                    <hr>
                                </div>
                            </div>
                            <div class="caixa-info-contato">
                                <div id="telefone1" class="center">
                                    <span class="email-diagramacao">Email : acme_locadora@gmail.com </span>
                                </div>
                                <div  id="telefone2" class="center">
                                    <span class="email-diagramacao">SAC : sac_acme@gmail.com </span>
                                </div>                                 
                            </div>
                        </section>
                        <section id="telefone">
                            <div class="caixa-titulo-contato">
                                <div class="icone-contato">
                                    <figure>
                                        <img src="icones/contato.png" alt="Contato">
                                    </figure>  
                                </div>
                                <div id="titulo-contato2" >
                                    <h2 class="formatacao-contato">
                                    Contato</h2>
                                    <hr>
                                </div>
                            </div>
                            <div class="caixa-info-contato">
                                <div id="email1" class="center">
                                    <span class="email-diagramacao">Telefone : (11) 3665-7821 </span>
                                </div>
                                <div  id="email2" class="center">
                                    <span class="email-diagramacao">SAC : 0800 077 6341</span>
                                </div>
                            </div>
                        </section>
                    </div>
                    <section id="area-fale-conosco">
                        <div class="area-titulo">
                            <div class="icone-contato">
                                <figure>
                                    <img src="icones/comment.png" alt="Email">
                                </figure>    
                            </div>
                            <div id="titulo-form">
                                <h2 class="formatacao-contato">
                                    Fale Conosco
                                </h2>
                                <hr style="width:1022px;">
                            </div>
                        </div>   
                        <div class="area-form">
                            <form action="contatos.php" method="get">
                                <div class="linha-form">
                                    <div class="caixa1">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-nome">Nome:*</label>
                                        </div>
                                        <div class="ajusta-form">
                                            <input type="text" name="txt-nome" id="txt-nome" required placeholder="Digite seu nome" class="caixa-texto-form1" pattern="[a-z A-Z]*">
                                        </div>
                                    </div>
                                    <div class="caixa2">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-telefone">Telefone:</label>
                                        </div>
                                        <div class="ajusta-form2">
                                            <input type="text" name="txt-telefone" id="txt-telefone" placeholder="000000-0000" class="caixa-texto-form2" pattern="[0-9]{2}[0-9]{4}-[0-9]{4}" onkeypress="return validarCaixa(event);">
                                        </div>
                                    </div>
                                    <div class="caixa3">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-celular">Celular:*</label>
                                        </div>
                                        <div class="ajusta-form3">
                                            <input type="text" name="txt-celular" id="txt-celular" required placeholder="0090000-0000" class="caixa-texto-form3" pattern="[0-9]{2}[9][0-9]{4}-[0-9]{4}" onkeypress=" return validarCaixa(event); ">
                                        </div>
                                    </div>
                                </div>
                                <div class="linha-form">
                                    <div class="caixa1">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-email">Email:*</label>
                                        </div>
                                        <div class="ajusta-form">
                                            <input type="email" name="txt-email" id="txt-email" required placeholder="Digite seu Email" class="caixa-texto-form1">
                                        </div>
                                    </div>
                                    <div class="caixa2">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-home-page">Home Page:</label>
                                        </div>
                                        <div class="ajusta-form2">
                                            <input type="url" name="txt-home-page" id="txt-home-page" placeholder="Digite o link de sua Page" class="caixa-texto-form2">
                                        </div>
                                    </div>
                                    <div class="caixa3">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-facebook">Link do Facebook:</label>
                                        </div>
                                        <div class="ajusta-form3">
                                            <input type="url" name="txt-facebook" id="txt-facebook" placeholder="Digite seu link facebook" class="caixa-texto-form3">
                                        </div>
                                    </div>
                                </div>
                                <div class="linha-form">
                                    <div class="caixa1">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-info-produtos">Produtos:</label>
                                        </div>
                                        <div class="ajusta-form">
                                            <input type="text" name="txt-info-produtos" id="txt-info-produtos" required placeholder="Digite as informações do produto" class="caixa-texto-form1">
                                        </div>
                                    </div>
                                    <div class="caixa2">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao">Sexo:*</label>
                                        </div>
                                        <div class="ajusta-form2">
                                            <input class="radio" type="radio" name="rdo-sexo" value="M" checked>Masculino<br>
                                            <input class="radio" type="radio" name="rdo-sexo" value="F">Feminino
                                        </div>
                                    </div>
                                    <div class="caixa3">
                                        <div class="ajusta-label">
                                            <label class="label-formatacao" for="txt-profissao">Profissão:*</label>
                                        </div>
                                        <div class="ajusta-form3">
                                            <input type="text" name="txt-profissao" id="txt-profissao" required placeholder="Digite sua profissão" class="caixa-texto-form3" pattern="[a-z A-Z]*">
                                        </div>
                                    </div>
                                </div>
                                <div id="linha-form-textarea">
                                    <div class="caixa-textarea">
                                        <div id="ajusta-label2">
                                            <label class="label-formatacao" for="txt-sugestao">Sugestão / Crítica:</label>
                                        </div>
                                        <div id="ajusta-textarea">
                                            <textarea class="formatacao" name="txt-sugestao" id="txt-sugestao" required></textarea><br>
                                            <div id="contador-char">
                                                <span class="caracteres"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="caixa-botao">
                                        <input type="submit" name="btn-enviar" value="Enviar" class="btn-enviar">
                                    </div>
                                </div>   
                            </form>   
                        </div>                     
                    </section>                          
                </div>
            </div>
            <div class="con" ></div>
             <?php include_once("footer.php");?>  
        </div>
    </body>
</html>