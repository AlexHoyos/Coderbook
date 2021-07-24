const socket = io(SOCKET_URL, {
    auth: {
        type: 'user',
        uid: window.localStorage.getItem('user_id'),
        api_token: window.localStorage.getItem('api_token')
      }
});

socket.on('connect', () => {
    

})

socket.on('session_end', (data) => {
    document.getElementById('wsToast').getElementsByClassName('toast-body')[0].innerHTML = data.message
    window.localStorage.removeItem('user_id')
    window.localStorage.removeItem('api_token')
    setTimeout(function(){
        window.location.href="./"
    }, 5000)
})

socket.on('notification', (data) => {
    console.log(data)
    let ptrtoast = document.getElementById('ptr_Toast');
    if(data.type == 'post_react'){
        ptrtoast.getElementsByClassName('toast-body')[0].innerHTML = getReactIcon(data.reaction) + ' ' + data.body
    } else {
        ptrtoast.getElementsByClassName('toast-body')[0].innerHTML = getNotificationIcon(data.type) + ' ' + data.body
    }

    ptrtoast.setAttribute('onClick', 'window.location.href="'+ data.url +'"')
    loadNotifications()
    $('#ptr_Toast').toast('show')
})



socket.on('disconnect', () => {
    $('#wsToast').toast('show')
})


/*socket.onmessage = (data) => {
  console.log(data);
};*/

