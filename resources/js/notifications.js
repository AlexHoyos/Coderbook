function webpageLoaded(ownUser){

    $.ajax({
        method: 'GET',
        url: API_URL + 'notifications',
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(response){
        
        console.log(response)
        let notificationsBox = document.getElementById('notifications')

        let notificationModel = notificationsBox.getElementsByClassName('noti-complete-model')[0]
        response.forEach(function(noti){
            let notificationNode = getNotificationNode(noti, notificationModel)
            notificationNode.classList.remove('d-none')
            notificationsBox.appendChild(notificationNode)
        })

    }).fail(function(error){

    })

}