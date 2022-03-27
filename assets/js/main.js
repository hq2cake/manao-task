$('.login-btn').click(function (e) {
    e.preventDefault();

    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val();

    $.ajax({
        url: 'vendor/signin.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            'login': login,
            'password': password
        },
        success: function (data) {
            if (data.status) {
                document.location.href = '/profile.php';
                console.log(data);
            } else {
                printData(data);
            }
        }
    })
})

$('.register-btn').click(function (e) {
    e.preventDefault();

    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val(),
        confirm_password = $('input[name="confirm_password"]').val(),
        email = $('input[name="email"]').val(),
        name = $('input[name="name"]').val();

    $.ajax({
        url: 'vendor/signup.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            'login': login,
            'password': password,
            'confirm_password': confirm_password,
            'email': email,
            'name': name
        },
        success: function (data) {
            if (data.status) {
                document.location.href = '/index.php';
                console.log(data);
            } else {
                printData(data);
            }
        }
    })
})