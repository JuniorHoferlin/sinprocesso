/*!
 * Validator
 * version: 1.0
 * Copyright (c) 2017 Mauricio Guariero
 * Licença MIT
 */
$(function () {

    $.fn.formValidator = function () {
        var passwordValue;
        var emailValue;
        var is;
        var BORDER_COLOR_SUCCESS = "";//"1px solid rgb(24, 166, 137)";
        var BORDER_COLOR_ERROR = "1px solid rgb(237, 85, 101)";
        var ELEMENT_ERROR_MENSAGEM;
        var ELEMENT_ERROR_STYLE = "padding: 0px;margin: 0px;font-size: 12px;color: rgb(237, 85, 101);";
        var $form = $(this);
        var tab_clicked;

        var masks = {
            time: function timeMask(e) {
                e.mask("99:99");
                if ($(e).parents('div.clockpicker').length) {
                    e = $(e).parents('div.clockpicker');
                }
                e.clockpicker({
                    donetext: 'Pronto'
                }).on('hide', function (e) {
                    genericValidationElement($(this));
                });
            },
            cpf: function cpfMask(e) {
                e.mask("999.999.999-99");
            },
            cnpj: function cnpjMask(e) {
                e.mask("99.999.999/9999-99");
            },
            cpf_cnpj: function cpfCnpjMask(e) {
            },
            // datetime: function dateMask(e) {
            //     e.mask("99/99/9999 99:99:99");
            //     e.datetimepicker({
            //         format: "DD/MM/YYYY HH:mm:ss",
            //         locale: "pt-BR",
            //         showTodayButton: true
            //     }).on('hide', function (e) {
            //         genericValidationElement($(this));
            //     });
            // },
            date: function dateMask(e) {
                e.mask("99/99/9999");
                e.datepicker({
                    format: "dd/mm/yyyy",
                    todayBtn: "linked",
                    language: "pt_BR",
                    calendarWeeks: true,
                    autoclose: true
                }).on('hide', function (e) {
                    genericValidationElement($(this));
                });
            },
            phone: function phoneMask(e) {
                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function (val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };
                e.mask(SPMaskBehavior, spOptions);
            },
            cep: function cepMask(e) {
                e.mask("99999-999");
            },
            money: function moneyMask(e) {
                e.maskMoney({
                    showSymbol: false,
                    thousands: '.',
                    decimal: ',',
                    symbolStay: false
                });
            },
            numeric: function moneyMask(e) {
                e.maskMoney({
                    showSymbol: false,
                    precision: 0,
                    thousands: '',
                    decimal: ''
                });
            }
        };

        var validator = {
            email: function validateEmail(value, element) {
                var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                emailValue = value;
                return validateByRegex(value, element, regex);
            },
            secondEmail: function confirmEmail(value, element) {
                if (emailValue === value && value.length) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            cpf: function validateCPF(value, element) {
                if (validatorCPF(value)) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            cnpj: function validateCNPJ(value, element) {
                if (validatorCNPJ(value)) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            cpf_cnpj: function validadeCpfCnpj(value, element) {
                validation = false;

                if (value.length <= 14) {
                    value = mascaraCPF(value);
                    element.val(value);
                    validation = validatorCPF(value);
                } else {
                    value = mascaraCNPJ(value);
                    element.val(value);
                    validation = validatorCNPJ(value);
                }

                if (validation) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            required: function isRequired(value, element) {
                if (value.length) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            date: function validateDate(value, element) {
                var regex = /^(0([1-9])|(1|2)([0-9])|3([0-1]))\/(0([1-9])|1([0-2]))\/(19|2[0-9])[0-9]{2}/;
                return validateByRegex(value, element, regex);
            },
            datetime: function validateDate(value, element) {
                var matches = value.match(/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})$/);
                if (matches === null) {
                    return error(element);
                } else {
                    var year = parseInt(matches[3], 10);
                    var month = parseInt(matches[2], 10) - 1; // months are 0-11
                    var day = parseInt(matches[1], 10);
                    var hour = parseInt(matches[4], 10);
                    var minute = parseInt(matches[5], 10);
                    var second = parseInt(matches[6], 10);
                    var date = new Date(year, month, day, hour, minute, second);
                    if (date.getFullYear() !== year
                        || date.getMonth() != month
                        || date.getDate() !== day
                        || date.getHours() !== hour
                        || date.getMinutes() !== minute
                        || date.getSeconds() !== second
                    ) {
                        return error(element);
                    } else {
                        return success(element);
                    }
                }
            },
            phone: function validatePhone(value, element) {
                var regex = /^\([0-9]{2}\)\s[0-9]{4}[0-9]?\-[0-9]{4}/;
                return validateByRegex(value, element, regex);
            },
            cep: function validateCEP(value, element) {

                $.ajax({
                    url: '//app.credseguro.com.br/webservice/' + value,
                    type: 'GET',
                }).done(function (jsonString) {
                    var json = $.parseJSON(jsonString);
                    // var form = element.closest('form');
                    if (json.success) {
                        var estado = $form.find('.estado');
                        var cidade = $form.find('.cidade');
                        var bairro = $form.find('.bairro');
                        var endereco = $form.find('.endereco');

                        estado.val(json.estado);
                        cidade.val(json.cidade);
                        bairro.val(json.bairro);
                        endereco.val(json.logradouro_tipo + " " + json.logradouro);

                        success(estado);
                        success(cidade);
                        success(bairro);
                        success(endereco);
                        return success(element);

                    } else {
                        return error(element);
                    }

                }).fail(function () {
                    return error(element);
                });
            },
            money: function validateMoney(value, element) {
                var regex = /^(\R\$\s)?([0-9]{1,3}\.)*[0-9]{1,3}\,[0-9]{2}/;
                return validateByRegex(value, element, regex);
            },
            numeric: function validateNumeric(value, element) {
                var regex = /^\d+$/;
                return validateByRegex(value, element, regex);
            },
            firstPass: function validatePass(value, element) {
                passwordValue = value;

                if (value.length) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            secondPass: function confirmPass(value, element) {
                if (passwordValue === value && value.length) {
                    return success(element);
                } else {
                    return error(element);
                }
            },
            time: function validationTime(value, element) {
                var regex = /^(([0-1]\d)|(2[0-3]))\:[0-5]\d/;
                return validateByRegex(value, element, regex);
            }

        };

        var mensagem = {
            email: "Digite um email válido",
            secondEmail: "Este email deve ser igual ao outro",
            cpf: "Número de CPF inválido",
            cnpj: "Número de CNPJ inválido",
            cpf_cnpj: "Número de CPF/CNPJ inválido",
            required: "Preenchimento obrigatório",
            date: "Insira uma data válida",
            datetime: "Insira uma data e hora válida",
            phone: "Número de telefone inválido",
            cep: "Código de CEP inválido",
            money: "Preencha este campo corretamente",
            numeric: "Preencha este campo corretamente",
            firstPass: "Preencha este campo corretamente",
            secondPass: "Preencha este campo corretamente",
            time: "Preencha um horário corretamente"
        };

        function init() {
            $form.each(function () {
                $(this).find('input,select,textarea').each(function (i) {
                    var attr = $(this).attr('is');
                    if (typeof attr !== typeof undefined && attr !== false) {
                        var fn = masks[attr];
                        if (typeof fn === "function") {
                            fn($(this));
                        }
                    }
                });
            });
        }

        function validatorCPF(str) {
            str = str.replace('.', '');
            str = str.replace('.', '');
            str = str.replace('-', '');
            cpf = str;
            var numeros, digitos, soma, i, resultado, digitos_iguais;
            digitos_iguais = 1;
            if (cpf.length != 11) {
                return false;
            }
            for (i = 0; i < cpf.length - 1; i++) {
                if (cpf.charAt(i) != cpf.charAt(i + 1)) {
                    digitos_iguais = 0;
                    break;
                }
            }
            if (!digitos_iguais) {
                numeros = cpf.substring(0, 9);
                digitos = cpf.substring(9);
                soma = 0;
                for (i = 10; i > 1; i--) {
                    soma += numeros.charAt(10 - i) * i;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0)) {
                    return false;
                }
                numeros = cpf.substring(0, 10);
                soma = 0;
                for (i = 11; i > 1; i--) {
                    soma += numeros.charAt(11 - i) * i;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1)) {
                    return false;
                }
                return true;
            }
            else {
                return false;
            }
        }

        function validatorCNPJ(cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g, '');
            if (cnpj == '') return false;
            if (cnpj.length != 14)
                return false;
            if (cnpj == "00000000000000" ||
                cnpj == "11111111111111" ||
                cnpj == "22222222222222" ||
                cnpj == "33333333333333" ||
                cnpj == "44444444444444" ||
                cnpj == "55555555555555" ||
                cnpj == "66666666666666" ||
                cnpj == "77777777777777" ||
                cnpj == "88888888888888" ||
                cnpj == "99999999999999")
                return false;
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0, tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;
            return true;
        }

        function validateByRegex(value, element, regex) {
            if (regex.exec(value)) {
                return success(element);
            } else {
                return error(element);
            }
        }

        function success(element) {
            if (element.attr('type') == 'file') {
                if (element.parents('.fileinput').length > 0) {
                    $(element.parents('.fileinput')[0]).css("border", BORDER_COLOR_SUCCESS);
                } else {
                    element.css("border", BORDER_COLOR_SUCCESS);
                }
            } else {
                if (element.prop('tagName').toLowerCase() === "select") {
                    element.next('span.select2').find('.select2-selection').css("border", BORDER_COLOR_SUCCESS);
                } else {
                    element.css("border", BORDER_COLOR_SUCCESS);
                }
            }

            $('#' + element.attr('id') + '_element_error').remove();
            return true;
        }

        function error(element) {
            if (element.attr('type') == 'file') {
                if (element.parents('.fileinput').length > 0) {
                    $(element.parents('.fileinput')[0]).css("border", BORDER_COLOR_ERROR);
                } else {
                    element.css("border", BORDER_COLOR_ERROR);
                }
            } else {
                if (element.prop('tagName').toLowerCase() === "select") {
                    element.next('span.select2').find('.select2-selection').css("border", BORDER_COLOR_ERROR);
                } else {
                    element.css("border", BORDER_COLOR_ERROR);
                }
            }

            $('#' + element.attr('id') + '_element_error').remove();
            var elem = $("<p style='" + ELEMENT_ERROR_STYLE + "'>" + ELEMENT_ERROR_MENSAGEM + "</p>").attr('id', element.attr('id') + '_element_error');
            if (element.attr('type') == "checkbox" || element.attr('type') == "radio") {
                elem.insertAfter(element.parents('label'));
            } else {
                if (element.attr('type') == 'file') {
                    if (element.parents('.fileinput').length > 0) {
                        elem.insertAfter($(element.parents('.fileinput')[0]));
                    }
                } else {
                    if (element.prop('tagName').toLowerCase() === "select") {
                        elem.insertAfter($(element.next('span.select2')[0]));
                    } else {
                        elem.insertAfter(element);
                    }
                }
            }

            if (element.parents('div.tab-content').length > 0) {
                var link_tab = $('[href="#' + element.parents('div.tab-pane').attr('id') + '"]');
                if (link_tab.length > 0) {
                    if (!tab_clicked) {
                        link_tab.click();
                        tab_clicked = true;
                    }
                }
            }

            return false;
        }

        function genericValidation() {
            is = $(this).attr('is');
            if ($(this).attr('msg')) {
                ELEMENT_ERROR_MENSAGEM = $(this).attr('msg');
            } else {
                ELEMENT_ERROR_MENSAGEM = mensagem[is];
            }

            var fn = validator[is];
            var v = $(this).val();
            if (typeof fn === "function") {
                return fn(v, $(this));
            }
            return false;
        }

        function genericValidationElement(element) {
            is = element.attr('is');
            if (element.attr('msg')) {
                ELEMENT_ERROR_MENSAGEM = element.attr('msg');
            } else {
                ELEMENT_ERROR_MENSAGEM = mensagem[is];
            }
            var fn = validator[is];
            var v = element.val();

            if (element.attr('type') == 'checkbox') {
                if (element.attr('data-one') != "") {
                    if ($('[data-one=' + element.attr('data-one') + ']').length > 1) {
                        var one_checked = false;
                        $('[data-one=' + element.attr('data-one') + ']').each(function () {
                            if ($(this).is(':checked')) {
                                one_checked = true;
                            }
                        });
                        if (one_checked) {
                            return success(element);
                        } else {
                            return error(element);
                        }
                    } else {
                        if (element.is(':checked')) {
                            return success(element);
                        } else {
                            return error(element);
                        }
                    }
                } else {
                    if (element.is(':checked')) {
                        return success(element);
                    } else {
                        return error(element);
                    }
                }
            }

            if (typeof fn === "function") {
                return fn(v, element);
            }
            return false;
        }

        function mascaraCPF(valor) {
            valor = valor.replace(/\D/g, "");
            valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
            valor = valor.replace(/(\d{3})\.(\d{3})(\d)/, "$1.$2.$3");
            valor = valor.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})$/, "$1.$2.$3-$4");
            return valor;
        }

        function mascaraCNPJ(valor) {
            valor = valor.replace(/\D/g, "");
            valor = valor.replace(/(\d{2})(\d)/, "$1.$2");
            valor = valor.replace(/(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            valor = valor.replace(/(\d{2})\.(\d{3})\.(\d{3})(\d)/, "$1.$2.$3/$4");
            valor = valor.replace(/(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d{1,2})/, "$1.$2.$3/$4-$5");
            return valor;
        }

        init();

        $(this).find('input').blur(genericValidation);
        $(this).find('input').change(genericValidation);
        $(this).find('input').on('keyup', genericValidation);

        $(this).find('textarea').blur(genericValidation);
        $(this).find('textarea').on('keyup', genericValidation);

        $(this).find('select').change(genericValidation);

        $(this).submit(function (event) {
            tab_clicked = false;
            var validationFail = false;
            $(this).find('input,select,textarea').each(function (i) {
                var attr = $(this).attr('is');
                if (typeof attr !== typeof undefined && attr !== false) {
                    var border = $(this).css('border');
                    if (border !== BORDER_COLOR_SUCCESS) {
                        if (!genericValidationElement($(this))) {
                            validationFail = true;
                        }
                    }
                }
            });
            if (validationFail) {
                event.preventDefault();
                $(this).data('valid', false);
                return false;
            } else {
                $(this).data('valid', true);
                if ($(this).data('call')) {
                    var call = new Function($(this).data('call'));
                    if (typeof  call === 'function') {
                        event.preventDefault();
                        call();
                    }
                }
                return true;
            }
        });
    };


    var masked = {
        time: function timeMask(e) {
            e.mask("99:99");
        },
        cpf: function cpfMask(e) {
            e.mask("999.999.999-99");
        },
        cnpj: function cnpjMask(e) {
            e.mask("99.999.999/9999-99");
        },
        cpf_cnpj: function cpfCnpjMask(e) {
        },
        // datetime: function dateMask(e) {
        //     e.mask("99/99/9999 99:99:99");
        //     e.datetimepicker({
        //         format: "DD/MM/YYYY HH:mm:ss",
        //         locale: "pt-BR",
        //         showTodayButton: true
        //     });
        // },
        date: function dateMask(e) {
            e.mask("99/99/9999");
            e.datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                language: "pt_BR",
                autoclose: true
            });
        },
        phone: function phoneMask(e) {
            var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };
            e.mask(SPMaskBehavior, spOptions);
        },
        cep: function cepMask(e) {
            e.mask("99999-999");
        },
        money: function moneyMask(e) {
            e.maskMoney({
                showSymbol: false,
                thousands: '.',
                decimal: ',',
                symbolStay: false
            });
        },
        numeric: function moneyMask(e) {
            e.maskMoney({
                showSymbol: false,
                precision: 0,
                thousands: '',
                decimal: ''
            });
        }
    };

    masked['date']($('.mask-date'));
    // masked['datetime']($('.mask-datetime'));
    masked['money']($('.mask-decimal'));
    masked['numeric']($('.mask-number'));
    masked['time']($('.mask-time'));

    $('input[mask]').each(function () {
        if ($(this).attr('mask') == 'time') {
            if ($(this).parents('div.clock').length) {
                return masked[$(this).attr('mask')]($(this).parents('div.clock'));
            }
        }
        return masked[$(this).attr('mask')]($(this));
    });
});