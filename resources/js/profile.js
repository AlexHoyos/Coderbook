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

            // Get User Profile
            $.ajax({
                method: "GET",
                url: API_URL + "users/profile/"+getParameterByName('uid'),
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
                contentType: "application/json",
            }).done(function(profileUser){

                console.log(profileUser)
                // Change title
                document.title = profileUser.name + ' ' + profileUser.lname + ' | Coderbook'
                // Change WAY thinking textarea
                document.getElementById('way_thinking').setAttribute('placeholder', 'Publicar en la biografia de '+profileUser.name+'...')

                // Change wallpaper and profile picture
                if(profileUser.wallpaper_pic != null)
                    document.getElementsByClassName('wallpaper_pic')[0].style.backgroundImage = "url('" + API_URL + "media/usr/"+ profileUser.id +"/"+profileUser.wallpaper_pic.url+"')"
                if(profileUser.profile_pic != null)
                    document.getElementsByClassName('profile_pic')[0].style.backgroundImage = "url('" + API_URL + "media/usr/"+ profileUser.id +"/"+profileUser.profile_pic.url+"')"

                // Change fullname and bio info
                document.getElementById('profile_fullname').innerHTML = profileUser.name + ' ' + profileUser.lname
                document.getElementById('profile_info').innerHTML = (profileUser.bio_info === null) ? '' : profileUser.bio_info
                


                // Right box (add friend, config, delete friend, etc)
                if(profileUser.id == ownUser.id)
                    document.getElementsByClassName('yourself_box')[0].classList.remove('d-none')
                else 
                    document.getElementsByClassName('no_friend_box')[0].classList.remove('d-none')

                // Profile details
                let profileDetailsBox = document.getElementsByClassName('profile_details')[0]
                let profileDetailNode = profileDetailsBox.getElementsByClassName('profile_detail')[0]

                    // Coderbooker since
                let joinDNode = profileDetailNode.cloneNode(true)
                joinDNode.innerHTML = joinDNode.innerHTML + ' Se unió el ' + getTimeToDate(profileUser.created_at)
                joinDNode.getElementsByClassName('fas')[0].classList.add('fa-calendar-check')
                joinDNode.classList.remove('d-none')
                profileDetailsBox.appendChild(joinDNode)
                    // Birthday date
                if(profileUser.birth_date){
                    let birthDNode = profileDetailNode.cloneNode(true)
                    birthDNode.innerHTML = birthDNode.innerHTML + ' Nació el  ' + getTimeToDate(profileUser.birth_date)
                    birthDNode.getElementsByClassName('fas')[0].classList.add('fa-calendar-day')
                    birthDNode.classList.remove('d-none')
                    profileDetailsBox.appendChild(birthDNode)
                }

                    // Civil Status
                if(profileUser.civil_status == "relationship"){
                    if(profileUser.relation != null){
                        let relationDNode = profileDetailNode.cloneNode(true)
                        relationDNode.innerHTML = relationDNode.innerHTML + ' En una relacion con <b class="text-muted">' + profileUser.relation.name  + ' ' + profileUser.relation.lname + '</b>'
                        relationDNode.getElementsByClassName('fas')[0].classList.add('fa-heart')
                        relationDNode.classList.remove('d-none')
                        profileDetailsBox.appendChild(relationDNode)
                    }
                }

                // GET PHOTOS
                if(profileUser.recent_photos.length > 0){
                    console.log(profileUser.recent_photos)
                    profileUser.recent_photos.forEach(function(photo, i){
                        let photoNode = document.getElementsByClassName('profile-photo-'+(i+1))[0]
                        photoNode.style.backgroundImage = "url('" + API_URL + "media/usr/"+ profileUser.id +"/"+photo.url+"')"
                        photoNode.classList.remove('d-none')
                    })

                }
                // GET FRIENDS
                    //Total friends
                document.getElementById('total_friends').innerHTML = profileUser.total_friends + ' amigo' + ((profileUser.total_friends == 1) ? '' : 's')
                if(profileUser.recent_friends.length > 0){

                    profileUser.recent_friends.forEach(function(friend, i){
                        let friendNode = document.getElementsByClassName('friend-photo-'+(i+1))[0]
                        friendNode.style.backgroundImage = "url('" + API_URL + "media/usr/"+ friend.id +"/"+friend.profile_pic.url+"')"
                        friendNode.classList.remove('d-none')
                    })

                }
                
                // Get POSTS

                $.ajax({
                    method: "GET",
                    url: API_URL + "posts/users/"+ profileUser.id +"/25",
                    beforeSend: function(xhr){
                        xhr.setRequestHeader('api_token', api_token)
                        xhr.setRequestHeader('user_id', user_id)
                    },
                    contentType: "application/json"
                }).done(function(response){
                var postNode = document.getElementById('postNode');
                    var posts = document.getElementById('posts');
                    response.forEach(function(post){
                        let postObj = new Post(post, ownUser)
                        let newPost = postNode.cloneNode(true);
                        posts.appendChild(postObj.createNode(newPost));
                    })
                })

            }).fail(function(error){
                
                window.location.href = 'profile.php?uid='+user_id

            })

            


    
        }).fail(function(error){
            console.log(error);
            window.location.href='./'
        })

    } else {
        window.location.href='./'
    }

    

})
/*
function like(post_id, reaction){

    var post = document.getElementById('post-'+post_id)
    var likebtn = post.getElementsByClassName('like-btn')[0];

    var method = "POST"
    let noti = true
    //console.log(likebtn.getElementsByClassName('fas')[0].classList.contains('liked'));
    if(likebtn.getElementsByClassName('fas')[0].classList.contains('liked')){
        method = "PUT";
        noti = false
    }
        

    $.ajax({
        method: method,
        url: '" + API_URL + "reactions',
        data: JSON.stringify({post_id:post_id, reaction:reaction}),
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        contentType: 'application/json'
    }).done(function(response){
        console.log(response);
        var msg = react(post, reaction)
        likebtn.innerHTML = msg + document.getElementsByClassName('like-btn')[0].innerHTML
        likebtn.getElementsByTagName('span')[0].setAttribute('onClick', 'unlike('+post_id+')')
        likebtn.getElementsByClassName('reaction')[0].setAttribute('onClick', 'like('+post_id+', \'like\')')
        likebtn.getElementsByClassName('reaction')[1].setAttribute('onClick', 'like('+post_id+', \'love\')')
        likebtn.getElementsByClassName('reaction')[2].setAttribute('onClick', 'like('+post_id+', \'lol\')')
        likebtn.getElementsByClassName('reaction')[3].setAttribute('onClick', 'like('+post_id+', \'wow\')')
        likebtn.getElementsByClassName('reaction')[4].setAttribute('onClick', 'like('+post_id+', \'sad\')')
        likebtn.getElementsByClassName('reaction')[5].setAttribute('onClick', 'like('+post_id+', \'angry\')')
        changeLikes(response.reactions_count, post, response.most_react);
        response.reaction = reaction
        if(noti)
            socket.emit('post_react', response);
    }).fail(function(error){
        console.log(error);
    })

}

function unlike(post_id){
    var post = document.getElementById('post-'+post_id)
    var likebtn = post.getElementsByClassName('like-btn')[0];
    $.ajax({
        method: "delete",
        url: '" + API_URL + "reactions',
        data: JSON.stringify({post_id:post_id}),
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        contentType: 'application/json'
    }).done(function(response){

        var msg = '<span><li class="fas fa-thumbs-up"></li> Chilo</span>';
        likebtn.style.color = "rgb(98, 98, 98)";
        likebtn.innerHTML = msg + document.getElementsByClassName('like-btn')[0].innerHTML
        likebtn.getElementsByTagName('span')[0].setAttribute('onClick', 'like('+post_id+', \'like\')')
        likebtn.getElementsByClassName('reaction')[0].setAttribute('onClick', 'like('+post_id+', \'like\')')
        likebtn.getElementsByClassName('reaction')[1].setAttribute('onClick', 'like('+post_id+', \'love\')')
        likebtn.getElementsByClassName('reaction')[2].setAttribute('onClick', 'like('+post_id+', \'lol\')')
        likebtn.getElementsByClassName('reaction')[3].setAttribute('onClick', 'like('+post_id+', \'wow\')')
        likebtn.getElementsByClassName('reaction')[4].setAttribute('onClick', 'like('+post_id+', \'sad\')')
        likebtn.getElementsByClassName('reaction')[5].setAttribute('onClick', 'like('+post_id+', \'angry\')')
        changeLikes(response.reactions_count, post, response.most_react);

    }).fail(function(error){
        console.log(error);
    })

}

function react(node, reaction, post = true){
    var msg = 'Chilo';
    var color = "rgb(100,160,240)";
    var icon = '<li class="fas fa-thumbs-up liked"></li>'
    

    if(reaction == 'love'){
        color = "rgb(242, 82, 104)"
        msg = 'Amo'
        icon = '<li class="fas fa-heart liked"></li>'
    }
    if(reaction == 'lol'){
        color = "rgb(240, 186, 21)"
        msg = 'Jajaja'
        icon = '<li class="fas fa-laugh-squint liked"></li>'
    }
    if(reaction == 'wow'){
        color = "rgb(240, 186, 21)"
        msg = 'Wow'
        icon = '<li class="fas fa-surprise liked"></li>'
    }
    if(reaction == 'sad'){
        color = "rgb(240, 186, 21)"
        msg = 'Chale'
        icon = '<li class="fas fa-sad-tear liked"></li>'
    }
    if(reaction == 'angry'){
        color = "rgb(247, 113, 75)"
        msg = 'Angery'
        icon = '<li class="fas fa-angry liked"></li>'
    }

    
    if(post){
        node.getElementsByClassName('like-btn')[0].style.color = color
        return '<span>' + icon + ' '+ msg + '</span>';
    } else{
        return '<span style="color:'+ color +'">' + msg + '</span>';
    }
}

function changeLikes(likes, post, reaction = '?', className = 'post-likes'){
    var msg = '<li class="fas fa-thumbs-up" style="color:rgb(100,160,240);"></li> ' + likes

    if(reaction == 'love'){
        color = "rgb(242, 82, 104)"
        msg = '<li class="fas fa-heart liked" style="color:'+color+';"></li> ' + likes
    }
    if(reaction == 'lol'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-laugh-squint liked" style="color:'+color+';"></li> ' + likes
    }
    if(reaction == 'wow'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-surprise liked" style="color:'+color+';"></li> ' + likes
    }
    if(reaction == 'sad'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-sad-tear liked" style="color:'+color+';"></li> ' + likes
    }
    if(reaction == 'angry'){
        color = "rgb(247, 113, 75)"
        msg = '<li class="fas fa-angry liked" style="color:'+color+';"></li> ' + likes
    }

    if(likes == 0){
        msg = ''
    }

    if(className == 'comment-reactions' && likes <= 0){
        post.getElementsByClassName(className)[0].classList.add('d-none')
    } else {
        post.getElementsByClassName(className)[0].classList.remove('d-none')
    }


    post.getElementsByClassName(className)[0].innerHTML = msg
    

}
*/
function getTimeToDate(time){
    let date = new Date(time * 1000).toLocaleDateString("es-MX")
    return date
}

