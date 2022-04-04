//Funções e recursos javascript e jQuery inicializadas com o carregamento da página.
$(document).ready(function() {

    //inicializa o select2
    $('select').select2({
        theme: "bootstrap-5",
        language: "pt-BR",
    });

    //$("#submit").attr("disabled", true);
    $('#submit').one('submit', function() {
        $(this).find('input[type="submit"]').attr('disabled','disabled');
    });

});
