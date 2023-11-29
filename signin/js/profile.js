$(document).ready(function() {
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    var username = getUrlParameter('username');
    console.log(username);

    $("#welcome").text("Welcome !! " + username);

    $('form').submit(function(e) {
        e.preventDefault();

        var formArray = $(this).serializeArray(); 

        var details = {};
        formArray.forEach(function(item) {
            details[item.name] = item.value;
        });
        details['username'] = username;

        $.ajax({
            type: 'POST',
            url: 'php/profile.php',
            data: details,
            dataType: 'json',
            success: function(response) {
                alert(response);
                if (response.includes('successful')) {
                    window.location.href = "login.html";
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error during insertion. Please try again.'+error);
            }
        });
    });
});
