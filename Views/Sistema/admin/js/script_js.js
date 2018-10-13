//Previsão de Despesas     

//Ativa/Desativa o Input   
function ativarInput(idInput){
    if($('#'+idInput).attr("disabled")){
        $('#'+idInput).removeAttr('disabled');
    }else{
        $('#'+idInput).attr('disabled', 'disabled');
    }
}

//atualizar os ids quando remover algum
//Quando//Quando clicar no Botao da despesa  
$(document).on('click', '#bot', function(){
    var valor = $('#valor').val();
    var desc = $('#descricao').val();
    var desp = $('').val;
    var combo;
    var novoID;
    var soma = 0;

    if(!$('#bodyTable tr:last td').length) novoID = 1;
    else novoID = parseInt($('#bodyTable tr:last td').html())+1;
   
    $("#combo option:selected").each(function() {
     combo = $(this).val();
    });
    //adicionando linha
    $('#bodyTable').append(
        '<tr class="demo" id="tr_'+novoID+'">'                                     +
        '   <td>'+novoID+'</td>'                                                   +
        '   <td>'+combo+'</td>'                                                    +
        '   <td class="valor-unit-desp">'+valor+'</td>'                                                    +
        '   <td>'+desc+'</td>'                                                     +
        '   <td>'                                                                  +
        '       <i class="glyphicon glyphicon-pencil"></i>'                        +
        '       <button type="button" class="btn btn-default btn-linha" style="padding: 0;" data-toggle="modal" data-target="#myConfig'+novoID+'">'+
        '           <i class="glyphicon glyphicon-trash"></i>'                     +
        '       </button>'                                                         +         
        '   </td>'                                                                 +
        '</tr>');
    //adicionando o modal
    $('<div class="modal fade" id="myConfig'+novoID+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
      '<div class="modal-dialog" role="document">'                                 +
      '  <div class="modal-content">'                                              +
      '    <div class="modal-body">'                                               +
      '       <p>Tem certeza que deseja excluir este item?</p>'                    +
      '    </div>'                                                                 +
      '    <div class="modal-footer">'                                             +
      '      <button type="button" onClick="excluirLinha(\'#tr_'+novoID+', #myConfig'+novoID+', .in\');" class="btn btn-danger modal_confirma" data-dismiss="modal" >'+
      '        Sim'                                                                +
      '      </button>'                                                            +
      '      <button type="button" data-dismiss="modal" class="btn btn-default">'  +
      '         Não'                                                               +
      '      </button>'                                                            +
      '    </div>'                                                                 +
      '  </div>'                                                                   +
      '</div>'                                                                     +
      '</div>'                                                                     +
      '</div>').insertBefore('table');
      
    //Soma do total
    $('.table #bodyTable .valor-unit-desp').each(function () {
        soma += parseFloat($(this).text()); 
        $("#soma-desp").text(soma);           
    });
    //Subtração Total
    $(document).on('click', '.modal_confirma', function(){
        soma -= valor;
        $("#soma-desp").text(soma);
    }); 

}); 
//Excluir a linha da tabela quando é confirmado o modal de exclusão
function excluirLinha(linha){
    $(linha).remove();
}

//calendário
$('#data').datepicker("setDate", new Date()).datepicker({
    format: 'mm/yyyy',
    language: "pt-BR",
    autoclose: true,
    defaultViewDate: true,
    assumeNearbyYear: true,    
});
