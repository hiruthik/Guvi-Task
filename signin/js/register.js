$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'php/register.php',
            data: $('form').serialize(),
            success: function(response) {
                alert(response);
                if(response.includes('successful'))
                window.location.href = "login.html";
            },
            error: function(error) {
                console.log(error);
                alert('Error during registration. Please try again.');
            }
        });
    });
});
