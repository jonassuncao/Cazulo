/**
 * Função para carregar a imagem de load
 * 
 * @param {*} dirI   -- Passa a div que recebera a classe de load
 * @param {*} loadP  -- Define se exibe ou não a imagem de load
 */
function carregar_load(divI, loadP = false) {
	var classLoad = "load_img";

	if (loadP) { $(divI).addClass(classLoad); }
	else { $(divI).removeClass(classLoad); }
}

/**
* Função que usa o Ajax para requisitar dados para o servidor
* @param urlServidor 			// Url do servidor
* @param rota 					//Qual é a rota que o servidor vai processar essas informações
* @param parametros				//Todos os dados a ser enviados para o servidor
* @param retornoHTML			//Id de uma tag que receberá a resposta do servidor
*
*/
function requisitarServidor(urlServidor, rota, parametros, retornoHTML) {
	//Verifica se está passando um objeto como parametro
	if (parametros.constructor.name == 'FormData') {
		$.ajax({
			url: urlServidor, 
			data: parametros,
			processData: false,
			contentType: false,
			type: "POST",
			success: function (result) {				
				$("#" + retornoHTML).html(result);
			},
			error: function () {
				$("#" + retornoHTML).html('Erro interno, Contacte adminitrador do sistema!');
			}
		});
	} else {		
		$.ajax({
			url: urlServidor, //Pagina destino 
			type: "POST",//metodo GET ou POST		
			data: "rota="+rota.substr(0, rota.indexOf('.'))+"&acao="+rota.substr(rota.indexOf('.')+1)+"&"+parametros, //Parametros a serem enviados
			beforeSend: function () {

				//Limpa o conteudo do box				
				carregar_load('#load_div', true);
			},
			success: function (result, txt, code) {				
				if(code.status != 200){				
					$("#" + retornoHTML).html($("#"+ retornoHTML).html() + result);					
				}else{
					$("#" + retornoHTML).html(result);
				}				
				
			},
			error: function () {
				$("#" + retornoHTML).html('Erro interno, Contacte adminitrador do sistema!');
			},
			complete: function () {
				carregar_load('#load_div', false);
			}
		});
	};
}
