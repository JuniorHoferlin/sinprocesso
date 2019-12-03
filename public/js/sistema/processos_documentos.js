$(function () {
    // Salva os documentos associados ao processo
    $('form[name="salvar-documentos"]').submit(function (e) {
        e.preventDefault();
        var $this = $(this);

        var dados = $this.serializeArray(),
            $botao = $this.find('button');

        $botao.text('Salvando...').attr('disabled', true);
        $.post($this.attr('action'), dados, function (retorno) {
            if (retorno) {
                toastr['success']("Os dados foram salvos com sucesso.");
            }
            $botao.text('Salvar').removeAttr('disabled');
        });
    });
});