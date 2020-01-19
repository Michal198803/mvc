$.noConflict();
$(document).ready(function () {
    $(document).on('click', 'button[data-role=updateExpense]', function () {
        var id = $(this).data('id');
        var amount = $('#' + id).children('td[data-target=amount]').text();
        var payment = parseInt($('#' + id).children('td[data-target=paymentId]').text());
        var date = $('#' + id).children('td[data-target=date]').text();
        var category = parseInt($('#' + id).children('td[data-target=categoryId]').text());
        var comment = $('#' + id).children('td[data-target=comment]').text();

        $('#amountExpense').val(amount);
        $('#paymentExpense').val(payment);
        $('#dateExpense').val(date);
        $('#categoryExpense').val(category);
        $('#commentExpense').val(comment);
        $('#rowId').val(id);
        $('#myModalExpense').modal('toggle');


    });

    $('#saveExpense').click(function () {
        var id = $('#rowId').val();
        var amount = $('#amountExpense').val();
        var date = $('#dateExpense').val();
        var comment = $('#commentExpense').val();
        var paymentId = $("#paymentExpense").val();
        var categoryId = $("#categoryExpense").val();
        $.ajax({
            url: 'expense_update',
            method: 'post',
            data: {
                id: id,
                amount: amount,
                paymentId: paymentId,
                categoryId: categoryId,
                date: date,
                comment: comment
            },
            success: function () {
                $("#tableExpences").load('balance' + " #tableExpences>*", "");
                reloadChart();
                $('#myModalExpense').modal('hide');

            }
        })
    });
});


$(document).ready(function () {
    $(document).on('click', 'button[data-role=updateIncome]', function () {
        var id = $(this).data('id');
        var amount = $('#' + id).children('td[data-target=amountIncome]').text();
        ;
        var date = $('#' + id).children('td[data-target=dateIncome]').text();
        var category = $('#' + id).children('td[data-target=categoryIncomeId]').text();
        var comment = $('#' + id).children('td[data-target=commentIncome]').text();

        $('#amountIncome').val(amount);
        $('#incomeDate').val(date);
        $("input[name=type]").val([category]);
        $('#incomeComment').val(comment);
        $('#rowId').val(id);
        $('#myModalIncome').modal('toggle');
    });

    $('#saveIncome').click(function () {
        var id = $('#rowId').val();
        var amount = $('#amountIncome').val();
        var date = $('#incomeDate').val();
        var categoryId = $("input[name=type]:checked").val();
        var comment = $('#incomeComment').val();

        $.ajax({
            url: 'income_update',
            method: 'post',
            data: {
                id: id,
                amount: amount,
                categoryId: categoryId,
                date: date,
                comment: comment
            },
            success: function () {
                $("#tableIncomes").load('balance' + " #tableIncomes>*", "");
                $('#myModalIncome').modal('hide');
            }
        })
    });
});
$(document).ready(function () {
    $(document).on('click', 'button[data-role=deleteExpense]', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'expense_delete',
            method: 'post',
            data: {
                id: id
            },
            success: function (data) {
                $("#tableExpences").load('balance' + " #tableExpences>*", "");
                reloadChart();
            }
        })
    });
});

$(document).ready(function () {
    $(document).on('click', 'button[data-role=deleteIncome]', function () {
        var id = $(this).data('id');

        $.ajax({
            url: 'income_delete',
            method: 'post',
            data: {
                id: id
            },
            success: function (data) {

                $("#tableIncomes").load('balance' + " #tableIncomes>*", "");
            }
        })
    });
});
