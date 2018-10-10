//Previsão de Despesas     

//Ativa/Desativa o Input   
$(document).ready(function(){ 
    function ativarInput(idInput){
        if($('#'+idInput).attr("disabled")){
            $('#'+idInput).removeAttr('disabled');
        }else{
            $('#'+idInput).attr('disabled', 'disabled');
        }
    }
});

//Quando clicar no Botao #btnNovo    
$(document).on('click', '#btnNovo', function(){
    
    //Adiciona nova linha na tabela
        var novoID;
        if(!$('#bodyTable tr:last td').length) novoID = 0;
        else novoID = parseInt($('#bodyTable tr:last td').html())+1;
        
        $('#bodyTable').append('<tr class="demo" >'                                            +
            '<td>'+novoID+'</td>'                                         +
            '<td>OR1848</td>'                                             +
            '<td><input class="form-control input_valor"></td>'           +
            '<td><input class="form-control input_desc" type="text"></td>'+
            '<td>'                                                        +
            '<div class="tools">'                                         +
                '<i class="fa fa-trash"></i>'                             +
            '<td>'                                                        +
        '</tr>');
});

//atualizar os ids quando remover algum
//Quando clicar na lixeira
$(document).on('click', '.fa-trash', function(){
    $(this).closest('.demo').append('<div class="modal fade" id="confirm" role="dialog">'+
        '<div class="modal-dialog modal-md">'+
        '<div class="modal-content">'+
            '<div class="modal-body">'+
            '<p> Tem certeza que deseja excluir este item?</p>'+
            '</div>'+
            '<div class="modal-footer">'+
            '<button type="button" onClick=""  class="btn btn-danger">Sim</button>'+
            '<button type="button" data-dismiss="modal" class="btn btn-default">Não</button>'+
            '</div>'+
        '</div>'+
        '</div>'+
    '</div>');

    $(this).closest('.demo').remove();
});

//calendário
$(document).ready(function(){
    $('#exemplo').datepicker({
      format: 'dd/mm/yyyy',
      language: "pt-BR",
      autoclose: true,
      defaultViewDate: true,
      assumeNearbyYear: true, 
      //startDate: '0'
    });
});

//mascara inputmask, ERRO= não muda dinamicamente quando add outros
$(document).ready(function() {
  $(".input_valor").inputmask({
    'alias': 'decimal',
    'groupSeparator': '',
    'digits': 2,
    'autoGroup': true,
    'digitsOptional': false,
    rightAlign: true,
    numericInput: true 
  });   
}); 
//valor invalido na mascara
$(document).ready(function() {
    Inputmask.extendDefaults({
    onKeyValidation: function(key, result){
        if (!result){
        alert('Valor inválido')
        }
    }
    });
});

  



