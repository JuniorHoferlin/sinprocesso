$(function () {

    iniciarTags($(".opcoes"));

    function iniciarTags($elemento) {
        $elemento.select2({
            tags: true,
            theme: "bootstrap",
            language: "pt-BR",
            width: '100%',
        });
    }

    // Adiciona um novo campo
    $("form[name='adicionar-campos']").on('submit', function (e) {
        e.preventDefault();

        var $this = $(this),
            dados = $this.serializeArray(),
            $tabela = $('#formularios-campos table tbody');

        $.post(SITE_PATH + '/formularios/adicionar-campo', dados, function (campo) {
            $('#sem-campo').hide();

            var $campo = $(campo);
            iniciarTags($campo.find('.opcoes'));
            $tabela.append($campo);

            $this.find('input[type="text"]').val('');
            $this.find('select').val('').trigger('change');
            toastr['success']("O campo foi adicionado com sucesso.");
        });
    });

    // Deleta um campo
    $('body').on('click', '.excluir-campo', function (e) {
        e.preventDefault();

        var href = $(this).attr('href'),
            id = $(this).attr('data-id'),
            dados = {id: id};

        swal({
            title: 'Você tem certeza?',
            text: "Você não será capaz de recuperar esse registro de novo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Apagar",
            closeOnConfirm: true
        }, function () {
            $.post(href, dados, function (excluido) {
                if (excluido) {
                    $('#formulario-campo-' + id).remove();
                    toastr['success']("O campo foi excluido com sucesso.");
                } else {
                    toastr['error']("Houve um erro ao excluir o campo, contate o suporte técnico.");
                }

                if ($('#formularios-campos table tbody tr').length == 1) {
                    $('#sem-campo').show();
                }
            });
        });
    })

    // Adiciona uma nova opção em um campo
    $('body').on('click', '.salvar-campo', function (e) {
        e.preventDefault();

        var $this = $(this),
            href = $this.attr('href'),
            id = $this.attr('data-id'),
            label = $this.parents('tr').find('input[name="label"]').val(),
            required = $this.parents('tr').find('select[name="required"]').val(),
            opcoes = $this.parents('tr').find('select[name="opcoes"]').val();

        opcoes = JSON.stringify(opcoes);
        if (opcoes == null || opcoes == 'null') {
            opcoes = '';
        }

        var dados = {
            id: id,
            label: label,
            required: required,
            opcoes: opcoes
        }

        $this.find('i').removeClass('fa-save').addClass('fa-spinner fa-spin').attr('disabled', true);

        $.post(href, dados, function (salvo) {
            if (salvo) {
                toastr['success']("Os dados do campo foram atualizados com sucesso.");
                $this.find('i').removeClass('fa-spinner fa-spin').addClass('fa-save').removeAttr('disabled');
            }
        })
    })
});