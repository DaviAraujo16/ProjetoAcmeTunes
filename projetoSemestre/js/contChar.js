$(document).on("input", "#txt-sugestao", function(){
    var limite = 255;
    var informativo = "/ 255";
    var caracteresDigitados = $(this).val().length;
    var caracteresRestantes = limite - caracteresDigitados;

    if (caracteresRestantes <= 0){
        var comentario = $("textarea[name=txt-sugestao]").val();
        $("textarea[name=txt-sugestao]").val(comentario.substr(0, limite));
        $(".caracteres").text("0 " + informativo);
    }else{
    $(".caracteres").text(caracteresRestantes + " " + informativo);
    }
});