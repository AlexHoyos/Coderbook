class Message {

    constructor(message){
        Object.assign(this, message)
    }

    createMessageBubble(bubbleModels){
        // Almacenamos la direccion del mensaje (el cual es una clase de css), si viene del usuario o del amigo
        let direction = (this.sender_id == user_id) ? 'user-sender' : 'friend-sender' 
        // Clonamos el nodo correspondiente a la direccion
        let messageNode = bubbleModels.getElementsByClassName(direction)[0].cloneNode(true)

        // Le añadimos el mensaje
        messageNode.getElementsByClassName('message')[0].innerHTML = this.message
        return messageNode
    }

}