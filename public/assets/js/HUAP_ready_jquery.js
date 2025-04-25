//Funções e recursos javascript e jQuery inicializadas com o carregamento da página.
$(document).ready(function() {

    // BLOQUEIO DE MÚLTIPLAS ABAS (exceto para páginas de impressão)
    const urlParams = new URLSearchParams(window.location.search);
    const isPrintView = urlParams.get('printview') === '1';

    if (!isPrintView) {
        const LOCK_KEY = 'app_tab_lock';
        const THIS_TAB_ID = Date.now().toString();

        function lockApp() {
            const lock = localStorage.getItem(LOCK_KEY);
            if (lock && lock !== THIS_TAB_ID) {
                //alert("Este aplicativo já está aberto em outra aba.");
                window.location.href = "/block.html"; // ou mostre um modal de aviso
            } else {
                localStorage.setItem(LOCK_KEY, THIS_TAB_ID);
            }
        }

        function unlockApp() {
            const lock = localStorage.getItem(LOCK_KEY);
            if (lock === THIS_TAB_ID) {
                localStorage.removeItem(LOCK_KEY);
            }
        }

        window.addEventListener('storage', function(event) {
            if (event.key === LOCK_KEY && event.newValue !== THIS_TAB_ID) {
                //alert("O aplicativo foi aberto em outra aba. Esta aba será desativada.");
                window.location.href = "/block.html";
            }
        });

        window.addEventListener('beforeunload', unlockApp);

        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                lockApp();
            }
        });

        lockApp();
    }


    //Máscaras
    $(".Numero").mask("9");
    $(".Data").mask("99/99/9999");
    $(".Hora").mask("99:99");
    $(".DataHora").mask("99/99/9999 99:99");
    $(".Cpf").mask("999.999.999-99");
    $(".Cnpj").mask("99.999.999/9999-99");
    $(".Cep").mask("99999-999");
    $(".TituloEleitor").mask("9999.9999.9999");
    $(".Telefone").mask("(99) 9999-9999");
    $(".Prontuario").mask("99.99.99");
    $(".CodigoExame").mask("***-*?*******");
    $(".Celular").mask("(99) 9999?9-9999");
    $(".Cns").mask("?999.9999.9999.9999");
    $(".CelularVariavel").on("blur", function () {
        var last = $(this).val().substr($(this).val().indexOf("-") + 1);

        if (last.length == 3) {
            var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
            var lastfour = move + last;

            var first = $(this).val().substr(0, 9);

            $(this).val(first + '-' + lastfour);
        }
    });

    //inicializa o select2 apenas em inputs com class select2 indicado
    $('.select2').select2({
        theme: "bootstrap-5",
        language: "pt-BR",
    });

    $('#submit').one('submit', function() {
        $(this).find('input[type="submit"]').attr('disabled','disabled');
    });

    $(".click").click(function () {
        $(this).replaceWith('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Aguarde...</span></div>');
    });

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

});

$(document).on('select2:open', () => {
    let allFound = document.querySelectorAll('.select2-container--open .select2-search__field');
    $(this).one('mouseup keyup',()=>{
        setTimeout(()=>{
            allFound[allFound.length - 1].focus();
        },0);
    });
});

/*
* Adiciona um btn-warning para cara checked de cada campo radio do formulário
*
* @param {string} value
* @returns {decimal}
*/
// Adiciona um listener para o evento click em todos os botões/labels dentro de cada grupo
$('.btn-group label').click(function() {
    // Remove a classe btn-warning de todos os labels dentro do grupo
    $(this).closest('.btn-group').find('label').removeClass('btn-warning');
    // Adiciona a classe btn-secondary a todos os labels dentro do grupo
    $(this).closest('.btn-group').find('label').addClass('btn-secondary');
    // Adiciona a classe btn-warning apenas ao label clicado
    $(this).addClass('btn-warning');
    // Remove o atributo checked de todos os radio buttons dentro do grupo
    $(this).closest('.btn-group').find('input[type="radio"]').prop('checked', false);
    // Marca como checked o radio button correspondente ao label clicado
    $(this).prev('input[type="radio"]').prop('checked', true);
});


/*
* Modal de confirmação de exclusão da lista diária de agendamentos
*
* @param {string} value
* @returns {decimal}
*/
var confirmDeleteModal = document.getElementById('confirmDeleteModal');

if (confirmDeleteModal) {
  
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {

        // Botão que acionou o modal
        var button = event.relatedTarget;
    
        // Extrai os dados (ID e data)
        var id = button.getAttribute('data-id');
        var date = button.getAttribute('data-date');
    
        // Monta o link de exclusão
        var deleteUrl = window.location.origin+'/agenda/del_agendamento/'+id+'/'+date;
    
        // Atualiza o link de confirmação no modal
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.setAttribute('href', deleteUrl);
    });
} 

//.base_url('agenda/del_agendamento/'.$x['idPreschuap_Agenda'].'/'.$agenda['databd']).

