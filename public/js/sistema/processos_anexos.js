$(function () {
    // Salva os documentos associados ao processo
    var bar = $('#anexo_progress_width');
    var percent = $('#anexo_progress_percent');

    $('form[name="adicionar-anexo"]').ajaxForm({
        beforeSend: function () {
            $('form[name="adicionar-anexo"]').find("input[type='submit']").attr('disabled', true);
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function (xhr) {
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            $('form[name="adicionar-anexo"]')[0].reset();

            if (!xhr.responseJSON) {
                toastr['error']("Houve um erro ao salvar o anexo, contate o suporte técnico.");
            } else {
                $('#anexos-enviados').html(xhr.responseJSON.view);
                toastr['success']("Anexo salvo com sucesso no processo.");
            }

            $('form[name="adicionar-anexo"]').find("input[type='submit']").removeAttr('disabled');
        }
    });

    $('body').on('click', '.remover-anexo', function (e) {
        e.preventDefault();

        var href = $(this).attr('href'),
            id = $(this).attr('data-id'),
            dados = {id: id};

        swal({
                title: "Confirmar",
                type: 'error',
                text: 'Gostaria de remover este anexo?',
                showCancelButton: true,
                confirmButtonText: "Remover",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
                allowEscapeKey: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#ed5565'
            },
            function () {
                $.post(href, dados, function (retorno) {
                    $('#anexos-enviados').html(retorno.view);
                    toastr['success']("O anexo foi removido com sucesso.");
                });
            });
    });
});