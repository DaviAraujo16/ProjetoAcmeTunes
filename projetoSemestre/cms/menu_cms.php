<?php
    $nivel = $_SESSION['nivel'];
   
    echo("
                <script>
                    $(document).ready(function(){
                        validarNivel(".$nivel.");
                    });
                
                    function validarNivel(nivel){
                        if(nivel == 2){
                            var conteudo = document.getElementById('conteudo_menu');
                            var contato = document.getElementById('contato_menu');
                            var usuario = document.getElementById('usuario_menu');
                
                            conteudo.style.display = 'none';
                            contato.style.display = 'none';
                            usuario.style.display = 'none';  
                        }else if(nivel == 3){
                            var produto = document.getElementById('produto_menu');
                            produto.style.display = 'none';
                        }
                    }
                </script>");
?>                
                <!-- Area do menu CMS -->
                <div id="menu">
                    <nav id="area-menu">
                        <a href="conteudo.php">
                            <div class="itens-menu" id='conteudo_menu'>
                                <div id="icone-menu1">
                                    <figure>
                                        <img src="icones/icone-conteudo.png"/>
                                    </figure>
                                </div>
                                <div class="titulo-menu"> 
                                    <span id="texto-menu1">Adm. Conteudo</span>
                                </div>
                            </div>
                        </a>
                        <a href="fale_conosco_cms.php">    
                            <div class="itens-menu" id='contato_menu'>
                                <div id="icone-menu2">
                                    <figure>
                                        <img src="icones/icone-fale-conosco.png"/>
                                    </figure>
                                </div>
                                <div class="titulo-menu"> 
                                    <span id="texto-menu2">Adm. Contatos</span>
                                    </div>
                            </div>
                        </a>
                        <a href="categoria_cms.php">
                            <div class="itens-menu" id='produto_menu'>
                                <div id="icone-menu3">
                                    <figure>
                                    
                                        <img src="icones/icone-produto.png"/>
                                    </figure>
                                </div>
                                <div class="titulo-menu"> 
                                    <span id="texto-menu3">Adm. Produtos</span>
                                </div>
                            </div>
                        </a>
                        <a href="nivel_usuario_cms.php"> 
                            <div class="itens-menu" id='usuario_menu'>
                                <div id="icone-menu4">
                                    <figure>
                                        <img src="icones/icone-usuarios.png"/>
                                    </figure>
                                </div>
                                <div class="titulo-menu"> 
                                    <span id="texto-menu4">Adm. Usuários</span>
                                </div>
                            </div>
                        </a>
                    </nav>
                    <div id="area-info">
                        <div id="area-bem-vindo">
                            <span id="alinha-texto-bem-vindo">
                                Bem vindo, <?php echo($_SESSION['nome_user']);?>
                            </span>
                        </div>
                        <div id="area-logout">
                            <a id="link-logout" href="../index.php?logout=1" onclick="return confirm('<?php echo($_SESSION['nome_user'])?>, Você realmente deseja Sair do Sistema?')">
                                Logout
                            </a>                           
                        </div>
                    </div>
                </div> 