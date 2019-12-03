$(function () {
    // Salva a descrição do plano de acao
    $('form[name="salvar-plano"]').submit(function (e) {

        e.preventDefault();
        var $this = $(this);
        if ($this.data('valid') == false) {
            return;
        }

        var dados = $this.serializeArray(),
            $botao = $this.find('button');

        $botao.text('Salvando...').attr('disabled', true);
        $.post($this.attr('action'), dados, function (observacoes) {
            // $('.observacoes-enviadas').html(observacoes);
            $('.alert-warning').remove();
            $this.find('textarea').attr('disabled', true);
            toastr['success']("O plano de ação foi salvo com sucesso.");
            $botao.remove();
        });
    });
});