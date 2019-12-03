var sistema = {

    /**
     * Configura as requisições em AJAX.
     */
    configurarAjax: function () {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            beforeSend: function () {
                $(".loading-spinner").show();
            },
            complete: function () {
                $(".loading-spinner").hide();
            }
        });
    },

    /**
     * Aplica os plugins necessários para o sistema funcionar corretamente.
     */
    aplicarPluginsExternos: function (elemento) {
        if (elemento == null) {
            elemento = $(document);
        }

        $('.datepicker', elemento).datepicker({
            format: 'dd/mm/yyyy'
        });

        $('select', elemento).select2({
            allowClear: true,
            width: '100%',
            openOnEnter: false,
            theme: "bootstrap",
            language: "pt-BR",
            placeholder: "Selecione..."
        });

        $('form.validate', elemento).each(function () {
            $(this).formValidator();
        });

        $('body', elemento).on('click', '.confirma-acao', function (event) {
            event.preventDefault();
            debugger
            var $el = $(this),
                texto = $el.attr('data-texto');

            swal({
                title: 'Confirmação',
                text: texto,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Cancelar'
            }, function () {
                window.location.assign($el.attr('href'));
            });
        });
    }
};


$(function () {
    sistema.configurarAjax();
    sistema.aplicarPluginsExternos();

    $('.abrir-processo[data-tr="S"]').click(function (event) {
        var href = $(this).attr('href');
        event.preventDefault();
        swal({
            allowEscapeKey: true,
            title: "Termo de referência",
            text: "Informe abaixo o código do termo de referência:",
            type: "input",
            showLoaderOnConfirm: true,
            showCancelButton: true,
            confirmButtonColor: "#1AB394",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Verificar",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: SITE_PATH + "/img/tr.png",
            inputPlaceholder: "Código do termo de referência"
        }, function (inputValue) {
            if (inputValue === false) return false;

            inputValue = parseInt(inputValue);

            if (isNaN(inputValue) || inputValue === "") {
                swal.showInputError("Você precisa inserir um código válido!");
                return false
            }

            // Procura pelo termo de referencia digitado pelo usuário
            $.post(SITE_PATH + '/termo-referencia/procurar', {id: inputValue}, function (retorno) {
                if (retorno == '1') {
                    swal({
                        allowEscapeKey: false,
                        title: "Abrindo processo...",
                        text: "Seu processo será aberto em instantes",
                        imageUrl: SITE_PATH + "/img/loading.gif",
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        location.href = href + '?tr=' + inputValue;
                    }, 2000);
                } else if (retorno == '2') {
                    swal.showInputError("Todos os insumos desse termo de referência já possuem processos abertos!");
                    return false
                } else {
                    swal.showInputError("Não encontrado, verifique e tente novamente!");
                }
            });
        });
    });

    $('#modal, #modal-xs').on('hidden.bs.modal', function (e) {
        $(e.target).removeData('bs.modal');
        $('.modal .modal-content').html('<div style="text-align:center"><img width="50" src="' + SITE_PATH + '/img/loading.gif"></div>');
    });
});