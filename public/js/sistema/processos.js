$(function () {

    // Quando tentar abrir o novo processo
    $('form[name="novo-processo"]').on('submit', function (e) {
        $(this).find('button[type="submit"]').attr('disabled', true);

        var tr = $('input[name="tr"]').length;
        if (tr > 0) {
            validarFormularioAberturaProcesso(e);
        }

        validarCheckboxesFormulario(e);
        return true;
    });

    function validarFormularioAberturaProcesso(event) {
        if ($('input.validar-insumo:checked').length == 0) {
            event.preventDefault();
            swal('Atenção!', 'Você precisa selecionar ao menos 1 insumo para abrir o processo.', 'error');
        }
        $('.validar-maximo').each(function () {
            if (!$(this).prop('disabled')) {
                var atual = parseInt($(this).val());
                if (atual > 0) {
                    if (atual > $(this).data('max')) {
                        swal('Atenção!', 'A quantidade do insumo precisa ser menor que ' + $(this).data('max') + '.', 'error');
                        $(this).val('').focus();
                        event.preventDefault();
                    }
                } else {
                    swal('Atenção!', 'A quantidade do insumo precisa ser maior que 0.', 'error');
                    $(this).val('').focus();
                    event.preventDefault();
                }
            }
        });
    }

    function validarCheckboxesFormulario(event) {
        var checkBoxes = $('input[type="checkbox"][data-pelo-menos="true"]');
        if (checkBoxes.length == 0) return;

        var isChecked = false;
        for (var i = 0; i < checkBoxes.length; i++) {
            if (checkBoxes[i].checked) {
                isChecked = true;
            }
        }
        if (!isChecked) {
            event.preventDefault();
            toastr['error']("Preencha pelo menos uma das opções do formulário.");
        }
    }

    // Ao clicar nas opções das regras
    $('.validar-regras input[type=radio]').change(function () {
        var id = $(this).data('id');
        if (this.value == '0') {
            $('#regra-incorreta-' + id).removeClass('hide');
            $('#regra-incorreta-' + id + ' textarea').val('').attr('required', true);
        } else {
            $('#regra-incorreta-' + id).addClass('hide');
            $('#regra-incorreta-' + id + ' textarea').val('').attr('required', false);
        }

        verificarConclusaoRegras();
    });
    function verificarConclusaoRegras() {
        var todosCorretos = true;
        $('.validar-regras input[type=radio][value="1"]').each(function () {
            if (!$(this).is(':checked')) {
                todosCorretos = false;
            }
        });

        if (todosCorretos) {
            $('#detalhes').removeClass('hide');
            $('#formulario').removeClass('hide');
            $('.desativar-com-regra').attr('disabled', false);
            $('.desativar-com-regra').attr('is', 'required');
        } else {
            $('#detalhes').addClass('hide');
            $('#formulario').addClass('hide');
            $('.desativar-com-regra').attr('disabled', true);
            $('.desativar-com-regra').removeAttr('is');
        }
    }

    // Ao finalizar processo
    $('.finalizar-processo').click(function (e) {
        e.preventDefault();
        var desativado = $(this).hasClass('disabled'),
            url = $(this).attr('href'),
            id = $('input[name="id_processo"]').val();

        if (!desativado) {
            swal({
                title: "Atenção!",
                text: "Você deseja prosseguir com esta ação?",
                type: "warning",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Finalizar",
                confirmButtonColor: "#ed5565",
                showCancelButton: true,
                allowEscapeKey: false,
                closeOnConfirm: true
            }, function (data) {
                if (data) {
                    $.post(url, {id: id}, function (retorno) {
                        if (retorno.hasOwnProperty('url')) {
                            window.location.assign(retorno.url);
                        } else {
                            toastr['error']("Houve um erro ao finalizar o processo, contate o suporte técnico.");
                        }
                    });
                }
            });
        }
    })

    // Ao marcar os insumos
    $('.validar-insumo').change(function () {
        if ($(this).is(':checked')) {
            $('#qtd' + $(this).data('id')).attr('disabled', false);
            $('#qtd' + $(this).data('id')).val('').focus();
        } else {
            $('#qtd' + $(this).data('id')).val('');
            $('#qtd' + $(this).data('id')).attr('disabled', true);
        }
    });

    // Marca a tarefa de compra do processo como Sala de Situação
    $('body').on('click', '.marcar-sala-situacao', function (e) {
        e.preventDefault();
        var $this = $(this),
            url = $(this).attr('href'),
            id = $('input[name="id_processo"]').val();

        swal({
            title: "Atenção!",
            text: "Deseja mesmo marcar este processo em Sala de Situação?",
            type: "warning",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sim",
            confirmButtonColor: "#ed5565",
            showCancelButton: true,
            allowEscapeKey: false,
            closeOnConfirm: true
        }, function (data) {
            if (data) {
                $this.find('span').text('Aguarde...');
                $this.addClass('disabled');
                $.post(url, {id: id}, function (retorno) {
                    if (retorno.hasOwnProperty('mensagem')) {
                        toastr['error'](retorno.mensagem);
                    } else {
                        toastr['success']("O processo foi marcado em Sala de Situação com sucesso.");
                        $('.em-sala-situacao').removeClass('hide');
                        $this.addClass('hide');
                        $('.atualizar-tarefas').click();
                    }
                });
            }
        });
    });
});