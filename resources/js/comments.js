var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')

var last_press_key = '';

function sendComment(event, commentBox, postid){
    if(event.key=='Enter' && last_press_key != 'Shift'){
        
        data = new FormData();
        data.append('comment', commentBox.value)
        commentBox.value = ""
        $.ajax({
            
            method: 'POST',
            enctype: 'multipart/form-data',
            url:API_URL + 'posts/comments/'+postid,
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            data: data,
            processData: false,
            contentType: false,
            cache: false,

        }).done(function(res){
            console.log(res);
            socket.emit('comment', res)
            
            refreshComments(postid)
        }).fail(function(error){
            console.log(error);
        })
    }
    last_press_key = event.key
}

function sendResponse(event, commentBox, commentid){
    if(event.key=='Enter' && last_press_key != 'Shift'){

        data = new FormData();
        data.append('comment', commentBox.value)

        $.ajax({
            
            method: 'POST',
            enctype: 'multipart/form-data',
            url:API_URL + 'comments/responses/'+commentid,
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            data: data,
            processData: false,
            contentType: false,
            cache: false,

        }).done(function(res){
            console.log(res);
            commentBox.value = ""
            refreshResponses(commentid)
        }).fail(function(error){
            console.log(error);
        })
    }
    last_press_key = event.key
}

function refreshComments(postid){
    var postNode = document.getElementById('post-'+postid);
    var commentsNode = postNode.getElementsByClassName('post-comments-2')[0]
    commentsNode.classList.add('d-none')
    commentNode = postNode.getElementsByClassName('post-comment-model')[0]
    commentsNode.innerHTML = ''
    commentsNode.appendChild(commentNode)
    showComments(postid)
}
function refreshResponses(commentid){
    var commentNode = document.getElementsByClassName('comment-'+commentid)[0];
    var responsesNode = commentNode.getElementsByClassName('comment-responses')[0] 
    responsesNode.classList.add('d-none')
    responseNode = postNode.getElementsByClassName('response-comment-model')[0]
    responsesNode.innerHTML = ''
    responsesNode.appendChild(responseNode)
    showResponses(commentid)
}

function showResponses(commentid, toggle=false){
    var commentNode = document.getElementsByClassName('comment-'+commentid)[0]
    var createResNode = commentNode.getElementsByClassName('comment-create-response')[0]
    var responsesNode = commentNode.getElementsByClassName('comment-responses')[0]
    if(toggle === false){

        $.ajax({
            
            method: 'GET',
            url: API_URL + 'comments/responses/'+commentid,
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },

        }).done(function(responses){
            
            commentNode.getElementsByClassName('comment-response-btn')[0].setAttribute('onClick', 'showResponses('+commentid+', true)')
            commentNode.getElementsByClassName('comment-responses-count')[0].setAttribute('onClick', 'showResponses('+commentid+', true)')

            if(responses.length > 0){
                if(commentNode.getElementsByClassName('comment-responses-count')[0].classList.contains('d-none'))
                    commentNode.getElementsByClassName('comment-responses-count')[0].classList.remove('d-none')
                commentNode.getElementsByClassName('comment-responses-count')[0].innerHTML = responses.length + ((responses.length == 1) ? ' respuesta' : ' respuestas')
                var responseModel = responsesNode.getElementsByClassName('response-comment-model')[0]
                var actualResponseNode = null
                var time = 0
                var today = Math.floor(Date.now()/1000)
                
                responses.forEach(function(response){
                    let user = new User(response.user)
                    actualResponseNode = responseModel.cloneNode(true)
                    actualResponseNode.classList.add('comment-'+response.id)
                    actualResponseNode.getElementsByClassName('response-own-pp')[0].style.backgroundImage =  'url(\''+user.getProfilePic()+'\')'
                    actualResponseNode.getElementsByClassName('response-profile-link')[0].innerHTML = '<b>' + response.user.name + ' ' + response.user.lname + '</b>'
                    actualResponseNode.getElementsByClassName('response-content')[0].innerHTML = response.comment

                    var msg = '<span>Chilo</span>';
                    if(response.user_liked){
                        
                        msg = react(actualResponseNode, response.user_reaction, false)
                        actualResponseNode.getElementsByClassName('like-btn')[0].innerHTML= msg + actualResponseNode.getElementsByClassName('like-btn')[0].innerHTML
                        actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByTagName('span')[0].setAttribute('onClick', 'unlikeComment('+response.id+')')
                        actualResponseNode.getElementsByClassName('like-btn')[0].classList.add('liked') 
                    
                    } else {
                        actualResponseNode.getElementsByClassName('like-btn')[0].innerHTML= msg + actualResponseNode.getElementsByClassName('like-btn')[0].innerHTML
                        actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByTagName('span')[0].setAttribute('onClick', 'likeComment('+response.id+', \'like\')')
                    }

                    time = today - response.created_at
                    
                    actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[0].setAttribute('onClick', 'likeComment('+response.id+', \'like\')')
                    actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[1].setAttribute('onClick', 'likeComment('+response.id+', \'love\')')
                    actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[2].setAttribute('onClick', 'likeComment('+response.id+', \'lol\')')
                    actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[3].setAttribute('onClick', 'likeComment('+response.id+', \'wow\')')
                    actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[4].setAttribute('onClick', 'likeComment('+response.id+', \'sad\')')
                    actualResponseNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[5].setAttribute('onClick', 'likeComment('+response.id+', \'angry\')')
                    actualResponseNode.getElementsByClassName('response-time')[0].innerHTML = 'Hace ' + getTimeStr(time)
                    changeLikes(response.reactions_count, actualResponseNode, response.most_react, 'comment-reactions');

                    actualResponseNode.classList.remove('d-none')
                    responsesNode.appendChild(actualResponseNode)
                })

                responsesNode.classList.remove('d-none')
                createResNode.classList.remove('d-none')
            } else {

                createResNode.classList.remove('d-none')

            }

        })
        
    } else {

        if(createResNode.classList.contains('d-none')){

            createResNode.classList.remove('d-none')
            responsesNode.classList.remove('d-none')

        } else {
            createResNode.classList.add('d-none')
            responsesNode.classList.add('d-none')
        }

    }
}

