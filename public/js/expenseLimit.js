let date = new Date();
let year = date.getFullYear();
let month = date.getMonth() + 1;
;
var obj1 = [];
var obj2 = [];

function calculateLimit() {

    var categoryId = $("option[name=category]:checked").val();
    $.ajax({
        url: '../ToJsonExpenseLimit',
        method: 'post',
        data: {
            id: categoryId
        },
        success: function (data) {
            obj1 = JSON.parse(data);
        }
    });

    $.ajax({
        url: '../ToJsonExpenseThisMonthLimit',
        method: 'post',
        data: {
            year: year,
            month: month,
            categoryId: categoryId
        },
        success: function (data) {
            obj2 = JSON.parse(data);

        }
    }).then(function () {
        let newExpence = $('input[name=amount]').val();
        let balance = parseFloat(obj1[0].expense_limit) - (parseFloat(obj2[0].amount) + parseFloat(newExpence));
        $('#limitValue4').text(newExpence);
        $('#limitValue3').text(balance);
        $('#limitValue2').text(obj2[0].amount);
        $('#limitValue1').text(obj1[0].expense_limit);

        if (obj1[0].expense_limit != null && obj1[0].expense_limit != 0) {
            if (balance < 0) {
                $('.LimitWarningMessage').css("color", "red").show();
            }
            else {
                $('.LimitWarningMessage').css("color", "green").show();
            }
        }
        else {
            $('.LimitWarningMessage').hide();
        }
    });
}


$(document).ready(function () {
    calculateLimit();

    $('select[name=category]').change(function () {
        calculateLimit();
    });
    $('input[name=amount]').change(function () {
        calculateLimit();
    });

});
