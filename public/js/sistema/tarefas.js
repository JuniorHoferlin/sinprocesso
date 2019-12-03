$(function () {
    $('#dependencias tr').click(function () {
        $(this).find('input').prop('checked', !$(this).find('input').prop('checked'));
    })
});