//Captura o valor de timeout de sessão do arquivo .env através do input existente no uppernavbar.php
var timeout = $("input[name=timeout]").val();

//calcula o tempo de sessão de 2 horas (120 minutos)
var timesession = new Date();
//timesession.setHours( timesession.getHours() + 2 );
timesession.setSeconds( timesession.getSeconds() + parseInt(timeout) );

//fecha divs de flashdata (mensagens de erro/sucesso) após alguns segundos
$('#flashdata').delay(5000).fadeOut('slow');

//monta o time de sessão do usuário
$('#clock').countdown(timesession)
.on('update.countdown', function(event) {
    var format = '%H:%M:%S';
    $(this).html(event.strftime(format));
});
//.on('finish.countdown', function(event) {
//    $(this).html('This offer has expired!')
//    .parent().addClass('disabled');
//});

$(".clickable-row").click(function () {
    window.document.location = $(this).data("href");
});
