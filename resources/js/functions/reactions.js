function getReactIcon(reaction){
    var msg = '<li class="fas fa-thumbs-up" style="color:rgb(100,160,240);"></li> '

    if(reaction == 'love'){
        color = "rgb(242, 82, 104)"
        msg = '<li class="fas fa-heart liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'lol'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-laugh-squint liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'wow'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-surprise liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'sad'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-sad-tear liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'angry'){
        color = "rgb(247, 113, 75)"
        msg = '<li class="fas fa-angry liked" style="color:'+color+';"></li> '
    }

    return msg

}

function like(post_id, reaction){

    var post = document.getElementById('post-'+post_id)
    var likebtn = post.getElementsByClassName('like-btn')[0];

    var method = "POST"
    let noti = true
    if(likebtn.getElementsByClassName('fas')[0].classList.contains('liked')){
        method = "PUT";
        noti = false
    }

    $.ajax({
        method: method,
        url: API_URL + 'reactions',
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
        url: API_URL + 'reactions',
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
        if(getPageName()=='page'){
            postNode = new Post(JSON.parse(post), null, true, true)
        } else {
            postNode = new Post(JSON.parse(post), null, true)
        }
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


