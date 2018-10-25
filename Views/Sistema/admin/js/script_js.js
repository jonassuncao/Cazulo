//Previsão de Despesas     

//Ativa/Desativa o Input   
function ativarInput(idInput){
    if($('#'+idInput).attr("disabled")){
        $('#'+idInput).removeAttr('disabled');
    }else{
        $('#'+idInput).attr('disabled', 'disabled');
    }
}

//Excluir a linha da tabela quando é confirmado o modal de exclusão
function excluirLinha(linha){

    $(linha).remove();
   
    //Atualiza Valores SubTotal, Fundo reserva e Total
   calcularValores();
}

//calendário
$('#data').datepicker("setDate", new Date()).datepicker({
    format: 'mm/yyyy',
    language: "pt-BR",
    autoclose: true,
    defaultViewDate: true,
    assumeNearbyYear: true,    
});


$(document).on('click', '#salvarConfFdReserva', function(){
    
    //Atualiza Valores SubTotal, Fundo reserva e Total
    calcularValores();
 
});

function calcularValores(){
    var subTotal = 0.0;
    var fundoReserva = 0.0;
    
    //Soma valores das Despesas    
    $('#bodyTable .valor-unit-desp').each(function () {
        subTotal += parseFloat($(this).text());        
      });    
      subTotal = isNaN(subTotal) ? 0.0 : subTotal;
      $("#subTotal").html(subTotal);      
    //--------------------------------
    
    //Calcula Fundo de Reserva
    fundoReserva = (subTotal * parseFloat($("#inputValorFdReserva").val()))/100;
    fundoReserva = isNaN(fundoReserva) ? 0.0 : fundoReserva;
    
    $("#fundoReserva").html(fundoReserva);
    //------------------------

    //Calcula Total
    $('#total').html(fundoReserva + subTotal);
    //-----------------------
}
function getMoney( str )
{
        return parseInt( str.replace(/[\D]+/g,'') );
}

function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
}
/*taxa de condominio */
$(document).on('click', '#buscarPrevisao', function(){
    $('#encontrarPrevisao').css("display", "block"); 
});


 $(document).on('click', '.dropdown-toggle', function(e){
    e.preventDefault();
    e.stopPropagation();
    $(this).closest(".search-dropdown").toggleClass("open");
});

$(document).on('click', '.dropdown-menu > li > a', function(e){

    e.preventDefault();
    
    var clicked = $(this);
    
    clicked.closest(".dropdown-menu").find(".menu-active").removeClass("menu-active");
    clicked.parent("li").addClass("menu-active");
    clicked.closest(".input-group-btn").find(".toggle-active").html(clicked.html());
});
    
$(document).click(function() {
    $(".input-group-btn.open").removeClass("open");
});