function showComments(postid, toggle = false){
    var postNode = document.getElementById('post-'+postid);
    var comentarNode = postNode.getElementsByClassName('post-comments-1')[0]
    var commentsNode = postNode.getElementsByClassName('post-comments-2')[0]
    if(toggle === false){
        $.ajax({

            method: 'GET',
            url: API_URL + 'posts/comments/'+postid,
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
    
        }).done(function(comments){
            //console.log(comments);

            comentarNode.classList.remove('d-none')
    
            if(comments.length > 0){
                postNode.getElementsByClassName('post-comments')[0].innerHTML = comments.length + ((comments.length == 1) ? ' comentario' : ' comentarios')
                
                commentsNode.classList.remove('d-none')
        
                commentNode = postNode.getElementsByClassName('post-comment-model')[0]
                
                var time = 0
                var today = Math.floor(Date.now()/1000)

                comments.forEach(function(comment){
                    console.log(comment)
                    let user = new User(comment.user)
                    actualCommentNode = commentNode.cloneNode(true)
                    actualCommentNode.classList.add('comment-'+comment.id)
                    actualCommentNode.getElementsByClassName('comment-own-pp')[0].style.backgroundImage = 'url(\''+ user.getProfilePic() +'\')'
                    //actualCommentNode.getElementsByClassName('response-own-pp')[0].style.backgroundImage = 'url(\''+API_URL+'media/usr/'+comment.user.id+'/'+comment.user.profile_pic.url+'\')'
                    actualCommentNode.getElementsByClassName('comment-profile-link')[0].innerHTML = '<b>' + comment.user.name + ' ' + comment.user.lname + '</b>'
                    actualCommentNode.getElementsByClassName('comment-content')[0].innerHTML = comment.comment
                    
                    var msg = '<span>Chilo</span>';
                    if(comment.user_liked){
                        
                        msg = react(actualCommentNode, comment.user_reaction, false)
                        actualCommentNode.getElementsByClassName('like-btn')[0].innerHTML= msg + actualCommentNode.getElementsByClassName('like-btn')[0].innerHTML
                        actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByTagName('span')[0].setAttribute('onClick', 'unlikeComment('+comment.id+')')
                        actualCommentNode.getElementsByClassName('like-btn')[0].classList.add('liked') 
                    } else {
                        actualCommentNode.getElementsByClassName('like-btn')[0].innerHTML= msg + actualCommentNode.getElementsByClassName('like-btn')[0].innerHTML
                        actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByTagName('span')[0].setAttribute('onClick', 'likeComment('+comment.id+', \'like\')')
                    }

                    time = today - comment.created_at
                    
                    if(comment.responses_count > 0){
                        actualCommentNode.getElementsByClassName('comment-responses-count')[0].innerHTML = comment.responses_count + ((comment.responses_count == 1) ? ' respuesta' : ' respuestas')
                        actualCommentNode.getElementsByClassName('comment-responses-count')[0].classList.remove('d-none')
                        actualCommentNode.getElementsByClassName('comment-responses-count')[0].setAttribute('onClick', 'showResponses('+comment.id+')')
                    }
                    actualCommentNode.getElementsByClassName('comment-input-response')[0].setAttribute('onkeydown', 'sendResponse(event, this, '+comment.id+')')
                    actualCommentNode.getElementsByClassName('comment-response-btn')[0].setAttribute('onClick', 'showResponses('+comment.id+')')
                    actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[0].setAttribute('onClick', 'likeComment('+comment.id+', \'like\')')
                    actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[1].setAttribute('onClick', 'likeComment('+comment.id+', \'love\')')
                    actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[2].setAttribute('onClick', 'likeComment('+comment.id+', \'lol\')')
                    actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[3].setAttribute('onClick', 'likeComment('+comment.id+', \'wow\')')
                    actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[4].setAttribute('onClick', 'likeComment('+comment.id+', \'sad\')')
                    actualCommentNode.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[5].setAttribute('onClick', 'likeComment('+comment.id+', \'angry\')')
                    actualCommentNode.getElementsByClassName('comment-time')[0].innerHTML = 'Hace ' + getTimeStr(time)
                    changeLikes(comment.reactions_count, actualCommentNode, comment.most_react, 'comment-reactions');

                    actualCommentNode.classList.remove('d-none');
                    commentsNode.appendChild(actualCommentNode);
        
                })

                    

                }
            })

            postNode.getElementsByClassName('post-comments')[0].setAttribute('onClick', 'showComments('+postid+', true)')
            postNode.getElementsByClassName('comment-btn')[0].setAttribute('onClick', 'showComments('+postid+', true)')
        } else {

            if(comentarNode.classList.contains('d-none')){
                comentarNode.classList.remove('d-none')
                if(commentsNode.getElementsByClassName('post-comment-model').length > 1){
                    commentsNode.classList.remove('d-none')
                }
            } else {
                comentarNode.classList.add('d-none')
                commentsNode.classList.add('d-none')
            }
            
        }

}

