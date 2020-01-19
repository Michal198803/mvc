$(document).ready(function () {
    $(document).on('click', 'button[data-role=addExpensePaymentMethod]', function () {
        $('#myModalExpensePaymentMethod').modal('show');
        $('#savePaymentMethod').unbind().click(function () {
            var name = $('#paymentMethodName').val();
            console.log('create');
            $.ajax({
                url: '../expense_payment_add',
                method: 'post',
                data: {
                    name: name
                },
                success: function () {
                    $("#expensePaymentMethodTable").load('../expense/payment' + " #expensePaymentMethodTable*", "");

                    $('#myModalExpensePaymentMethod').modal('hide');
                }
            })
        });
    });
});

$(document).ready(function () {

    $(document).on('click', 'button[data-role=updateExpensePaymentMethod]', function () {
        var id = $(this).data('id');
        var name = $('#' + id).children('td[data-target=expensePaymentMethodName]').text();

        $('#paymentMethodName').val(name);

        $('#rowId').val(id);
        $('#myModalExpensePaymentMethod').modal('show');
        $('#savePaymentMethod').unbind().click(function () {

            var id = $('#rowId').val();
            var name = $('#paymentMethodName').val();
            console.log('update');
            $.ajax({
                url: '../expense_payment_update',
                method: 'post',
                data: {
                    id: id,
                    name: name
                },
                success: function () {
                    $("#expensePaymentMethodTable").load('../expense/payment' + " #expensePaymentMethodTable*", "");

                    $('#myModalExpensePaymentMethod').modal('hide');

                }
            })
        });
    });
});

$(document).ready(function () {
    $('#paymentMethodName').blur(function () {

        var name = $(this).val();

        $.ajax({
            url: '../expense_payment_check',
            method: 'post',
            data: {name: name},
            success: function (data) {
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">Payment method name not available</span>');
                    $('#savePaymentMethod').attr("disabled", true);
                }
                else {
                    $('#availability').html('<span class="text-success">payment method name available</span>');
                    $('#savePaymentMethod').attr("disabled", false);
                }
            }
        });
    });
});