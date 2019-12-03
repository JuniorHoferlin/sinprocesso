$(function () {
    $('#adicionar-insumo').click(function (event) {
        event.preventDefault();
        var $this = $('#itens-adicionar-insumo');
        var $data = {
            id_insumo: $this.find('#id_insumo').val(),
            nome_insumo: $this.find('#id_insumo').find('option:selected').html(),
            quantidade: parseInt($this.find('#quantidade').val()),
            media_consumo: $this.find('#media_consumo').val(),
            valor: $this.find('#valor').val()
        };

        var $erros = 0;

        if (!$.isNumeric($data.id_insumo)) $erros = 1;
        if ($data.nome_insumo == "") $erros = 1;
        if (!$.isNumeric($data.quantidade)) $erros = 1;
        if (!$.isNumeric($data.media_consumo)) $erros = 1;
        if (!$.isNumeric($data.valor.split('.').join('').split(',').join('.'))) $erros = 1;

        if ($erros == 0) {
            var $box = $('#aqui-adiciona-insumo');
            var $existe = $box.find('tr#insumo-adicionado-' + $data.id_insumo);

            if ($existe.length > 0) {
                $data.quantidade = $data.quantidade + parseInt($existe.find('input[name="insumo[' + $data.id_insumo + '][quantidade]"]').val());
                $existe.remove();
            }

            var $createElement = $('<tr />')
                .attr('id', 'insumo-adicionado-' + $data.id_insumo)
                .append($('<td />').html($data.nome_insumo))
                .append($('<td />').html($data.quantidade))
                .append($('<td />').html($data.media_consumo))
                .append($('<td />').html('R$ ' + $data.valor))
                .append(
                    $('<td />')
                        .append(
                            $('<button />')
                                .attr('type', 'button')
                                .attr('data-id', 'insumo-adicionado-' + $data.id_insumo)
                                .attr('class', 'btn btn-xs btn-danger')
                                .html('<i class="fa fa-trash"/>')
                                .bind('click', function () {
                                    var $this = $(this);
                                    swal({
                                        title: "Atenção",
                                        text: "Confirma a exclusão do insumo?",
                                        type: "warning",
                                        showCancelButton: true
                                    }, function (a) {
                                        if (a) {
                                            var $box = $('#aqui-adiciona-insumo');
                                            var $form = $('#itens-adicionar-insumo');

                                            $form.find('#id_insumo').find('option[value="' + $box.find('input[name="insumo[' + $data.id_insumo + '][id]"]').val() + '"]').prop('disabled', false);
                                            $form.find('#id_insumo').select2({
                                                allowClear: true,
                                                width: '100%',
                                                openOnEnter: false,
                                                theme: "bootstrap",
                                                language: "pt-BR",
                                                placeholder: "Selecione..."
                                            });

                                            $('#' + $this.data('id')).remove();
                                            if ($('#aqui-adiciona-insumo').find('tr').length > 0) {
                                                $('#nenhum-insumo-adicionado').addClass('hide');
                                                $('#algum-insumo-adicionado').removeClass('hide');
                                            } else {
                                                $('#algum-insumo-adicionado').addClass('hide');
                                                $('#nenhum-insumo-adicionado').removeClass('hide');
                                            }
                                        }
                                    })
                                })
                        )
                        .append($('<input />').attr('type', 'hidden').attr('name', 'insumo[' + $data.id_insumo + '][id]').val($data.id_insumo))
                        .append($('<input />').attr('type', 'hidden').attr('name', 'insumo[' + $data.id_insumo + '][nome]').val($data.nome_insumo))
                        .append($('<input />').attr('type', 'hidden').attr('name', 'insumo[' + $data.id_insumo + '][quantidade]').val($data.quantidade))
                        .append($('<input />').attr('type', 'hidden').attr('name', 'insumo[' + $data.id_insumo + '][media_consumo]').val($data.media_consumo))
                        .append($('<input />').attr('type', 'hidden').attr('name', 'insumo[' + $data.id_insumo + '][valor]').val($data.valor.split('.').join('').split(',').join('.')))
                );

            $createElement.appendTo($box);

            $this.find('input').val('');
            $this.find('select').val('').trigger('change');
            $this.find('#id_insumo').find('option[value="' + $data.id_insumo + '"]').prop('disabled', true);
            $this.find('#id_insumo').select2({
                allowClear: true,
                width: '100%',
                openOnEnter: false,
                theme: "bootstrap",
                language: "pt-BR",
                placeholder: "Selecione..."
            });
        }

        if ($('#aqui-adiciona-insumo').find('tr').length > 0) {
            $('#nenhum-insumo-adicionado').addClass('hide');
            $('#algum-insumo-adicionado').removeClass('hide');
        } else {
            $('#algum-insumo-adicionado').addClass('hide');
            $('#nenhum-insumo-adicionado').removeClass('hide');
        }
    });
});

function acrescentarQuantidade($this) {
    $('button.remove-btn-added').popover('destroy');
    $.ajax({
        url: SITE_PATH + "/termo-referencia/acrescentar-insumo",
        data: {id: $this.data('id')},
        type: 'post',
        success: function (data) {
            $this.popover({
                trigger: 'manual',
                html: true,
                placement: 'left',
                title: 'Acrescentar quantidade',
                content: data
            }).popover('show');

            $('#container-popover-add-' + $this.data('id')).formValidator();
            $('#overlay-popover').fadeIn();
        }
    });
}

function savePopover(e, $id) {
    e.preventDefault();
    setTimeout(function () {
        if ($('#container-popover-add-' + $id).find("[id*='_element_error']").length == 0) {
            $('#cancel-popover-add-' + $id).hide();
            $('#quantidade-popover-add-' + $id).prop('disabled', true);
            $('#motivo-popover-add-' + $id).prop('disabled', true);
            var $quantidade = $('#quantidade-popover-add-' + $id).val();
            var $motivo = $('#motivo-popover-add-' + $id).val();
            $.ajax({
                type: 'post',
                url: SITE_PATH + '/termo-referencia/acrescentar-insumo-salvar',
                data: {id: $id, quantidade: $quantidade, motivo: $motivo},
                success: function (response) {
                    var response = JSON.parse(response);
                    if (response.status == 1) {
                        $('.popover-btn-qtd').popover('destroy');
                        $('#overlay-popover').fadeOut();
                        toastr.success('A quantidade foi adicionada neste insumo.', 'Feito!');
                    } else {
                        $('#cancel-popover-add-' + $id).show();
                        $('#quantidade-popover-add-' + $id).prop('disabled', false);
                        $('#motivo-popover-add-' + $id).prop('disabled', false);
                        $.each(response.errors, function (i, error) {
                            toastr.error(error);
                        });
                    }
                },
                error: function (response) {
                    var response = JSON.parse(response.responseText);
                    $('#cancel-popover-add-' + $id).show();
                    $('#quantidade-popover-add-' + $id).prop('disabled', false);
                    $('#motivo-popover-add-' + $id).prop('disabled', false);
                    $.each(response.errors, function (i, error) {
                        toastr.error(error);
                    });
                }
            });
        }
    }, 50);
}

function closePopover() {
    $('.popover-btn-qtd').popover('destroy');
    $('#overlay-popover').fadeOut();
}