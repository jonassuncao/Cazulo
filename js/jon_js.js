$('#btLogar').click(function(){
    //Valida se os campos estão preenchidos
    if($('#usuario').val().length == 0){alert('Informe um usuário!'); return;}
    if($('#senha').val().length == 0){alert('Informe a senha!'); return;}
    //Ativa img LOAD
    $('#load_img').html('<img class="p-l-110 p-r-110 p-t-62 p-b-33" id="load" src="images/load.gif"/>');
    window.location.href="#load"; 
    //Envia os dados para o servidor
    //Redireciona a tela
    return false;
});