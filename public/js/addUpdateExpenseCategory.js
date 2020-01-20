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
        $('#availability').hide();
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
    $('#expenseCategoryName').blur(function () {

        var name = $(this).val();

        $.ajax({
            url: '../expense_category_check',
            method: 'post',
            data: {name: name},
            success: function (data) {
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">Category name not available</span>').show();
                    $('#saveExpenseCategory').attr("disabled", true);
                }
                else {
                    $('#availability').html('<span class="text-success">Category name available</span>').show();
                    $('#saveExpenseCategory').attr("disabled", false);
                }
            }
        });
    });
});