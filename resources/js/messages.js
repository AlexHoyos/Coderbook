var api_token = window.sessionStorage.getItem('api_token')
var user_id = window.sessionStorage.getItem('user_id')
var actualUserId = null

$(document).ready(function(){

    // GET FRIENDS CHAT
    $.ajax({
        method: 'GET',
        url: API_URL + 'user/messages/',
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(chats){
        console.log(chats)
        var friendListNode = document.getElementById('friendsList');
        var friendChatModelNode = document.getElementById('friendChatModel');
        chats.forEach(function(chat){

            if(chat.last_message == null){
                chat.last_message = {message: ''}
            }
            let friendChatNode = friendChatModelNode.cloneNode(true);

            // Put the fullname in the node
            friendChatNode.getElementsByClassName('friend-fullname')[0].innerHTML = '<b>'+ chat.user_data.name + ' '+ chat.user_data.lname +'</b>'
            
            // Put the pofile picture
            friendChatNode.getElementsByClassName('pp-bubble')[0].style.backgroundImage = "url('" +API_URL + "media/usr/" + chat.user_data.id + '/' + chat.user_data.profile_pic.url +"')"

            // Put the message
            if(chat.last_message.sender_id == user_id){
                friendChatNode.getElementsByClassName('friend-message')[0].innerHTML = 'Tu: ' + chat.last_message.message
            } else {
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

    socket.on('message', (message) => {
        console.log(message)
        if(getPageName() == 'messages'){
            if(actualUserId == message.sender_id || user_id == message.sender_id){
                let chatBoxNode = document.getElementById('chatBox')
                let bubbleModels = document.getElementById('messageModels')
                let Msg = new Message(message) 
                chatBoxNode.appendChild(Msg.createMessageBubble(bubbleModels))
                chatBoxNode.scrollTop = chatBoxNode.scrollHeight - chatBoxNode.clientHeight
            }
            
            if(user_id == message.sender_id){
                let friendChatNode = document.getElementById('friend-'+message.target_id)
                friendChatNode.getElementsByClassName('friend-message')[0].innerHTML = 'Tu: ' + message.message
            } else {
                let friendChatNode = document.getElementById('friend-'+message.sender_id)
                friendChatNode.getElementsByClassName('friend-message')[0].innerHTML =  message.message
            }
            
            
        } else {
            
        }
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
        url: API_URL + 'user/messages/'+uid,
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }

    }).done(function(messages){
        console.log(messages)
         var bubbleModels = document.getElementById('messageModels')
         document.getElementById('sender-msg-btn').setAttribute('onClick', 'sendMsg('+uid+')')
        actualUserId = uid
         messages.forEach(function(message){
           
            let Msg = new Message(message) 
            chatBoxNode.appendChild(Msg.createMessageBubble(bubbleModels))

        })
         
        //var messageModelNode = document.getElementById()
        friendChatNode.classList.remove('d-none')
        document.getElementById('noFriendChat').classList.add('d-none')
    })

   
}


function sendMsg(uid){

    var senderMsg = document.getElementById('sender-msg')
    socket.emit('message', {
        sender_id: user_id,
        target_id: uid,
        message: senderMsg.value
    })

    senderMsg.value = ""

}