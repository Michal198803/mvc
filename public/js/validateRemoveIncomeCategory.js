var incomeCategoryBalance;
var incomeCategoryIdToChange;
var incomeCategoryId;
var incomeCategoryCounter;

function loadValidateIncomeCategoryModal(incomeCategoryIdToChange) {

    $.ajax({
        url: '../validate_remove_income_category',
        method: 'post',
        data: {
            categoryId: incomeCategoryIdToChange
        },
        success: function (data) {
            incomeCategoryBalance = JSON.parse(data);
            let i;
            $('#tableCategoryIncomesValidate').empty();
            let table = '    <tr id = incomeLimitModal>\n' +
                '                            <th>Amount</th>\n' +
                '                            <th>Date</th>\n' +
                '                            <th>Comment</th>\n' +
                '                            <th>Category</th>\n' +
                '                        </tr>'
            for (i in incomeCategoryBalance) {

                let id = incomeCategoryBalance[i].id;
                let amount = incomeCategoryBalance[i].amount;
                let date = incomeCategoryBalance[i].date_of_income;
                let comment = incomeCategoryBalance[i].income_comment;


                let select = $("#incomeCategoryModalRemoveValidate option").each(function () {
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
                    '<td data-target="date" width="10%">' + date.toString() + '</td>' +
                    '<td hidden data-target="incomeCategoryId" width="20%"></td>' +
                    '<td data-target="comment" width="10%">' + comment +
                    '<td data-target="incomeCategoryName" width="10%">'
                    + selectString +
                    '</td>' +
                    '<td data-target="save" width="10%">' + '<button data-id =' + id.toString() + ' type="button" class="btn btn-right" data-role="updateChangedIncomeCategory" >Save</button>' + '</td>' +
                    '</tr>';
            }
            incomeCategoryCounter = 0;

            $('#tableCategoryIncomesValidate').append(table);
            for (let i in incomeCategoryBalance) {
                let id = '#' + incomeCategoryBalance[i].id;
                incomeCategoryCounter += 1;
                $(id).children('td[data-target=incomeCategoryName]').children('select[data-target=category]').val(parseInt(incomeCategoryIdToChange));
            }
            console.log(incomeCategoryCounter);
        }
    }).then(function () {
            if (incomeCategoryCounter == 0) {

                $.ajax({
                    url: '../income_category_delete',
                    method: 'post',
                    data: {
                        id: incomeCategoryIdToChange
                    },
                    success: function (data) {
                        console.log(data);
                        $("#incomeCategoryTable").load('../income/category' + " #incomeCategoryTable*", "");
                        $('#myModalValidateRemoveIncomeCategory').modal('hide');
                        $('#incomeCategoryContent').load('../income/category' + " #incomeCategoryContent*", "");
                    }
                })

            }
            else if (incomeCategoryCounter == 1) {
                $('#incomeCategoryModalTitle').text('Change category in below income before remove');
            }
            else {
                $('#incomeCategoryModalTitle').text('Change category in below incomes before remove');
            }

            $('#myModalValidateRemoveIncomeCategory').modal('show');

        }
    )
}

$(document).ready(function () {

    $(document).on('click', 'button[data-role=deleteIncomeCategory]', function () {

        incomeCategoryIdToChange = $(this).data('id');

        loadValidateIncomeCategoryModal(incomeCategoryIdToChange);


    });
});

$(document).on('click', 'button[data-role=updateChangedIncomeCategory]', function () {
    var id = $(this).data('id');
    var amount = $('#' + id).children('td[data-target=amount]').text();
    var paymentId = $('#' + id).children('td[data-target=paymentId]').text();
    var date = $('#' + id).children('td[data-target=date]').text();
    var comment = $('#' + id).children('td[data-target=comment]').text();
    incomeCategoryId = $('#' + id).children('td[data-target=incomeCategoryName]').children('select[data-target=category]').val();

    $.ajax({
        url: '../income_update',
        method: 'post',
        data: {
            id: id,
            amount: amount,
            paymentId: paymentId,
            categoryId: incomeCategoryId,
            date: date,
            comment: comment
        },
        success: function () {
            loadValidateIncomeCategoryModal(incomeCategoryIdToChange);
            $("#incomeCategoryTable").load('../income/category' + " #incomeCategoryTable*", "");

        }
    });
});
