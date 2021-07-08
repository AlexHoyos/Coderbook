var api_token = window.sessionStorage.getItem('api_token')
var user_id = window.sessionStorage.getItem('user_id')
$(document).ready(function(){

    
    if(api_token !== null && api_token != "" && user_id !== null && user_id != ""){

        $.ajax({
            method: "GET",
            url: "http://localhost:8000/users/"+user_id,
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            contentType: "application/json",
        }).done(function(ownUser){
    
            console.log(ownUser);

            // Get POSTS
            document.getElementById('way_thinking').setAttribute('placeholder', '¿Qué estas pensando, '+ownUser.name+'?');

            $.ajax({
                method: "GET",
                url: "http://localhost:8000/posts/users/"+ user_id +"/25",
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
            window.sessionStorage.removeItem('user_id')
            window.sessionStorage.removeItem('api_token')
            window.location.href='./'
        })

    } else {
        window.sessionStorage.removeItem('user_id')
        window.sessionStorage.removeItem('api_token')
        window.location.href='./'
    }

    

})

