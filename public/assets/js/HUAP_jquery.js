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

/*
 * Função que calcula o Índice de Massa Corporal
 *
 * IMC = PESO / ALTURA^2
 *
 * @param {decimal} peso
 * @param {int} altura
 * @returns {decimal}
 */
function indiceMassaCorporal() {

    //busca os valores
    var peso = $("#Peso").val();
    var altura = $("#Altura").val();

    if(peso && altura) {
        peso = peso.replace(".","").replace(",",".");

        imc = (peso / (altura**2)) * 10000;
        imc = imc.toFixed(3);
        imc = imc.replace(".",",");

        $('#IndiceMassaCorporal').val(imc);
    }

}

/*
 * Função que calcula a Superfície Corporal
 *
 * SC (m2) = 0,007184 X ( Altura (cm)^0,725) X ( Peso (kg) )^0,425
 * Referência: https://arquivos.sbn.org.br/equacoes/eq6.htm
 *
 * @param {decimal} peso
 * @param {int} altura
 * @returns {decimal}
 */
function superficieCorporal() {

    //busca os valores
    var peso = $("#Peso").val();
    var altura = $("#Altura").val();

    if(peso && altura) {
        peso = peso.replace(".","").replace(",",".");

        sc = (0.007184 * (altura**0.725) * (peso**0.425));
        sc = sc.toFixed(3);
        sc = sc.replace(".",",");

        $('#SuperficieCorporal').val(sc);
    }

}

/*
 * Função que calcula o Clearance Creatinina
 *
 * ClCr (mL/min) = (140 – idade) × (peso em kg) × (0.85 se mulher) / (72 × Creatinina sérica)
 * Referência: https://www.mdsaude.com/nefrologia/calculadoras-clearance-creatinina/ ou
 *             https://calculadorasmedicas.com.br/calculadora/clearance-de-creatinina-equacao-cockcroft-gault
 *
 * @param {decimal} peso
 * @param {int} idade
 * @param {char} sexo
 * @param {decimal} creatinina
 * @returns {decimal}
 */
function clearanceCreatinina() {

    //busca os valores
    var peso        = $("#Peso").val();
    var idade       = $("#Idade").val();
    var sexo        = $("#Sexo").val();
    var creatinina  = $("#CreatininaSerica").val();

    if (sexo == 'F')
        sexo = 0.85;
    else
        sexo = 1;

    if(peso && idade && sexo && creatinina) {
        peso        = peso.replace(".","").replace(",",".");
        creatinina  = creatinina.replace(".","").replace(",",".");

        clcr = ((140 - idade) * peso * sexo) / (72 * creatinina);
        clcr = clcr.toFixed(3);
        clcr = clcr.replace(".",",");

        $('#ClearanceCreatinina').val(clcr);
    }

}

/*
 * Função que calcula a Dose Carboplatina
 *
 * Dose Carboplatina = Valor AUC * (ClCr + 25)
 *
 * @param {decimal} peso
 * @param {int} altura
 * @returns {decimal}
 */
function doseCarboplatina() {

    //busca os valores
    var dose = $("#Dose").val();
    var clearance = $("#Clearance").val();

    if(dose && clearance) {
        dose        = dose.replace(".","").replace(",",".");
        clearance   = clearance.replace(".","").replace(",",".");

        dc = (dose * (clearance + 25));
        dc = dc.toFixed(3);
        dc = dc.replace(".",",");

        $('#DoseCarboplatina').val(dc);
    }

}
