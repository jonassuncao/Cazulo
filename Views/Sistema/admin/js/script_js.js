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
$(document).on('click', '#adicionar-item', function(){
    var valorDespesa = $('#valor').val();
    var desc = $('#descricao').val();
    var comboBox;
    var novoID;
    var subTotal = 0;
    var inputFundoReserva = $('#inputValorFdReserva').val();
    var fundoReserva;
    var total;
   
    $("#combo option:selected").each(function() {
        comboBox = $(this).val();
    });

    if(!$('#bodyTable tr:last td').length) novoID = 1;
    else novoID = parseInt($('#bodyTable tr:last td').html())+1;
    //adicionando linha na tabela
    $('#bodyTable').append(
        '<tr class="demo" id="tr_'+novoID+'">'                                     +
        '   <td>'+novoID+'</td>'                                                   +
        '   <td>'+comboBox+'</td>'                                                    +
        '   <td class="valor-unit-desp">'+valorDespesa+'</td>'                            +
        '   <td>'+desc+'</td>'                                                     +
        '   <td>'                                                                  +
        '       <i class="glyphicon glyphicon-pencil"></i>'                        +
        '       <button type="button" class="btn btn-default btn-linha" style="padding: 0;" data-toggle="modal" data-target="#myConfig'+novoID+'">'+
        '           <i class="glyphicon glyphicon-trash"></i>'                     +
        '       </button>'                                                         +         
        '   </td>'                                                                 +
        '</tr>');
    //adicionando o modal da tabela para exclusão
    $('<div class="modal fade" id="myConfig'+novoID+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
      '<div class="modal-dialog" role="document">'                                 +
      '  <div class="modal-content">'                                              +
      '    <div class="modal-body">'                                               +
      '       <p>Tem certeza que deseja excluir este item?</p>'                    +
      '    </div>'                                                                 +
      '    <div class="modal-footer">'                                             +
      '      <button id="lixo_'+novoID+'" type="button" onClick="excluirLinha(\'#tr_'+novoID+', #myConfig'+novoID+', .in\');" class="btn btn-danger modal_confirma" data-dismiss="modal" >'+
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

    $('#footTable').css("visibility", "visible");
      
    //Soma do total
    $('.table #bodyTable .valor-unit-desp').each(function () {
        subTotal += parseFloat($(this).text()); 
        $("#subTotal").html(subTotal);           
    }); 

    //Subtração Total
    $(document).on('click', '.modal_confirma', function(){
        subTotal -= valorDespesa;
        $("#subTotal").html(subTotal);
    }); 
    //calcula o valor do fundo de reserva
    fundoReserva = (subTotal * inputFundoReserva)/100;

    $("#fundoReserva").html(fundoReserva); 

    $('#total').html(fundoReserva+subTotal);

}); 
//Excluir a linha da tabela quando é confirmado o modal de exclusão
function excluirLinha(linha){
    var subTotal = $("#subTotal").val();

    ///var text=$(linha).html(id);

    $(linha).remove();

    //alert(text);

}

//calendário
$('#data').datepicker("setDate", new Date()).datepicker({
    format: 'mm/yyyy',
    language: "pt-BR",
    autoclose: true,
    defaultViewDate: true,
    assumeNearbyYear: true,    
});

$(document).on('click', '.modal_confirma', function(){
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
});

$(document).on('click', '#select-itens', function(){

    $('.table thead tr').prepend('<th>kkkkkkkkkkk</th>');

    $('.table tbody .demo').prepend(
        '<div class="form-group">'+
        '    <label>'+
        '       <input type="checkbox" class="minimal">'+
        '    </label>'+
        '</div>');
    
});

$(document).on('click', '#salvarConfFdReserva', function(){
    var inputFundoReserva = $('#inputValorFdReserva').val();
    var subTotal = $("#subTotal").html();
    var fundoReserva;
    var total;

    //Não fecha o modal**************************
    //$('#myConfig').modal('hide').noConflict(); 
    fundoReserva = (subTotal * inputFundoReserva)/100;
    total = subTotal + fundoReserva;

    $("#fundoReserva").html(fundoReserva); 
    //ERRADO, não atualiza o total quando coloco o fundo de reserva********************
    $(document).on('click', '#salvarConfFdReserva', function(){
        $('#total').val(total);
    });
});
