//calcula o tempo de sessão de 2 hora (120 minutos)
var timesession = new Date();
timesession.setHours( timesession.getHours() + 2 );

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
