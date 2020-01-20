$(document).ready(function () {
    $(document).on('click', 'button[data-role=changeLogin]', function () {
        $('#availability').hide();
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
    $('#loginName').blur(function () {
        var name = $(this).val();

        $.ajax({
            url: '../login_availability_check',
            method: 'post',
            data: {name: name},
            success: function (data) {
                console.log(data);
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">User name not available</span>').show();
                    $('#saveLogin').attr("disabled", true);
                }
                else {
                    $('#availability').html('<span class="text-success">User name available</span>').show();
                    $('#saveLogin').attr("disabled", false);
                }
            }
        });
    });
});


