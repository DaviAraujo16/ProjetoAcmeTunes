function contadorCaracteres(idCaixa){
    var limite;
    var informativo;
    var caracteresDigitados;
    var caracteresRestantes;

    if(idCaixa  == "txt-texto"){
        limite = 315;
        informativo = "/ 315";
        caracteresDigitados = $("#" + idCaixa).val().length;
        caracteresRestantes = limite - caracteresDigitados;

        if (caracteresRestantes <= 0){
            var comentario = $("textarea[name=txt-texto]").val();
            $("textarea[name=txt-texto]").val(comentario.substr(0, limite));
            $("#cont-texto").text("0 " + informativo);
        }else{
            $("#cont-texto").text(caracteresRestantes + " " + informativo);
        }
    }else if(idCaixa == "txt-descricao"){
        limite = 25;
        informativo = "/ 25";
        caracteresDigitados = $("#" + idCaixa).val().length;
        caracteresRestantes = limite - caracteresDigitados;

        if (caracteresRestantes <= 0){
            var comentario = $("textarea[name=txt-descricao]").val();
            $("textarea[name=txt-descricao]").val(comentario.substr(0, limite));
            $("#cont-descricao").text("0 " + informativo);
        }else{
            $("#cont-descricao").text(caracteresRestantes + " " + informativo);
        }
    }else if(idCaixa == "txt-descricao-produto"){
        limite = 500;
        informativo = "/ 500";
        caracteresDigitados = $("#" + idCaixa).val().length;
        caracteresRestantes = limite - caracteresDigitados;

        if (caracteresRestantes <= 0){
            var comentario = $("textarea[name=txt-descricao-produto]").val();
            $("textarea[name=txt-descricao-produto]").val(comentario.substr(0, limite));
            $("#cont-produto").text("0 " + informativo);
        }else{
            $("#cont-produto").text(caracteresRestantes + " " + informativo);
        }
    }else{
        limite = 255;
        informativo = "/ 255";
        caracteresDigitados = $("#" + idCaixa).val().length;
        caracteresRestantes = limite - caracteresDigitados;
        
        if(idCaixa == "txt-missao"){
            if (caracteresRestantes <= 0){
                var comentario = $("textarea[name=txt-missao]").val();
                $("textarea[name=txt-missao]").val(comentario.substr(0, limite));
                $("#cont-missao").text("0 " + informativo);
            }else{
                $("#cont-missao").text(caracteresRestantes + " " + informativo);
            }
        }else if(idCaixa == "txt-visao"){
            if (caracteresRestantes <= 0){
                var comentario = $("textarea[name=txt-visao]").val();
                $("textarea[name=txt-visao]").val(comentario.substr(0, limite));
                $("#cont-visao").text("0 " + informativo);
            }else{
                $("#cont-visao").text(caracteresRestantes + " " + informativo);
            }
        }else if(idCaixa == "txt-valores"){
            if (caracteresRestantes <= 0){
                var comentario = $("textarea[name=txt-valores]").val();
                $("textarea[name=txt-valores]").val(comentario.substr(0, limite));
                $("#cont-valores").text("0 " + informativo);
            }else{
                $("#cont-valores").text(caracteresRestantes + " " + informativo);
            }
        }
    }
} 