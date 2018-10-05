$('#btLogar').click(function(){
    //Valida se os campos estão preenchidos
    if($('#usuario').val().length == 0) return;
    if($('#senha').val().length == 0)   return;
    
    //Envia os dados para o servidor    
    Ajax_Login("POST", "body_res", "load_div", "Login", "login", $("form").serialize());
    return false;
});

/**
* Função que usa o Ajax para enviar dados para o servidor
*
*/
function Ajax_Login(metodo, div_retorno, divLoad, controller, action, param){
	
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
			$("#"+div_retorno).html('Sem resposta do Servidor! Verifique sua conexão...');			
		},			
		complete: function(result){
			$("#"+div_retorno).addClass("login-msg");
			carregar_load('#'+divLoad, false);
		}			
	});	
}