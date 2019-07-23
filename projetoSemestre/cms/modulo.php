<?php
    //Função que faz upload de foto
    function uparFoto($file){

        //Esse array tem as extensões permitidas para o upload
        $arquivosPermitidos = array(".jpg",".jpeg",".png");
    
        //Esta variável guarda o diretório onde as imagens serão gravadas
        $diretorio = "../imagem/";
    
        //Esta varável recebe o nome completo do arquivo (nome + extensão) que será "upado" para o servidor
        $arquivo = $file['name'];
    
        //Esta varável recebe o tamanho do arquivo que será "upado" para o servidor
        $tamanhoArquivo = $file['size'];
    
        //Aqui o tamanho do arquivo é transformado em kbytes e é arredondado
        $tamanhoArquivo = round($tamanhoArquivo/1024); 
    
        //Essa variável guarda a extensão do arquivo
        $extensaoArquivo = strrchr($arquivo,".");
    
        //Esta variável guarda somente o nome do arquivo, utilizando a função pathinfo
        $nomeArquivo = pathinfo($arquivo,PATHINFO_FILENAME);
    
        //Realiza a criptografia do nome do arquivo
        $arquivoCriptografado = md5(uniqid(time()).$nomeArquivo);
    
        //Esta variável contem o nome criptografado da imagem com sua extensão
        $foto = $arquivoCriptografado . $extensaoArquivo;
    
        //Validação das extenções de arquivos permitidos 
        if(in_array($extensaoArquivo, $arquivosPermitidos)){
            //Validação de tamanho de arquivo(limite máximo de 5mb)
            if($tamanhoArquivo<=5000){
            
                //Esta varivavel contem o nome do diretório temporario em que a imagem foi guardada pelo servidor
                $arquivoTemp = $file['tmp_name'];
            
                //Pega o arquivo que está no diretório temporário e manda ele para o diretório padrão
                if(move_uploaded_file($arquivoTemp, $diretorio.$foto)){                
                                       
                }
                else{
                    echo('<script>alert("Erro ao enviar arquivo para o servidor!!!");</script>');
                       
                }            
            }else{
                echo("<script>alert('Tamanho do Arquivo inválido');</script>");
            }          
        }else{
            echo("<script>alert('Extensão de Arquivo inválida');</script>");
        }
        
        return $foto;
    }
?>