var expenseCategoryBalance;
var expenseCategoryIdToChange;
var expenseCategoryId;
var expenseCategoryCounter;

function loadValidateCategoModal(expenseCategoryIdToChange) {

    $.ajax({
        url: '../validate_remove_expense_category',
        method: 'post',
        data: {
            categoryId: expenseCategoryIdToChange
        },
        success: function (data) {
            expenseCategoryBalance = JSON.parse(data);
            let i;
            $('#tableCategoryExpensesValidate').empty();
            let table = '    <tr id = expenseLimitModal>\n' +
                '                            <th>Amount</th>\n' +
                '                            <th>Payment method</th>\n' +
                '                            <th>Date</th>\n' +
                '                            <th>Comment</th>\n' +
                '                            <th>Category</th>\n' +
                '                        </tr>'
            for (i in expenseCategoryBalance) {

                let id = expenseCategoryBalance[i].id;
                let paymentId = expenseCategoryBalance[i].paymentId;
                let amount = expenseCategoryBalance[i].amount;
                let payment = expenseCategoryBalance[i].name;
                let date = expenseCategoryBalance[i].date_of_expense;
                let comment = expenseCategoryBalance[i].expense_comment;


                let select = $("#expenseCategoryModalRemoveValidate option").each(function () {
                    $(this).val()
                })

                let size = select.length;

                var selectString = '<select data-target="category" class="form-control">';

                for (let i = 0; i < size; i++) {
                    selectString += '<option name = "type" type="number"' + 'value=' + select[i].value + ' ' + '>' + select[i].text + '</option>'
                }

                selectString += '</select>' + '</td>';

                table +=
                    '<tr id =' + id.toString() + '>' +
                    '<td hidden data-target="id" >' + id.toString() + '</td>' +
                    '<td data-target="amount" width="10%">' + amount.toString() + '</td>' +
                    '<td data-target="paymentId" width="15%">' + payment.toString() + '</td>' +
                    '<td data-target="date" width="10%">' + date.toString() + '</td>' +
                    '<td hidden data-target="expensePaymentMethodId" width="20%"></td>' +
                    '<td data-target="comment" width="10%">' + comment +
                    '<td data-target="expenseCategoryName" width="10%">'
                    + selectString +
                    '</td>' +
                    '<td data-target="save" width="10%">' + '<button data-id =' + id.toString() + ' type="button" class="btn btn-right" data-role="updateChangedExpenseCategory" >Save</button>' + '</td>' +
                    '</tr>';
            }
            expenseCategoryCounter = 0;

            $('#tableCategoryExpensesValidate').append(table);
            for (let i in expenseCategoryBalance) {
                let id = '#' + expenseCategoryBalance[i].id;
                expenseCategoryCounter += 1;
                $(id).children('td[data-target=expenseCategoryName]').children('select[data-target=category]').val(parseInt(expenseCategoryIdToChange));
            }
            console.log(expenseCategoryCounter);
        }
    }).then(function () {
            if (expenseCategoryCounter == 0) {

                $.ajax({
                    url: '../expense_category_delete',
                    method: 'post',
                    data: {
                        id: expenseCategoryIdToChange
                    },
                    success: function (data) {
                        console.log(data);
                        $("#expenseCategoryTable").load('../expense/category' + " #expenseCategoryTable*", "");
                        $('#myModalValidateRemoveExpenseCategory').modal('hide');
                        $('#expenseCategoryContent').load('../expense/category' + " #expenseCategoryContent*", "");
                    }
                })

            }
            else if (expenseCategoryCounter == 1) {
                $('#expenseCategoryModalTitle').text('Change category in below expense before remove');
            }
            else {
                $('#expenseCategoryModalTitle').text('Change category in below expenses before remove');
            }

            $('#myModalValidateRemoveExpenseCategory').modal('show');

        }
    )
}

$(document).ready(function () {

    $(document).on('click', 'button[data-role=deleteExpenseCategory]', function () {

        expenseCategoryIdToChange = $(this).data('id');

        loadValidateCategoModal(expenseCategoryIdToChange);


    });
});

$(document).on('click', 'button[data-role=updateChangedExpenseCategory]', function () {
    var id = $(this).data('id');
    var amount = $('#' + id).children('td[data-target=amount]').text();
    var paymentId = $('#' + id).children('td[data-target=paymentId]').text();
    var date = $('#' + id).children('td[data-target=date]').text();
    var comment = $('#' + id).children('td[data-target=comment]').text();
    expenseCategoryId = $('#' + id).children('td[data-target=expenseCategoryName]').children('select[data-target=category]').val();


    $.ajax({
        url: '../expense_update',
        method: 'post',
        data: {
            id: id,
            amount: amount,
            paymentId: paymentId,
            categoryId: expenseCategoryId,
            date: date,
            comment: comment
        },
        success: function () {
            loadValidateCategoModal(expenseCategoryIdToChange);
            $("#expenseCategoryTable").load('../expense/category' + " #expenseCategoryTable*", "");

        }
    });
});

