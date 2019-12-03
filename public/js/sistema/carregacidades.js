$(function () {
    $('select[name="id_estado"], select[name="estado"]').change(function (e) {
        var dados = {id: $(this).find('option:selected').val()},
            $cidades = $(this).parents('form').find('#id_cidade'),
            url = SITE_PATH + '/usuarios/carrega-cidades'


        $.post(url, dados, function (cidades) {
            $cidades.empty();

            $.each(cidades, function (i, cidade) {
                $cidades.append($('<option>', {
                    value: cidade.id,
                    text: cidade.descricao
                }));
            });
        });
    });
});