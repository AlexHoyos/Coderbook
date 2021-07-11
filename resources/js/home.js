var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')
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
    
            console.log(ownUser);
            
            if(ownUser.see_notif == 'y'){
                document.getElementById('see_notif').classList.add('d-none')
            }

            if(ownUser.see_msg == 'y'){
                document.getElementById('see_msg').classList.add('d-none')
            }

            // Get POSTS
            document.getElementById('way_thinking').setAttribute('placeholder', '¿Qué estas pensando, '+ownUser.name+'?');

            $.ajax({
                method: "GET",
                url: API_URL + "posts/25",
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
                contentType: "application/json"
            }).done(function(response){
                console.log("xd")
                var postNode = document.getElementById('postNode');
                var posts = document.getElementById('posts');
                response.forEach(function(post){
                    let postObj = new Post(post, ownUser)
                    let newPost = postNode.cloneNode(true);
                    posts.appendChild(postObj.createNode(newPost));
                })
            }).fail(function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
            })

    
        }).fail(function(error){
            console.log(error);
            window.localStorage.removeItem('user_id')
            window.localStorage.removeItem('api_token')
            window.location.href='./'
        })

    } else {
        window.localStorage.removeItem('user_id')
        window.localStorage.removeItem('api_token')
        window.location.href='./'
    }

    

})

