

$('#btLogar').click(function(){
    //Valida se os campos estão preenchidos
    if($('#usuario').val().length == 0) return;
    if($('#senha').val().length == 0)   return;
    //Ativa img LOAD
    carregar_load('#load_div', 'images/load.gif', true);
    
    //Envia os dados para o servidor
    //Redireciona a tela
    window.location.replace("admin");
    return false;
});

/**
 * Função para carregar a imagem de load
 * 
 * @param {*} dirI   -- Passa a div que recebera a classe de load
 * @param {*} dirImg -- Passa o diretório da imagem de load
 * @param {*} loadP  -- Define se exibe ou não a imagem de load
 */
function carregar_load(divI, dirImg, loadP = false){
    var classLoad = "load_img"; 
   
    $(divI).css('background-image', 'url("'+dirImg+'")');   
    if(loadP){$(divI).addClass(classLoad);}
    else     {$(divI).removeClass(classLoad);}
}