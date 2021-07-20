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

            $.ajax({
                method: "GET",
                url: API_URL + "post/"+getParameterByName('id'),
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
                contentType: "application/json"
            }).done(function(response){
                console.log(response)
                var postNode = document.getElementById('postNode');
                var posts = document.getElementById('posts');
                let postObj = new Post(response, ownUser)
                let newPost = postNode.cloneNode(true);
                posts.appendChild(postObj.createNode(newPost));
            }).fail(function(xhr, textStatus, errorThrown){
                window.location.href = './home.php'
                console.log(xhr.responseJSON.error)
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

function showPostImages(id){

    let postData = window.localStorage.getItem('post-'+id)
    let post = new Post(JSON.parse(postData))
    post.showImagesComplete("showPostImages")
    $("#showPostImages").modal('show')
}

