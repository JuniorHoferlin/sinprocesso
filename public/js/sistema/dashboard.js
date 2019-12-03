$(function () {

    var selecao = $('input[name="selecao"]:checked').val();
    buscarDados(selecao);

    $('input[name="selecao"]').change(function () {
        $('#datas').addClass('hide');
        var selecao = this.value;
        buscarDados(selecao);
    })

    $('.periodo').click(function () {
        $('#datas').removeClass('hide');
    })

    $('.buscar-por-periodo').click(function () {
        var dataInicio = $('input[name="data-inicio"]').val();
        if (dataInicio == "") {
            toastr['warning']("Selecione uma data inicial.");
            return;
        }

        var dataFim = $('input[name="data-fim"]').val();
        if (dataFim == "") {
            toastr['warning']("Selecione uma data final.");
            return;
        }

        var periodo = {
            inicio: dataInicio,
            fim: dataFim
        };
        buscarDados(periodo)
    });

    function buscarDados(periodo) {
        var dados = {selecao: periodo}

        $.post(SITE_PATH + '/dados-dashboard', dados, function (retorno) {

            $('#periodo-datas').html("De " + retorno.datas.inicio + " até " + retorno.datas.fim);

            // Processos por tipo
            $.each(retorno.processos, function (tipo, valor) {
                $('span#' + tipo).text(valor);
            });

            $('#insumos-tramite').text(retorno.insumos_tramite);
            $('#tempo-medio-tarefas').text(retorno.tempo_medio_tarefas);

            // Gráfico tipos de compras
            $('#flot-bar-chart').html('');
            Morris.Bar({
                element: 'flot-bar-chart',
                data: JSON.parse(retorno.tipos_de_compra),
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Series A', 'Series B']
            });
        });
    }
});