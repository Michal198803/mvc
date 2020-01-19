$(document).ready(function () {
    $(document).on('click', 'button[data-role=addExpenseCategory]', function () {
        $('#expenseCategoryName').val('');
        $('#myModalExpenseCategory').modal('show');
        $('#saveExpenseCategory').unbind().click(function () {
            var name = $('#expenseCategoryName').val();
            var expenseLimit = $('#expenseLimit').val();

            $(".checkbox").change(function () {
                if (this.checked) {
                    $('#expenseLimit').show();
                }
            });
            $(".checkbox").change(function () {
                if (!this.checked) {
                    $('#expenseLimit').hide();
                }
            });

            $.ajax({
                url: '../expense_category_add',
                method: 'post',
                data: {
                    name: name,
                    expenseLimit: expenseLimit
                },
                success: function () {
                    $("#expenseCategoryTable").load('../expense/category' + " #expenseCategoryTable*", "");
                    $('#myModalExpenseCategory').modal('hide');
                }
            })
        });
    });
});
$(document).ready(function () {
    $(document).on('click', 'button[data-role=updateExpenseCategory]', function () {
        var id = $(this).data('id');
        var name = $('#' + id).children('td[data-target=expenseCategoryName]').children('p[name=expenseName]').text();
        var expenseLmit = $('#' + id).children('td[data-target=expenseCategoryName]').children('p[name=expenseLimitTable]').text();
        $('#expenseCategoryName').val(name);

        if (expenseLmit === '') {
            $('#expenseLimit').val('').hide();
            $(".checkbox").prop('checked', false);
        }

        else {
            var expenseLimitFloat = expenseLmit.substring(7, expenseLmit.length)
            $('#expenseLimit').val(expenseLimitFloat).show();
            $(".checkbox").prop('checked', true);

        }

        $('#rowId').val(id);
        $('#myModalExpenseCategory').modal('show');
        $(".checkbox").change(function () {
            if (this.checked) {
                $('#expenseLimit').show();
            }
        });
        $(".checkbox").change(function () {
            if (!this.checked) {
                $('#expenseLimit').hide();
            }
        });

        $('#saveExpenseCategory').unbind().click(function () {
            var id = $('#rowId').val();
            var name = $('#expenseCategoryName').val();
            var expenseLimit = $('#expenseLimit').val();
            console.log('update');
            $.ajax({
                url: '../expense_category_update',
                method: 'post',
                data: {
                    id: id,
                    name: name,
                    expenseLimit: expenseLimit
                },
                success: function () {
                    $('#expenseCategoryName').attr('value', '');
                    $("#expenseCategoryTable").load('../expense/category' + " #expenseCategoryTable*", "");


                    $('#myModalExpenseCategory').modal('hide');

                }
            })
        });
    });
});

$(document).ready(function () {

    $(document).on('click', 'button[data-role=addIncomeCategory]', function () {
        $('#myModalIncomeCategory').modal('show');
        $('#saveIncomeCategory').unbind().click(function () {
            var name = $('#incomeCategoryName').val();
            console.log('create');
            $.ajax({
                url: '../income_category_add',
                method: 'post',
                data: {
                    name: name
                },
                success: function () {
                    $("#incomeCategoryTable").load('../income/category' + " #incomeCategoryTable*", "");

                    $('#myModalIncomeCategory').modal('hide');
                }
            })
        });
    });
});
$(document).ready(function () {

    $(document).on('click', 'button[data-role=updateIncomeCategory]', function () {
        var id = $(this).data('id');
        var name = $('#' + id).children('td[data-target=incomeCategoryName]').text();

        $('#incomeCategoryName').val(name);

        $('#rowId').val(id);
        $('#myModalIncomeCategory').modal('show');
        $('#saveIncomeCategory').unbind().click(function () {

            var id = $('#rowId').val();
            var name = $('#incomeCategoryName').val();
            console.log('update');
            $.ajax({
                url: '../income_category_update',
                method: 'post',
                data: {
                    id: id,
                    name: name
                },
                success: function () {
                    $("#incomeCategoryTable").load('../income/category' + " #incomeCategoryTable*", "");

                    $('#myModalIncomeCategory').modal('hide');

                }
            })
        });
    });
});


//Payment Methods
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

    $(document).on('click', 'button[data-role=changeLogin]', function () {
        var id = $(this).data('id');
        var name = $('th[data-target=login]').text();

        $('#loginName').val(name);

        $('#rowId').val(id);
        $('#myModalChangeLogin').modal('show');
        $('#saveLogin').unbind().click(function () {

            var id = $('#rowId').val();
            var name = $('#loginName').val();


            $.ajax({
                url: 'user_login_change',
                method: 'post',
                data: {
                    id: id,
                    login: name
                },
                success: function () {
                    $('#myModalChangeLogin').modal('hide');
                    console.log('ok');
                    window.location.reload();
                }
            });
        });
    });
});
$(document).ready(function () {

    $(document).on('click', 'button[data-role=changePassword]', function () {
        var id = $(this).data('id');


        $('#rowId').val(id);
        $('#myModalChangePassword').modal('show');
        $('#savePassword').unbind().click(function () {

            var id = $('#rowId').val();
            var password = $('#inputPassword').val();

            $.ajax({
                url: 'user_password_change',
                method: 'post',
                data: {
                    id: id,
                    password: password
                },
                success: function () {

                    $('#myModalChangePassword').modal('hide');

                    window.location.reload();

                }
            })
        });
    });
});

$(document).ready(function () {
    $('#expenseCategoryName').blur(function () {

        var name = $(this).val();

        $.ajax({
            url: '../expense_category_check',
            method: 'post',
            data: {name: name},
            success: function (data) {
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">Category name not available</span>');
                    $('#saveExpenseCategory').attr("disabled", true);
                }
                else {
                    $('#availability').html('<span class="text-success">Category name available</span>');
                    $('#saveExpenseCategory').attr("disabled", false);
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#incomeCategoryName').blur(function () {

        var name = $(this).val();

        $.ajax({
            url: '../income_category_check',
            method: 'post',
            data: {name: name},
            success: function (data) {
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">Category name not available</span>');
                    $('#saveIncomeCategory').attr("disabled", true);
                }
                else {
                    $('#availability').html('<span class="text-success">Category name available</span>');
                    $('#saveIncomeCategory').attr("disabled", false);
                }
            }
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