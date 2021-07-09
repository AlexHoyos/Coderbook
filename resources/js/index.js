$(document).ready(function(){

    var api_token = window.localStorage.getItem('api_token')
    var user_id = window.localStorage.getItem('user_id')
    if(api_token !== null && api_token != "" && user_id !== null && user_id != ""){

        window.location.href = './home.php'

    }

})

function login(){

    var username = document.getElementById('usern').value
    var password = document.getElementById('passw').value
   $.ajax({
        method: "POST",
        url: API_URL + "users/login/",
        data: JSON.stringify({username:username, password:password}),
        contentType: "application/json",
    }).done(function(response){

        window.localStorage.setItem('api_token', response.api_token);
        window.localStorage.setItem('user_id', response.user.id);
        window.location.href = './home.php'

    }).fail(function(error){
        alert("Oh no, " + error.responseJSON.error);
    })

}

function register(){
    var username = document.getElementById('rusern').value
    var password = document.getElementById('rpassw').value
    var rpassword = document.getElementById('rrpassw').value
    var name = document.getElementById('rname').value
    var lname = document.getElementById('rlname').value
    var email = document.getElementById('remail').value
    if(password === rpassword){

        $.ajax({
            method: "POST",
            url: API_URL + "users/",
            data: JSON.stringify({name:name, lname:lname, username:username, password:password, email:email}),
            contentType: "application/json",
        }).done(function(response){
    
            window.localStorage.setItem('api_token', response.api_token);
            window.localStorage.setItem('user_id', response.user.id);
            window.location.href = './home.php'
    
        }).fail(function(error){
            alert("Oh no, " + error.responseJSON.error);
        })

    } else {
        alert("Las contraseñas no coinciden")
    }
}