var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')
var selfProfile = false
$(document).ready(function(){

    
    if(api_token !== null && api_token != "" && user_id !== null && user_id != ""){

        $.ajax({
            method: "GET",
            url: API_URL + "users/"+user_id,
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            contentType: "application/json",
        }).done(function(ownUser){

            // Get Page data
            $.ajax({
                method: "GET",
                url: API_URL + "pages/"+getParameterByName('page'),
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
                contentType: "application/json",
            }).done(function(pageData){
                console.log(pageData)
                document.getElementById('page_title').innerText = pageData.title
                document.getElementById('page_category').innerText = pageData.category

                if(pageData.admin === true){
                    document.getElementsByClassName('admin')[0].classList.remove('d-none')
                    document.getElementById('way_thinking').setAttribute('placeholder', 'Publicar algo en ' + pageData.title)
                } else {
                    document.getElementById('newPost').classList.add('d-none')
                    document.getElementsByClassName('no-admin')[0].classList.remove('d-none')
                }

                document.getElementsByClassName('page_description')[0].innerText = pageData.description

            }).fail(function(error){
                window.location.href='./home.php'
            })

        })

    }

})