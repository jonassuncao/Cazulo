/**
* Função que usa o Ajax para requisitar dados para o servidor
* @param urlServidor 			// Url do servidor
* @param rota 					//Qual é a rota que o servidor vai processar essas informações
* @param parametros				//Todos os dados a ser enviados para o servidor
* @param retornoHTML			//Id de uma tag que receberá a resposta do servidor
*
*/

function requisitarServidorLogin(urlServidor, rota, parametros, retornoHTML){
	
	$.ajax({ 
		url: urlServidor, //Pagina destino 
		type: "POST",//metodo GET ou POST	
		data: "rota="+rota.substr(0, rota.indexOf('.'))+"&acao="+rota.substr(rota.indexOf('.')+1)+"&"+parametros, //Parametros a serem enviados
        
        beforeSend : function(){		
			
			//Limpa a cor e o conteudo dos box			
			$("#"+retornoHTML).html("");
			$("#"+retornoHTML).removeClass("back-success");
			$("#"+retornoHTML).removeClass("back-warning");
			$("#"+retornoHTML).removeClass("back-error");

            carregar_load('#load_div', true);
		},
		success: function(result){			
			//Caso o usuário consiga logar, exibe um box Success
			//Caso nãoconsiga logar, exibe um box com Warning
			if(result.indexOf("Logado") > -1) $("#"+retornoHTML).addClass("back-success");
			else 						      $("#"+retornoHTML).addClass("back-warning");

			$("#"+retornoHTML).html(result);
		},
		error: function(){			
			$("#"+retornoHTML).addClass("back-error");
			$("#"+retornoHTML).html('Sem resposta do Servidor! Verifique sua conexão...');			
		},			
		complete: function(){
			$("#"+retornoHTML).addClass("login-msg");
			carregar_load('#load_div', false);
		}			
	});	
}