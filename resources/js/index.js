$(document).ready(function(){

    var api_token = window.sessionStorage.getItem('api_token')
    var user_id = window.sessionStorage.getItem('user_id')
    if(api_token !== null && api_token != "" && user_id !== null && user_id != ""){

        window.location.href = './home.php'

    }

})

function login(){

    var username = document.getElementById('usern').value
    var password = document.getElementById('passw').value
   $.ajax({
        method: "POST",
        url: "http://localhost:8000/users/login/",
        data: JSON.stringify({username:username, password:password}),
        contentType: "application/json",
    }).done(function(response){

        window.sessionStorage.setItem('api_token', response.api_token);
        window.sessionStorage.setItem('user_id', response.user.id);
        window.location.href = './home.php'

    }).fail(function(error){
        alert("Oh no, " + error.responseJSON.error);
    })

}