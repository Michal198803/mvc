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
        $('#availability').hide();
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

$(document).ready(function () {
    $('#incomeCategoryName').blur(function () {

        var name = $(this).val();

        $.ajax({
            url: '../income_category_check',
            method: 'post',
            data: {name: name},
            success: function (data) {
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">Category name not available</span>').show();
                    $('#saveIncomeCategory').attr("disabled", true);
                }
                else {
                    $('#availability').html('<span class="text-success">Category name available</span>').show();
                    $('#saveIncomeCategory').attr("disabled", false);
                }
            }
        });
    });
});