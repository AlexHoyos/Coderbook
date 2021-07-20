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
                
                    // Change wallpaper and profile picture
                    if(pageData.wallpaper_pic != null)
                        document.getElementsByClassName('wallpaper_pic')[0].style.backgroundImage = "url('" + API_URL + "media/page/"+ pageData.id +"/"+pageData.wallpaper_pic.url+"')"
                    if(pageData.principal_pic != null){
                        document.getElementsByClassName('profile_pic')[0].style.backgroundImage = "url('" + API_URL + "media/page/"+ pageData.id +"/"+pageData.principal_pic.url+"')"
                        document.getElementsByClassName('profile_pic')[0].style.backgroundPosition = 'center'
                        document.getElementsByClassName('profile_pic')[0].style.backgroundPositionX = (pageData.principal_pic.pp_x*.48) + 'px'
                        document.getElementsByClassName('profile_pic')[0].style.backgroundPositionY = (pageData.principal_pic.pp_y*.48) + 'px'
                        document.getElementsByClassName('profile_pic')[0].style.backgroundSize = pageData.principal_pic.pp_size + '%'

                    }

                if(pageData.admin === true){
                    document.getElementsByClassName('admin')[0].classList.remove('d-none')
                    document.getElementById('way_thinking').setAttribute('placeholder', 'Publicar algo en ' + pageData.title)
                } else {
                    document.getElementById('newPost').classList.add('d-none')
                    document.getElementsByClassName('no-admin')[0].classList.remove('d-none')
                }

                document.getElementsByClassName('page_description')[0].innerText = pageData.description
                document.getElementById('page_likes').innerHTML = document.getElementById('page_likes').innerHTML + pageData.likes_count + ' '+  ((pageData.likes_count == 1) ? 'persona' : 'personas')  +' les gusta esto'

                if(pageData.user_liked === true){
                    document.getElementById('likeBtn').classList.remove('btn-outline-primary')
                    document.getElementById('likeBtn').classList.add('btn-primary')
                }

   
                $.ajax({
                    method: "GET",
                    url: API_URL + "posts/page/"+ pageData.id +"/25",
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('api_token', api_token)
                        xhr.setRequestHeader('user_id', user_id)
                    },
                    contentType: "application/json"
                }).done(function(response){
                var postNode = document.getElementById('postNode');
                    var posts = document.getElementById('posts');
                    console.log(response)
                    response.forEach(function(post){
                        let postObj = new Post(post, ownUser, false, true)
                        let newPost = postNode.cloneNode(true);
                        posts.appendChild(postObj.createNode(newPost));
                    })
                }).fail(function(error){
                    console.log(error)
                })



            }).fail(function(error){
                window.location.href='./home.php'
            })

        })

    }

})

function likePage(){

    $.ajax({
        method: 'POST',
        url: API_URL + 'like/page/'+getParameterByName('page'),
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(response){
        console.log(response)
        if(response.user_liked === true){
            document.getElementById('likeBtn').classList.remove('btn-outline-primary')
            document.getElementById('likeBtn').classList.add('btn-primary')
        } else {
            document.getElementById('likeBtn').classList.add('btn-outline-primary')
            document.getElementById('likeBtn').classList.remove('btn-primary')
        }

    }).fail(function(error){
        console.log(error)
    })

}

function showPostImages(id){

    let postData = window.localStorage.getItem('post-'+id)
    let post = new Post(JSON.parse(postData))
    post.showImagesComplete("showPostImages")
    $("#showPostImages").modal('show')
}
