function validarCaixa(caracter){
                
    if(window.event)
        var letra = caracter.charCode;
    else
        var letra = caracter.which;
                
    if(letra == 32 || letra < 45 || letra > 57){
                     
        if(letra != 46 || letra != 44 || letra != 32)
            return false;
    }
}