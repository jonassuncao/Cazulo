//Previsão de Despesas     

//Ativa/Desativa o Input   
function ativarInput(idInput){
    if($('#'+idInput).attr("disabled")){
        $('#'+idInput).removeAttr('disabled');
    }else{
        $('#'+idInput).attr('disabled', 'disabled');
    }
}

//ta indo de 2 em 2
//Quando clicar no Botao #btnNovo    
$(document).on('click', '#btnNovo', function(){
     
    //Adiciona nova linha na tabela
        var novoID;
        if(!$('#bodyTable tr:last td').length) novoID = 1;
        else novoID = parseInt($('#bodyTable tr:last td').html())+1;
        
        $('#bodyTable').append('<tr class="demo" id="tr_'+novoID+'">'+
        '<td>'+novoID+'</td>'+
        '<td>OR1848</td>'+
        '<td><input class="form-control input_valor"></td>'+
        '<td><input class="form-control input_desc" type="text"></td>'+
        '<td>'+
        '  <button type="button" class="btn btn-default btn-linha" style="padding: 0;" data-toggle="modal" data-target="#myConfig'+novoID+'">'+
        '    <i class="glyphicon glyphicon-trash" ></i>'+
        '  </button>                                     '+         
        '</td> '+
        '</tr>');

        $('<div class="modal fade" id="myConfig'+novoID+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
        '<div class="modal-dialog" role="document">'+
        '  <div class="modal-content">'+
        '    <div class="modal-body">'+
        '    <p> Tem certeza que deseja excluir este item?</p>'+
        '    </div>'+
        '    <div class="modal-footer">'+
        '      <button type="button" onClick="$(\'#tr_'+novoID+', #myConfig'+novoID+', .in\').remove();" class="btn btn-danger modal_confirma" data-dismiss="modal" >Sim</button>'+
        '      <button type="button" data-dismiss="modal" class="btn btn-default">Não</button>'+
        '    </div>'+
        '  </div>'+
        '</div>'+
        '</div>'+
        '</div>').insertBefore('table');
        
});

//atualizar os ids quando remover algum
//Quando clicar na lixeira
$(document).on('click', '.modal_confirma', function(){
    
   //alert($(this).closest('.modal_confirma').html() + ' 123');
});

//calendário
$('#data').datepicker("setDate", new Date()).datepicker({
    format: 'dd/mm/yyyy',
    language: "pt-BR",
    autoclose: true,
    defaultViewDate: true,
    assumeNearbyYear: true,    
});
