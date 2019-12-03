$(function () {
    $('body').on('change', 'select[name="id_area"]', function (e) {
        var dados = {id: $(this).find('option:selected').val()},
            $grupos = $(this).parents('form').find('#carregar-grupos'),
            url = SITE_PATH + '/tarefas/carrega-grupo-acesso';

        $grupos.attr("disabled", true);
        $.post(url, dados, function (grupos) {
            $grupos.empty();

            $.each(grupos, function (i, grupo) {
                $grupos.append($('<option>', {
                    value: grupo.id,
                    text: grupo.descricao
                }));
            });
            $grupos.removeAttr('disabled');
        });
    });
});