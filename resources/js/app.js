require('./bootstrap');
$(document).ready(function () {
    $("#convertButton").click(function () {
        $('#baseError').empty();
        $('#targetError').empty();
        $('#valueError').empty();
        $.post("convert", {baseCurrency: $("#baseCurrency").val(), targetCurrency: $("#targetCurrency").val(), value: $("#value").val(), _token: $("#_token").val()})
            .done(function (data) {
                $('#result').text(data.converted);
            })
            .fail(function (data) {
                $('#baseError').text(data.responseJSON.errors.baseCurrency);
                $('#targetError').text(data.responseJSON.errors.targetCurrency);
                $('#valueError').text(data.responseJSON.errors.value);
            });
    });
});
