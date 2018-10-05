$('#btLogar').click(function(){
    //Valida se os campos estão preenchidos
    if($('#usuario').val().length == 0) return;
    if($('#senha').val().length == 0)   return;
    
    //Envia os dados para o servidor    
    Envio_Ajax("POST", "body_resposta", "load_div", "Home", "login");
    return false;
});