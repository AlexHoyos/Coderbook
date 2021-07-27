
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

            console.log(ownUser);

            webpageLoaded(ownUser)

            loadNotifications();
        
        }).fail(function(error){
            console.log(error);
            window.localStorage.removeItem('user_id')
            window.localStorage.removeItem('api_token')
            window.location.href='./'
        })

    } else {
        window.localStorage.removeItem('user_id')
        window.localStorage.removeItem('api_token')
        window.location.href='./'
    }

    })

function openCreatePage(){

    $("#createPage").modal('show')

}

function getNotificationNode(notification, model){
    let node = model.cloneNode(true)

    var icon = ""
    var author = new User(notification.sender)
    var text = ""
    var url = ""

    if(notification.type == 'reaction'){

        let reaction = notification.reaction.reaction
        icon = getNotificationIcon('reaction', notification.reaction.reaction)

        let reacted_to = (notification.reaction.post_id == null) ? 'un comentario' : 'una publicación'
        text = 'reaccionó a '+ reacted_to

        url = './post.php?id='+notification.post_id

    } else if(notification.type == 'comment'){

        icon = getNotificationIcon(notification.type)
        text = 'comentó tu publicación'
        url = './post.php?id='+notification.post_id

    } else if(notification.type == 'post_bio'){

        icon = getNotificationIcon(notification.type)
        text = 'publicó en tu perfil'
        url = './post.php?id='+notification.post_id

    } else if(notification.type == 'friend_req'){
        icon = getNotificationIcon(notification.type)
        text = 'quiere ser tu amigo'
        url = './profile.php?uid='+author.id
    } else {
        icon = getNotificationIcon(notification.type)
        text = ' tienes una notificacion'
        url = './notifications.php'
    }


    node.href = url
    node.innerHTML = icon + '<b>'+author.getFullname() + '</b> ' + text
    return node
}

function getNotificationIcon(type, reaction = null){

    if(type == 'reaction'){

        var color = ""
        if(reaction == 'love'){
            color = "rgb(242, 82, 104)"
            icon = '<li class="fas fa-heart" style="color:'+color+';"></li> '
        }else if(reaction == 'lol'){
            color = "rgb(240, 186, 21)"
            icon = '<li class="fas fa-laugh-squint" style="color:'+color+';"></li> '
        } else if(reaction == 'wow'){
            color = "rgb(240, 186, 21)"
            icon = '<li class="fas fa-surprise" style="color:'+color+';"></li> '
        }else if(reaction == 'sad'){
            color = "rgb(240, 186, 21)"
            icon = '<li class="fas fa-sad-tear" style="color:'+color+';"></li> '
        }else if(reaction == 'angry'){
            color = "rgb(247, 113, 75)"
            icon = '<li class="fas fa-angry liked" style="color:'+color+';"></li> '
        } else {
            icon = '<li class="fas fa-thumbs-up" style="color:rgb(100,160,240);"></li> '
        }

    } else if(type == 'comment'){
        icon = '<i class="fas fa-comment text-secondary"></i> '
    } else if(type == 'post_bio'){
        icon = '<i class="fas fa-user-tag text-success"></i> '
    } else if(type == 'friend_req'){
        icon = '<i class="fas fa-user-plus text-primary"></i> '
    } else {
        icon = '<i class="fa fa-bell"></i> '
    }

    return icon

}

function createNewPage(){

    var title = document.getElementById('page-title').value
    var visibility = document.getElementById('page-visibility').value
    var category = document.getElementById('page-category').value
    var description = document.getElementById('page-description').value

    $.ajax({
        method: 'POST',
        url: API_URL + 'pages',
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        data: {
            title: title,
            visibility: visibility,
            category: category,
            description: description
        }
    }).done(function(response){
        window.location.href = './pages.php?page='+response.id
        //console.log(response)
    }).fail(function(error){
        console.log(error.responseJSON.error)
    })

}

function loadNotifications(){
    $.ajax({
        method: 'GET',
        url: API_URL + 'notifications/last',
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        }
    }).done(function(response){
        
        console.log(response)
        let notificationsBox = document.getElementById('last_notifs')

        notificationsBox.innerHTML = '<a class="dropdown-item noti-model d-none" href="#"> <i class="fas fa-heart text-danger"></i> <b>Alex Hoyos</b> reaccionó a tu publicacion </a><a href="./notifications.php" class="btn btn-link float-right">Ver todas las notificaciones</a>'

        let notificationModel = notificationsBox.getElementsByClassName('noti-model')[0]
        response.forEach(function(noti){
            let notificationNode = getNotificationNode(noti, notificationModel)
            notificationNode.classList.remove('d-none')
            notificationsBox.appendChild(notificationNode)
        })

    }).fail(function(error){

    })
}