function getTimeStr(time){
    if(time < 60){
        return time + 's'
    } else {

        time = Math.floor(time/60)
        if(time < 60){
            return time + ' min'
        } else {
            time = Math.floor(time/60)
            
            if(time < 24){
                return time + ' hr'
            } else {
                time = Math.floor(time/24)
                if(time < 7){

                    return time + ' d'

                } else {
                    time = Math.floor(time/7)
                    if(time < 4){
                        return time + ' sem'
                    } else {
                        time = time * 7
                        if(time >= 365){
                            time = Math.floor(time/365.25)
                            if(time == 1){
                                return time + ' año'
                            } else {
                                return time + ' años'
                            }
                            
                        } else {
                            time = Math.floor(time/30)
                            return time + ' m'
                        }
                    }
                }
            }

        }

    }
}

function openShareContentModal(id){

    let sharedPostBody = document.getElementById("sharedPostBody")
    let postNode = document.getElementById('shared-post-'+id)
    let sharedPostClone = null
    document.getElementById('sharePostContent').setAttribute('onClick', 'Post.share('+id+', true)')
    if(postNode == null){
        let post = window.localStorage.getItem('post-'+id);
        let sharedPostNode = document.getElementsByClassName('postNodeShared')[0];
        postNode = new Post(JSON.parse(post), null, true)
        sharedPostClone = postNode.createNode(sharedPostNode).cloneNode(true)
        //postNode = document.getElementById('post-'+id)
    } else {
        sharedPostClone = postNode.cloneNode(true)
    }
        
    sharedPostBody.appendChild(sharedPostClone)
    
    $('#postContent').modal('show')
    

}
$(document).on('hide.bs.modal', '#postContent', function(e){
    let sharedPostBody = document.getElementById("sharedPostBody")
    sharedPostBody.innerHTML = "";
    console.log('yea')
})

