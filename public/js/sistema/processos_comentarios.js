$(function () {
    // Adiciona um novo comentário no processo
    $('form[name="adicionar-comentario"]').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data('valid') == false) {
            return;
        }

        var dados = $this.serializeArray(),
            $botao = $this.find('button');

        $botao.text('Salvando...').attr('disabled', true);
        $.post($this.attr('action'), dados, function (comentarios) {
            $('.comentarios-enviados').html(comentarios);
            $this.find('textarea').val('');
            toastr['success']("O comentário foi adicionado com sucesso.");
            $botao.text('Salvar').removeAttr('disabled');
        });
    })

    // Remove um comentário
    $('body').on('click', '.remover-comentario', function (e) {
        e.preventDefault();

        var href = $(this).attr('href'),
            id = $(this).attr('data-id'),
            dados = {id: id};

        swal({
                title: "Confirmar",
                type: 'error',
                text: 'Gostaria de remover este comentário?',
                showCancelButton: true,
                confirmButtonText: "Remover",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
                allowEscapeKey: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#ed5565'
            },
            function () {
                $.post(href, dados, function (comentarios) {
                    $('.comentarios-enviados').html(comentarios);
                    toastr['success']("O comentário foi removido com sucesso.");
                });
            });
    });
});