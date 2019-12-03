$(function () {

    // Atualiza a lista de tarefas
    $('body').on('click', '.atualizar-tarefas', function () {
        $(this).find('span').text('Carregando...');
        recarregarTarefas(function () {
            $('.atualizar-tarefas span').text('Atualizar');
        });
    });

    // Ações em uma tarefa
    $('body').on('click', '.icon-status', function () {
        var acao = $(this).attr('data-acao'),
            id = $(this).attr('data-id');

        switch (acao) {
            case 'iniciar': // inicia a tarefa
                iniciarTarefa(id);
                break;
            case 'decisao': // mostra modal para o usuário decidir o que quer fazer
                decidir(id);
                break;
            case 'escolherInsumos': // mostra modal para o usuário decidir o que quer fazer
                definirInsumo(id);
                break;
            case 'jaFinalizada':
                jaFinalizada();
                break;
            case 'jaReportada':
                jaReportada();
                break;
            case 'semPermissao': // exibe modal para dizer que ele não tem permissão
                semPermissao();
                break;
            case 'aguardeExecucao':
                aguardeExecucao();
                break;
        }
    });

    // Salva os documentos associados a tarefa
    $('form[name="adicionar-documento-tarefa"]').ajaxForm({
        delegation: true,
        beforeSend: function () {
            var bar = $('#documento_tarefa_progress_width');
            var percent = $('#documento_tarefa_progress_percent');
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var bar = $('#documento_tarefa_progress_width');
            var percent = $('#documento_tarefa_progress_percent');
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function (xhr) {
            var bar = $('#documento_tarefa_progress_width');
            var percent = $('#documento_tarefa_progress_percent');
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            $('form[name="adicionar-documento-tarefa"]')[0].reset();

            if (xhr.responseJSON.hasOwnProperty('view')) {
                $('#documentos-tarefa').html(xhr.responseJSON.view);
                toastr['success']("Documento salvo com sucesso na tarefa.");
            } else {
                toastr['error']("Houve um erro ao anexar o documento na tarefa, contate o suporte técnico.");
            }
        }
    });

    // Remove um documento de uma tarefa
    $('body').on('click', '.remover-documento-tarefa', function (e) {
        e.preventDefault();

        var href = $(this).attr('href'),
            id = $(this).attr('data-id'),
            dados = {id: id};

        swal({
                title: "Confirmar",
                type: 'error',
                text: 'Gostaria de remover este documento?',
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
                    $('#documentos-tarefa').html(retorno.view);
                    toastr['success']("O documento foi removido com sucesso.");
                });
            });
    });

    // Adiciona uma nova observacao na tarefa
    $('body').on('submit', 'form[name="adicionar-observacao-tarefa"]', function (e) {
        e.preventDefault();
        var $this = $(this);

        var dados = $this.serializeArray(),
            $botao = $this.find('button'),
            idProcesso = $('input[name="id_processo"]').val();


        dados.push({name: 'id_processo', value: idProcesso});
        $botao.text('Salvando...').attr('disabled', true);
        $.post($this.attr('action'), dados, function (observacoes) {
            $('#observacoes-tarefa').html(observacoes);
            $this.find('textarea').val('');
            toastr['success']("A observação foi adicionada com sucesso.");
            $botao.text('Salvar').removeAttr('disabled');
        });
    });

    // Remove uma observação
    $('body').on('click', '.remover-observacao-tarefa', function (e) {
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
                    $('#observacoes-tarefa').html(observacoes);
                    toastr['success']("A observação foi removida com sucesso.");
                });
            });
    });

    // Adiciona um novo comentário na tarefa
    $('body').on('submit', 'form[name="adicionar-comentario-tarefa"]', function (e) {
        e.preventDefault();
        var $this = $(this);

        var dados = $this.serializeArray(),
            $botao = $this.find('button'),
            idProcesso = $('input[name="id_processo"]').val();

        dados.push({name: 'id_processo', value: idProcesso});
        $botao.text('Salvando...').attr('disabled', true);
        $.post($this.attr('action'), dados, function (comentarios) {
            $('#comentarios-tarefa').html(comentarios);
            $this.find('textarea').val('');
            toastr['success']("O comentário foi adicionado com sucesso.");
            $botao.text('Salvar').removeAttr('disabled');
        });
    });

    // Remove um comentário
    $('body').on('click', '.remover-comentario-tarefa', function (e) {
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
                    $('#comentarios-tarefa').html(comentarios);
                    toastr['success']("O comentário foi removido com sucesso.");
                });
            });
    });

    // Exibe formulário para adição de uma nova tarefa dentro do processo
    $('body').on('click', '.adicionar-tarefa', function (e) {
        e.preventDefault();
        var $div = $('.adicionar-tarefa-form'),
            $this = $(this);

        $this.find('span').text('Carregando...');
        $this.attr('disabled', true);
        $.get($(this).attr('href'), function (retorno) {
            $div.html('');
            $div.html(retorno);
            sistema.aplicarPluginsExternos($div);
            selectArea.iniciaSelect();
            $this.find('span').text('Adicionar tarefa');
            $this.removeAttr('disabled');
        });
    });

    // Remove o form de adicionar tarefa
    $('body').on('click', '.cancelar-adicionar-tarefa', function (e) {
        e.preventDefault();
        $('.adicionar-tarefa-form').html('');
    })

    // Adiciona a tarefa somente neste processo
    $('body').on('submit', '.adicionar-tarefa-form form', function (e) {
        e.preventDefault();
        var $this = $(this),
            url = $this.attr('action'),
            dados = $this.serializeArray(),
            id = $("input[name='id_processo']").val(),
            $botao = $this.find('button[type="submit"]');

        dados.push({name: 'id_processo', value: id});

        $botao.text('Adicionando...').attr('disabled', true);
        $.post(url, dados, function (retorno) {
            recarregarTarefas(function () {
                if (retorno.hasOwnProperty('mensagem')) {
                    toastr['error'](retorno.mensagem);
                } else {
                    toastr['success']('A tarefa foi adicionada ao processo com sucesso.');
                }

                $this.html('');
            });
        });
    })

    /**
     * Atualiza a lista de tarefas.
     *
     * @param callback
     */
    function recarregarTarefas(callback) {
        var idProcesso = $('input[name="id_processo"]').val();
        $.post(SITE_PATH + '/processos/carregar-tarefas', {id: idProcesso}, function (view) {
            if (view == "FINALIZADO") {
                location.reload();
            } else {
                $('#tarefas-processo').html(view.tarefas);
                $('#progresso-processo').html(view.progresso);
                $('#painel-processo').html(view.painel);
                if (callback) {
                    callback();
                }
            }
        });
    }

    /**
     * Exibe modal para o usuário decidir o que vai fazer.
     *
     * @param id
     */
    function decidir(id) {
        swal({
            title: "Opções",
            text: "Oque você deseja fazer com esta tarefa?",
            showCancelButton: true,
            cancelButtonText: "Reportar",
            confirmButtonColor: "#1AB394",
            confirmButtonText: "Finalizar",
            closeOnConfirm: true,
            closeOnCancel: false,
            type: "warning"
        }, function (retorno) {
            if (retorno) {
                finalizar(id);
            } else {
                reportar(id);
            }
        });
    }

    /**
     * Exibe modal mostrando para o usuário que ele não tem permissão para executar nada nesta tarefa.
     */
    function semPermissao() {
        swal({
            title: "Sem Permissão",
            text: "Você pode visualizar, mas não pode executar nenhuma ação nesta tarefa",
            showCancelButton: false,
            confirmButtonColor: "#1AB394",
            confirmButtonText: "Ok",
            closeOnConfirm: true,
            closeOnCancel: false,
            type: "warning"
        });
    }

    /**
     * Exibe modal mostrando para o usuário que ele não tem permissão para executar nada nesta tarefa.
     */
    function aguardeExecucao() {
        swal({
            title: "Aguarde",
            text: "Aguarde a execução da tarefa em andamento",
            showCancelButton: false,
            confirmButtonColor: "#1AB394",
            confirmButtonText: "Ok",
            closeOnConfirm: true,
            closeOnCancel: false,
            type: "warning"
        });
    }

    /**
     * Exibe modal mostrando para o usuário que a tarefa já foi finalizada.
     */
    function jaFinalizada() {
        swal({
            title: "Tarefa Finalizada",
            text: "Esta tarefa já foi finalizada.",
            showCancelButton: false,
            confirmButtonColor: "#1AB394",
            confirmButtonText: "Ok",
            closeOnConfirm: true,
            closeOnCancel: false,
            type: "info"
        });
    }

    /**
     * Exibe modal mostrando para o usuário que a tarefa foi reportada.
     */
    function jaReportada() {
        swal({
            title: "Tarefa Reportada",
            text: "Esta tarefa foi reportada.",
            showCancelButton: false,
            confirmButtonColor: "#1AB394",
            confirmButtonText: "Ok",
            closeOnConfirm: true,
            closeOnCancel: false,
            type: "info"
        });
    }

    /**
     * Inicia uma tarefa.
     *
     * @param int id
     */
    function iniciarTarefa(id) {
        swal({
            title: "Iniciar",
            text: "Você gostaria de iniciar esta tarefa?",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#1AB394",
            closeOnConfirm: true,
            confirmButtonText: "Iniciar",
            type: "warning"
        }, function () {
            $.post(SITE_PATH + '/tarefas/iniciar', {id: id}, function (retorno) {
                if (retorno.hasOwnProperty('mensagem')) {
                    toastr['error'](retorno.mensagem);
                    return;
                }

                toastr['success']("A tarefa foi iniciada com sucesso.");
                recarregarTarefas();
            });
        });
    }

    /**
     * Finaliza a tarefa que estava em andamento.
     *
     * @param id
     */
    function finalizar(id) {
        $.post(SITE_PATH + '/tarefas/finalizar', {id: id}, function (retorno) {
            if (retorno) {
                recarregarTarefas();
                toastr['success']("A tarefa foi finalizada com sucesso.");
            } else {
                toastr['error']("Houve um erro ao finalizar a tarefa.");
            }
            swal.close();
        });
    }

    /**
     * Reporta uma tarefa.
     *
     * @param id
     */
    function reportar(id) {
        $.post(SITE_PATH + '/tarefas/carregar-para-reportar', {id: id}, function (retorno) {
            if (retorno == false) {
                swal({
                    title: "Ops!",
                    text: "Você não pode reportar nenhuma tarefa até o momento.",
                    type: "warning"
                });
                return;
            }

            // Caso tenha alguma tarefa a ser reportada, vamos exibir a lista para o usuário selecionar
            swal({
                title: "",
                text: retorno,
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonText: "Reportar",
                confirmButtonColor: '#ed5565',
                closeOnConfirm: false,
                html: true
            }, function (data) {
                if (data) {
                    var dados = $('input.tarefas-reportar:checked').serializeArray();
                    if (dados.length == 0) {
                        toastr['warning']("Selecione pelo menos uma tarefa para reportar.");
                        return;
                    }

                    // Coloca no array o ID da tarefa original também
                    dados.push({name: 'id', value: id});
                    $.post(SITE_PATH + '/tarefas/reportar', dados, function (retorno) {
                        if (retorno) {
                            recarregarTarefas();
                            toastr['success']("A(s) tarefa(s) foram reportadas com sucesso.");
                            swal.close();
                        } else {
                            toastr['error']("Houve um erro ao reportar a(s) tarefa(s).");
                        }
                    });
                }
            });
        })
    }

    /**
     * Escolher insumos da COMPRA.
     *
     * @param id
     */
    function definirInsumo(id) {
        $.post(SITE_PATH + '/tarefas/carregar-para-comprar', {id: id}, function (retorno) {
            if (retorno == false) {
                swal({
                    title: "Ops!",
                    text: "Não existe nenhum insumo disponivel para compra.",
                    type: "warning"
                });
                return;
            }

            // Caso tenha alguma tarefa a ser reportada, vamos exibir a lista para o usuário selecionar
            swal({
                title: "",
                text: retorno,
                customClass: 'seleciona-insumo-tarefa',
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonText: "Comprar",
                confirmButtonColor: '#ed5565',
                closeOnConfirm: false,
                html: true
            }, function (data) {
                if (data) {
                    $('.confirm').attr('disabled', true);
                    var dados = {};

                    $('.comprar-produto-' + id).each(function () {
                        var qtEscolhido = $(this).find('option:selected').val(),
                            idEscolhido = $(this).data('id');

                        if (qtEscolhido > 0) {
                            dados[idEscolhido] = {quantidade: qtEscolhido};
                        }
                    });

                    if (dados.length == 0) {
                        toastr['warning']("Selecione pelo menos um insumo para comprar.");
                        return;
                    }

                    $.post(SITE_PATH + '/tarefas/comprar', {id: id, insumos: dados}, function (retorno) {
                        if (retorno) {
                            recarregarTarefas();
                            toastr['success']("Compra realizada com sucesso.");
                            swal.close();
                        } else {
                            toastr['error']("Houve um erro efetuar a compra.");
                        }

                        $('.confirm').removeAttr('disabled');
                    });
                }
            });
        })
    }
});