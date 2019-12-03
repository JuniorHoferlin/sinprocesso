$(function () {

    iniciarSortable();

    // Adiciona uma nova regra
    $("form[name='adicionar-regras']").on('submit', function (e) {
        e.preventDefault();

        var $this = $(this),
            dados = $this.serializeArray(),
            $tabela = $('#regras-tipo-processo table tbody');

        if ($this.data('valid') == false) {
            return false;
        }

        $.post($this.attr('action'), dados, function (regra) {
            $('#sem-regras').addClass('hide');
            $tabela.append(regra);
            $this.find('input[type="text"]').val('');
            $this.find('select').val('').trigger('change');
            toastr['success']("A regra foi adicionada com sucesso.");
        });
    });

    // Deleta uma regra
    $('body').on('click', '.excluir-regra', function (e) {
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
                    $('#regra-' + id).remove();
                    toastr['success']("A regra foi excluída com sucesso.");
                } else {
                    toastr['error']("Houve um erro ao excluir a regra, contate o suporte técnico.");
                }

                if ($('#regras-tipo-processo table tbody tr').length == 1) {
                    $('#sem-regras').removeClass('hide');
                }
            });

        });
    });

    // Associa/Desassocia uma tarefa ao tipo de processo
    $('.associar-tarefa').on('click', function (e) {
        var $checkbox = $(this).find(':checkbox');
        if (event.target.type !== 'checkbox') {
            $checkbox.prop('checked', !$checkbox.prop('checked'));
        }

        var valor = $checkbox.prop('checked'),
            idTipo = $('input[name="id_tipo_processo"]').val(),
            idTarefa = $checkbox.val();

        $.post(SITE_PATH + '/tipo-processo/sincronizar-tarefa', {
            valor: valor,
            id_tipo_processo: idTipo,
            id_tarefa: idTarefa
        }, function (retorno) {
            if (retorno.hasOwnProperty('mensagem')) {
                toastr['error'](retorno.mensagem);
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            } else {
                // recarrega a lista de tarefas na outra aba
                $('#sequencia-tarefa').html(retorno.view);
                iniciarSortable();
            }
        })
    });

    // Ordena na sequencia as tarefas
    function iniciarSortable() {
        $(".connectList").sortable({
            update: function () {
                var contador = 1;
                $('.connectList').find('li.row').each(function () {
                    $(this).find('.input-order-id').val(contador);
                    contador++;
                });
                $(".connectList").sortable("refresh");

                var dados = $('form[name="sequencias"]').serializeArray();

                $.post(SITE_PATH + '/tipo-processo/ordenar-tarefas', dados);
            }
        });
    }
});