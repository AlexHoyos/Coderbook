var api_token = window.sessionStorage.getItem('api_token')
var user_id = window.sessionStorage.getItem('user_id')
var actualUserId = null

$(document).ready(function(){

    // GET FRIENDS CHAT
    $.ajax({
        method: 'GET',
        url: 'http://localhost:8000/user/messages/',
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(chats){
        console.log(chats)
        var friendListNode = document.getElementById('friendsList');
        var friendChatModelNode = document.getElementById('friendChatModel');
        chats.forEach(function(chat){
            let friendChatNode = friendChatModelNode.cloneNode(true);

            // Put the fullname in the node
            friendChatNode.getElementsByClassName('friend-fullname')[0].innerHTML = '<b>'+ chat.user_data.name + ' '+ chat.user_data.lname +'</b>'
            
            // Put the pofile picture
            friendChatNode.getElementsByClassName('pp-bubble')[0].style.backgroundImage = "url('http://localhost:8000/media/usr/"+ chat.user_data.id + '/' + chat.user_data.profile_pic.url +"')"

            // Put the message
            if(chat.last_message.sender_id == user_id){
                friendChatNode.getElementsByClassName('friend-message')[0].innerHTML = 'Tu: ' + chat.last_message.message
            } else {
                if(!chat.last_message.seen){
                    friendChatNode.getElementsByClassName('friend-message')[0].style.fontWeight = 'bold'
                    friendChatNode.getElementsByClassName('user-seen')[0].classList.remove('d-none')
                }
                friendChatNode.getElementsByClassName('friend-message')[0].innerHTML = chat.last_message.message
            }

            friendChatNode.setAttribute('onclick', 'setChatTo('+chat.user_data.id+')')
            friendChatNode.id = 'friend-'+chat.user_data.id
            friendChatNode.classList.remove('d-none')
            friendListNode.appendChild(friendChatNode)
        })

    }).fail(function(error){
        console.log(error);
    })

})

function setChatTo(uid){

    var friendChatNode = document.getElementById('friendChat')
    var chatBoxNode = document.getElementById('chatBox')
    chatBoxNode.innerHTML = ""

    var friendData = document.getElementById('friend-'+uid)
    friendChatNode.getElementsByClassName('pp-bubble')[0].style.backgroundImage = friendData.getElementsByClassName('pp-bubble')[0].style.backgroundImage
    friendChatNode.getElementsByClassName('chatbox-friendname')[0].innerHTML = friendData.getElementsByClassName('friend-fullname')[0].innerHTML

    $.ajax({

        method: 'GET',
        url: 'http://localhost:8000/user/messages/'+uid,
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }

    }).done(function(messages){
        console.log(messages)
         var messageModels = document.getElementById('messageModels')
        messages.forEach(function(message){
            // Almacenamos la direccion del mensaje (el cual es una clase de css), si viene del usuario o del amigo
            let direction = (message.sender_id == user_id) ? 'user-sender' : 'friend-sender' 
            // Clonamos el nodo correspondiente a la direccion
            let messageNode = messageModels.getElementsByClassName(direction)[0].cloneNode(true)

            // Le añadimos el mensaje
            messageNode.getElementsByClassName('message')[0].innerHTML = message.message
            chatBoxNode.appendChild(messageNode)

        })
         
        //var messageModelNode = document.getElementById()
        friendChatNode.classList.remove('d-none')
        document.getElementById('noFriendChat').classList.add('d-none')
    })

   
}