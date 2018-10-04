/**
 * Função para carregar a imagem de load
 * 
 * @param {*} dirI   -- Passa a div que recebera a classe de load
 * @param {*} loadP  -- Define se exibe ou não a imagem de load
 */
function carregar_load(divI, loadP = false){
    var classLoad = "load_img"; 
       
    if(loadP){$(divI).addClass(classLoad);}
    else     {$(divI).removeClass(classLoad);}
}

/**
* Função que usa o Ajax para enviar dados para o servidor
*
*/
function Envio_Ajax(metodo, div_retorno, divLoad, controller, action, param){
	
	$.ajax({ 
		url: 'index.php', //Pagina destino 
		type: metodo,//metodo GET ou POST	
		data: "controller="+controller+"&action="+action+"&"+param, //Parametros a serem enviados
        
        beforeSend : function(result){		
			
			//Limpa a cor e o conteudo dos box
			$("#"+div_retorno).html("");
			$("#"+div_retorno).removeClass("back-success");
			$("#"+div_retorno).removeClass("back-warning");
			$("#"+div_retorno).removeClass("back-error");

            carregar_load('#'+divLoad, true);
		},
		success: function(result){
			
			//Caso o usuário consiga logar, exibe um box Success
			//Caso nãoconsiga logar, exibe um box com Warning
			if(result.indexOf("Logado") > -1) $("#"+div_retorno).addClass("back-success");
			else 						      $("#"+div_retorno).addClass("back-warning");

			$("#"+div_retorno).html(result);
		},
		error: function(result){			
			$("#"+div_retorno).addClass("back-error");
			$("#"+div_retorno).html('Erro interno, Contacte adminitrador do sistema!');			
		},			
		complete: function(result){
			$("#"+div_retorno).addClass("login-msg");
			carregar_load('#'+divLoad, false);
		}			
	});	
}