function likeComment(comment_id, reaction){
    var commentNode = document.getElementsByClassName('comment-'+comment_id)[0];
    var likebtn = commentNode.getElementsByClassName('like-btn')[0]
    var method = "POST"
    //console.log(likebtn.getElementsByClassName('fas')[0].classList.contains('liked'));
    if(likebtn.classList.contains('liked'))
        method = "PUT";

    $.ajax({
        method: method,
        url: API_URL + 'reactions',
        data: JSON.stringify({comment_id:comment_id, reaction:reaction}),
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        contentType: 'application/json'
    }).done(function(response){
        console.log(response);
        var msg = react(null, reaction, false)
        likebtn.innerHTML = msg + document.getElementsByClassName('like-comment')[0].innerHTML
        likebtn.getElementsByTagName('span')[0].setAttribute('onClick', 'unlikeComment('+comment_id+')')
        likebtn.getElementsByClassName('reaction')[0].setAttribute('onClick', 'likeComment('+comment_id+', \'like\')')
        likebtn.getElementsByClassName('reaction')[1].setAttribute('onClick', 'likeComment('+comment_id+', \'love\')')
        likebtn.getElementsByClassName('reaction')[2].setAttribute('onClick', 'likeComment('+comment_id+', \'lol\')')
        likebtn.getElementsByClassName('reaction')[3].setAttribute('onClick', 'likeComment('+comment_id+', \'wow\')')
        likebtn.getElementsByClassName('reaction')[4].setAttribute('onClick', 'likeComment('+comment_id+', \'sad\')')
        likebtn.getElementsByClassName('reaction')[5].setAttribute('onClick', 'likeComment('+comment_id+', \'angry\')')

        if(method == "POST")
            likebtn.classList.add('liked')

        changeLikes(response.reactions_count, commentNode, response.most_react, 'comment-reactions');
        

    }).fail(function(error){
        console.log(error);
    })

}

function unlikeComment(comment_id){
    var commentNode = document.getElementsByClassName('comment-'+comment_id)[0];
    var likebtn = commentNode.getElementsByClassName('like-btn')[0]
    $.ajax({
        method: "delete",
        url: API_URL + 'reactions',
        data: JSON.stringify({comment_id:comment_id}),
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        contentType: 'application/json'
    }).done(function(response){
        console.log(response);
        var msg = '<span>Chilo</span>';
        likebtn.innerHTML = msg + document.getElementsByClassName('like-comment')[0].innerHTML
        likebtn.getElementsByTagName('span')[0].setAttribute('onClick', 'likeComment('+comment_id+')')
        likebtn.getElementsByClassName('reaction')[0].setAttribute('onClick', 'likeComment('+comment_id+', \'like\')')
        likebtn.getElementsByClassName('reaction')[1].setAttribute('onClick', 'likeComment('+comment_id+', \'love\')')
        likebtn.getElementsByClassName('reaction')[2].setAttribute('onClick', 'likeComment('+comment_id+', \'lol\')')
        likebtn.getElementsByClassName('reaction')[3].setAttribute('onClick', 'likeComment('+comment_id+', \'wow\')')
        likebtn.getElementsByClassName('reaction')[4].setAttribute('onClick', 'likeComment('+comment_id+', \'sad\')')
        likebtn.getElementsByClassName('reaction')[5].setAttribute('onClick', 'likeComment('+comment_id+', \'angry\')')
        likebtn.classList.remove('liked')
        changeLikes(response.reactions_count, commentNode, response.most_react, 'comment-reactions');
        

    }).fail(function(error){
        console.log(error);
    })

}