var expensePaymentMethodBalance;
var expensePaymentMethodIdToChange;
var expensePaymentMethodId;
var expensePaymentMethodCounter;

function loadValidateExpensePaymentMethodModal(expensePaymentMethodIdToChange) {

    $.ajax({
        url: '../validate_remove_expense_payment_method',
        method: 'post',
        data: {
            paymentId: expensePaymentMethodIdToChange
        },
        success: function (data) {
            expensePaymentMethodBalance = JSON.parse(data);
            let i;
            $('#tableExpensePaymentMethodsValidate').empty();
            let table = '    <tr id = incomeLimitModal>\n' +
                '                            <th>Amount</th>\n' +
                '                            <th>Date</th>\n' +
                '                            <th>Comment</th>\n' +
                '                            <th>Category</th>\n' +
                '                            <th>Payment method/th>\n' +
                '                        </tr>'
            for (i in expensePaymentMethodBalance) {

                let id = expensePaymentMethodBalance[i].id;
                let amount = expensePaymentMethodBalance[i].amount;
                let categoryId = expensePaymentMethodBalance[i].expenseCategoryId;
                let category = expensePaymentMethodBalance[i].name2;
                let date = expensePaymentMethodBalance[i].date_of_expense;
                let comment = expensePaymentMethodBalance[i].expense_comment;


                let select = $("#expensePaymentMethodModalRemoveValidate option").each(function () {
                    $(this).val()
                })

                let size = select.length;

                var selectString = '<select data-target="payment" class="form-control">';

                for (let i = 0; i < size; i++) {
                    selectString += '<option name = "type" type="number"' + 'value=' + select[i].value + ' ' + '>' + select[i].text + '</option>'
                }

                selectString += '</select>' + '</td>';

                table +=
                    '<tr id =' + id.toString() + '>' +
                    '<td hidden data-target="id" >' + id.toString() + '</td>' +
                    '<td hidden data-target="expenseCategoryId" >' + categoryId.toString() + '</td>' +
                    '<td data-target="amount" width="10%">' + amount.toString() + '</td>' +
                    '<td data-target="date" width="10%">' + date.toString() + '</td>' +
                    '<td hidden data-target="expensePaymentMethodId" width="20%"></td>' +
                    '<td data-target="comment" width="10%">' + comment +
                    '<td data-target="category" width="10%">' + category +
                    '<td data-target="expensePaymentMethodName" width="10%">'
                    + selectString +
                    '</td>' +
                    '<td data-target="save" width="10%">' + '<button data-id =' + id.toString() + ' type="button" class="btn btn-right" data-role="updateChangedExpensePaymentMethod" >Save</button>' + '</td>' +
                    '</tr>';
            }
            expensePaymentMethodCounter = 0;

            $('#tableExpensePaymentMethodsValidate').append(table);
            for (let i in expensePaymentMethodBalance) {
                let id = '#' + expensePaymentMethodBalance[i].id;
                expensePaymentMethodCounter += 1;
                $(id).children('td[data-target=expensePaymentMethodName]').children('select[data-target=payment]').val(parseInt(expensePaymentMethodIdToChange));
            }
            console.log(expensePaymentMethodCounter);
        }
    }).then(function () {
            if (expensePaymentMethodCounter == 0) {

                $.ajax({
                    url: '../expense_payment_method_delete',
                    method: 'post',
                    data: {
                        id: expensePaymentMethodIdToChange
                    },
                    success: function (data) {
                        console.log(data);
                        $("#expensePaymentMethodTable").load('../expense/payment' + " #expensePaymentMethodTable*", "");
                        $('#myModalValidateRemoveExpensePaymentMethod').modal('hide');
                        $('#expensePaymentMethodContent').load('../expense/payment' + " #expensePaymentMethodContent*", "");
                    }
                })

            }
            else if (expensePaymentMethodCounter == 1) {
                $('#expensePaymentMethodModalTitle').text('Change payment method in below expense before remove');
            }
            else {
                $('#expensePaymentMethodModalTitle').text('Change payment method in below expenses before remove');
            }

            $('#myModalValidateRemoveExpensePaymentMethod').modal('show');

        }
    )
}

$(document).ready(function () {

    $(document).on('click', 'button[data-role=deleteExpensePaymentMethod]', function () {

        expensePaymentMethodIdToChange = $(this).data('id');

        loadValidateExpensePaymentMethodModal(expensePaymentMethodIdToChange);


    });
});

$(document).on('click', 'button[data-role=updateChangedExpensePaymentMethod]', function () {
    var id = $(this).data('id');
    var amount = $('#' + id).children('td[data-target=amount]').text();
    var categoryId = $('#' + id).children('td[data-target=expenseCategoryId]').text();
    var date = $('#' + id).children('td[data-target=date]').text();
    var comment = $('#' + id).children('td[data-target=comment]').text();
    expensePaymentMethodId = $('#' + id).children('td[data-target=expensePaymentMethodName]').children('select[data-target=payment]').val();

    $.ajax({
        url: '../expense_update',
        method: 'post',
        data: {
            id: id,
            amount: amount,
            categoryId: categoryId,
            paymentId: expensePaymentMethodId,
            date: date,
            comment: comment
        },
        success: function () {
            loadValidateExpensePaymentMethodModal(expensePaymentMethodIdToChange);
            $("#expensPaymentMethodTable").load('../expense/payment' + " #expensePaymentMethodTable*", "");

        }
    });
});
