<header id="header">
    <!-- MENU DESKTOP -->
    <div id="container_header_web" class="center">
        <div id="caixa-logo">
            <figure class="center logo">
                <a href="index.php">
                    <img src="icones/logo2.png" alt="logo">
                </a>
            </figure>
        </div>
        <nav id="caixa-menu">
            <ul id="menu" >
                <li class="itens-menu itens-texto">
                    <a class="link-menu" href="index.php">Home</a>
                </li>               
                <li class="itens-menu itens-texto">
                    <a class="link-menu" href="promocoes.php">Promoções</a>
                </li>
                <li class="itens-menu itens-texto">
                    Info
                    <ul class="sub-menu">
                        <li class="sub-item1">
                            <a class="link-menu itens-texto" href="sobre.php">Sobre a Locadora</a>
                        </li>
                        <li class="sub-item2">
                            <a class="link-menu itens-texto" href="lojas.php">Nossas Lojas</a> 
                        </li>
                    </ul>                                           
                </li>
                <li class="itens-menu itens-texto">
                    Extras
                    <ul class="sub-menu">
                        <li class="sub-item1">
                            <a class="link-menu itens-texto" href="ator.php">Ator em Destaque</a>
                        </li>
                        <li class="sub-item2">
                            <a class="link-menu itens-texto" href="filme_mes.php">Filme do Mês</a> 
                        </li>
                    </ul>
                </li>
                <li class="itens-menu itens-texto">
                    <a class="link-menu" href="contatos.php">Contatos</a>
                </li>                   
            </ul>
        </nav>
        <div id="caixa-login">
            <form action="cms/login.php" method="post" name="frmLogin" id="frmLogin">
                <div id="container-usuario">
                    <label for="txt-email" class="label">Email:</label><br>
                    <input type="text" id="txt-email" name="txt-email" class="caixa-texto" placeholder="seu_email@email.com" required>
                </div>
                <div id="container-senha">
                    <label for="txt-senha" class="label">Senha:</label><br>
                    <input type="password" id="txt-senha" name="txt-senha" class="caixa-texto"required>
                    <input type="submit" id="btn-login" name="btn-login" class="btn-login" value="Enviar">
                </div>
            </form>
        </div>
    </div>
    <!-- MENU MOBILE -->
    <div id="container_header_mobile" class="center">
        <div id="caixa-menu" class="menu-anchor"> 
        </div>
        <div id="caixa-logo">
            <figure class="center">
                <a href="index.php">
                    <img src="icones/logo_mobile.png" alt="logo">
                </a>
            </figure>
        </div>
    </div>
</header>
<menu class="menu">
    <ul>
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="promocoes.php">Promoções</a>
        </li>
        <li>
            <a href="sobre.php">Sobre</a>
        </li>
        <li>
            <a href="lojas.php">Lojas</a>
        </li>
        <li>
            <a href="ator.php">Ator em Destaque</a>
        </li>
        <li>
            <a href="filme_mes.php">Fime do Mês</a>
        </li>
        <li>
            <a href="contato.php">Contatos</a>
        </li>
    </ul>
</menu>
