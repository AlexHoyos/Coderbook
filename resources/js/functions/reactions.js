function getReactIcon(reaction){
    var msg = '<li class="fas fa-thumbs-up" style="color:rgb(100,160,240);"></li> '

    if(reaction == 'love'){
        color = "rgb(242, 82, 104)"
        msg = '<li class="fas fa-heart liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'lol'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-laugh-squint liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'wow'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-surprise liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'sad'){
        color = "rgb(240, 186, 21)"
        msg = '<li class="fas fa-sad-tear liked" style="color:'+color+';"></li> '
    }
    if(reaction == 'angry'){
        color = "rgb(247, 113, 75)"
        msg = '<li class="fas fa-angry liked" style="color:'+color+';"></li> '
    }

    return msg

}
