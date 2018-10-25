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
* Função que usa o Ajax para enviar dados para o servidor
*
*/
function Envio_Ajax(metodo, div_retorno, divLoad, controller, action, param) {
	//Verifica se está passando um objeto
	if (param.constructor.name == 'FormData') {
		$.ajax({
			url: 'index.php', // Url do lado server que vai receber o arquivo
			data: param,
			processData: false,
			contentType: false,
			type: metodo,
			success: function (result) {
				$("#" + div_retorno).html(result);
			},
			error: function (result) {
				$("#" + div_retorno).html('Erro interno, Contacte adminitrador do sistema!');
			}
		});
	} else {
		$.ajax({
			url: 'index.php', //Pagina destino 
			type: metodo,//metodo GET ou POST		
			data: "controller=" + controller + "&action=" + action + "&" + param, //Parametros a serem enviados   		    
			beforeSend: function (result) {

				//Limpa o conteudo do box			
				$("#" + div_retorno).html("");
				carregar_load('#' + divLoad, true);
			},
			success: function (result) {
				$("#" + div_retorno).html(result);
			},
			error: function (result) {
				$("#" + div_retorno).html('Erro interno, Contacte adminitrador do sistema!');
			},
			complete: function (result) {
				carregar_load('#' + divLoad, false);
			}
		});
	};
}
