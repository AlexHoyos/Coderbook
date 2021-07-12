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

                setFriendshipStatus(profileUser.friendship, profileUser.id, true)

                /*switch(profileUser.friendship){
                    case 'myself':
                        document.getElementsByClassName('yourself_box')[0].classList.remove('d-none')
                        break;
                    case 'friends':
                        let friend_box = document.getElementsByClassName('friend_box')[0]
                        friend_box.classList.remove('d-none')
                        friend_box.getElementsByTagName('button')[0].setAttribute('onClick', 'deleteFriend('+ profileUser.id +', "setFriendshipStatus(\'unknowable\')")')
                        break;
                    case 'sent':
                        let sent_box = document.getElementsByClassName('sent_box')[0]
                        sent_box.classList.remove('d-none')
                        sent_box.getElementsByTagName('button')[0].setAttribute('onClick', 'deleteFriend('+ profileUser.id +', "setFriendshipStatus(\'unknowable\')")')
                        break;
                    case 'pending':
                        let pending_box = document.getElementsByClassName('pending_box')[0]
                        pending_box.classList.remove('d-none')
                        pending_box.getElementsByTagName('button')[0].setAttribute('onClick', 'deleteFriend('+ profileUser.id +', "setFriendshipStatus(\'unknowable\')")')
                        pending_box.getElementsByTagName('button')[1].setAttribute('onClick', 'acceptFriend('+ profileUser.id +', "setFriendshipStatus(\'friends\')")')
                        break;
                    default:
                        let no_friends_box = document.getElementsByClassName('no_friend_box')[0]
                        no_friends_box.classList.remove('d-none')
                        no_friends_box.getElementsByTagName('button')[0].setAttribute('onClick', 'sendFriendRequest('+ profileUser.id +', "setFriendshipStatus(\'sent\')")')
                }*/

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

function setFriendshipStatus(friendship, uid, hidden = false){
    var friend_box = document.getElementsByClassName('friend_box')[0]
    var sent_box = document.getElementsByClassName('sent_box')[0]
    var pending_box = document.getElementsByClassName('pending_box')[0]
    var no_friends_box = document.getElementsByClassName('no_friend_box')[0]

    switch(friendship){
        case 'myself':
            document.getElementsByClassName('yourself_box')[0].classList.remove('d-none')
            break;
        case 'friends':
            pending_box.classList.add('d-none')
            friend_box.classList.remove('d-none')
            friend_box.getElementsByTagName('button')[0].setAttribute('onClick', 'deleteFriend('+ uid +', "setFriendshipStatus(\'unknowable\', '+ uid +')")')
            break;
        case 'sent':
            no_friends_box.classList.add('d-none')
            sent_box.classList.remove('d-none')
            sent_box.getElementsByTagName('button')[0].setAttribute('onClick', 'deleteFriend('+ uid +', "setFriendshipStatus(\'unknowable\', '+ uid +')")')
            break;
        case 'pending':
            pending_box.classList.remove('d-none')
            pending_box.getElementsByTagName('button')[0].setAttribute('onClick', 'deleteFriend('+ uid +', "setFriendshipStatus(\'unknowable\', '+ uid +')")')
            pending_box.getElementsByTagName('button')[1].setAttribute('onClick', 'acceptFriend('+ uid +', "setFriendshipStatus(\'friends\', '+ uid +')")')
            break;
        default:
            friend_box.classList.add('d-none')
            sent_box.classList.add('d-none')
            pending_box.classList.add('d-none')
            no_friends_box.classList.remove('d-none')
            no_friends_box.getElementsByTagName('button')[0].setAttribute('onClick', 'sendFriendRequest('+ uid +', "setFriendshipStatus(\'sent\', '+ uid +')")')
    }

}