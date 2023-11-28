$(document).ready(function() {
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
var username=getUrlParameter('username');
console.log(username)
$("#welcome").text("Welcome !!"+username);
    $.ajax({
            type: 'POST',
            url: 'php/profile.php',
            data: $('form').serialize(),
            success: function(response) {
                if (response.includes('Wrong username or password')) {    
                    alert("not saved");
                } else {
                    alert("saved");
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error during login. Please try again.');
            }
        });
});
