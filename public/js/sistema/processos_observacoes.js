$(function () {
    // Adiciona uma nova observacao no processo
    $('form[name="adicionar-observacao"]').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data('valid') == false) {
            return;
        }

        var dados = $this.serializeArray(),
            $botao = $this.find('button');

        $botao.text('Salvando...').attr('disabled', true);
        $.post($this.attr('action'), dados, function (observacoes) {
            $('.observacoes-enviadas').html(observacoes);
            $this.find('textarea').val('');
            toastr['success']("A observação foi adicionada com sucesso.");
            $botao.text('Salvar').removeAttr('disabled');
        });
    })

    // Remove uma observação
    $('body').on('click', '.remover-observacao', function (e) {
        e.preventDefault();

        var href = $(this).attr('href'),
            id = $(this).attr('data-id'),
            dados = {id: id};

        swal({
                title: "Confirmar",
                type: 'error',
                text: 'Gostaria de remover esta observação?',
                showCancelButton: true,
                confirmButtonText: "Remover",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
                allowEscapeKey: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#ed5565'
            },
            function () {
                $.post(href, dados, function (observacoes) {
                    $('.observacoes-enviadas').html(observacoes);
                    toastr['success']("A observação foi removida com sucesso.");
                });
            });
    });
});