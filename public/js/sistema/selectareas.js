var selectArea = {
    iniciaSelect: function () {
        var json = $('#areas').attr('data-areas');
        if (typeof json == 'undefined') {
            return;
        }

        var data = JSON.parse($('#areas').attr('data-areas'));

        $('#areas').select2({
            allowClear: true,
            data: data,
            templateResult: this.formataResultado,
            width: '100%',
            openOnEnter: false,
            theme: "bootstrap",
            language: "pt-BR"
        });
        $("#areas option[value='']").remove();
    },

    formataResultado: function (node) {
        var $result = $('<span style="padding-left:' + (20 * node.level) + 'px;">' + node.text + '</span>');
        return $result;
    }
}

$(function () {
    selectArea.iniciaSelect();
})