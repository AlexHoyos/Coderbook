function deleteFriend(uid, callback){

    $.ajax({
        method: 'DELETE',
        url: API_URL + 'user/friendrequest/'+uid,
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(response){

        console.log(response)

    }).fail(function(error){
        console.log(error)
    })

    eval(callback)
}

function acceptFriend(uid, callback){
    $.ajax({
        method: 'PUT',
        url: API_URL + 'user/friendrequest/'+uid,
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(response){

        console.log(response)

    }).fail(function(error){
        console.log(error)
    })

    eval(callback)
}

function sendFriendRequest(uid, callback){
    $.ajax({
        method: 'POST',
        url: API_URL + 'user/friendrequest/'+uid,
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(response){

        console.log(response)
        socket.emit('friend_req', response)

    }).fail(function(error){
        console.log(error)
    })

    eval(callback)
}