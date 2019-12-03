$(function () {

    $('body').on('submit', 'form#abrir-chamado', function (e) {
        e.preventDefault();
        var $this = $(this);

        if ($this.data('valid') == false) {
            return;
        }

        var dados = $this.serializeArray(),
            $botao = $this.find('input[type="submit"]');
        $botao.val('Salvando...').attr('disabled', true).addClass('disabled');
        $.post($this.attr('action'), dados, function (chamados) {
            $('.chamados-enviados').html(chamados.view);
            $this.parents('.modal').modal('hide');
            if (chamados.status == 1) {
                toastr['success']("O chamado foi aberto com sucesso.");
            } else {
                toastr['error']("Nao foi possivel abrir o chamado no memento, tente mais tarde.");
            }
        });
    });
});

