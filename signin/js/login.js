$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault();

        var username = $('#username').val();

        $.ajax({
            type: 'POST',
            url: 'php/authenticate.php',
            data: $('form').serialize(),
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = 'profile.html?id=' + response.id + '&username=' + encodeURIComponent(response.username);
                } else {
                    alert('Wrong username or password');
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error during login. Please try again.');
            }
        });
    });
});
