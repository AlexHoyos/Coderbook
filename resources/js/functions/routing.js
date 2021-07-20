function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function getPageName(){
    let pathname = window.location.pathname
    if(pathname.includes('/messages')){
        return 'messages'
    } else if(pathname.includes('/profile')){
        return 'profile'
    } else if(pathname.includes('/page')){
        return 'page'
    }
}
