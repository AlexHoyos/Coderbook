const socket = io("http://localhost:3000", {
    auth: {
        type: 'user',
        uid: window.sessionStorage.getItem('user_id'),
        api_token: window.sessionStorage.getItem('api_token')
      }
});

socket.on('connect', () => {
    

})

socket.on('session_end', (data) => {
    document.getElementById('wsToast').getElementsByClassName('toast-body')[0].innerHTML = data.message
    window.sessionStorage.removeItem('user_id')
    window.sessionStorage.removeItem('api_token')
    setTimeout(function(){
        window.location.href="./"
    }, 5000)
})

socket.on('post_react', (data) => {
    console.log(data)
    let ptrtoast = document.getElementById('ptr_Toast');
    ptrtoast.getElementsByClassName('toast-body')[0].innerHTML = getReactIcon(data.reaction) + ' ' + data.body
    $('#ptr_Toast').toast('show')
})



socket.on('disconnect', () => {
    $('#wsToast').toast('show')
})


/*socket.onmessage = (data) => {
  console.log(data);
};*/

