var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')

var isAdjImage = false


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
            console.log(ownUser)
        })
    }

    var profilePic = document.getElementsByClassName('profile-pic')[0]
    var profilePicSize = document.getElementById('profilePicSize')

    profilePic.addEventListener('mousedown', function (event){
        isAdjImage = true
        tempX = event.offsetX
        tempY = event.offsetY
    })

    profilePic.addEventListener('mousemove', function(event){
        
        if(isAdjImage === true){
            let actualX = profilePic.style.backgroundPositionX.substring(0, profilePic.style.backgroundPositionX-2)
            let actualY = profilePic.style.backgroundPositionY.substring(0, profilePic.style.backgroundPositionY-2)

            let diffX = event.offsetX - tempX
            let diffY = event.offsetY - tempY

            profilePic.style.backgroundPositionX = (actualX + diffX) + 'px'
            profilePic.style.backgroundPositionY = (actualY + diffY) + 'px'
        }
    })

    window.addEventListener('mouseup', function(event){
        if(isAdjImage === true){
            isAdjImage = false
        }
    })

    profilePicSize.addEventListener('change', function (event){
        profilePic.style.backgroundSize = (100+parseInt(event.target.value))+'%'
        
    })

})

function goToMenu(menuid){

    var buttons = document.getElementsByClassName('list-group-item')
    var menus = document.getElementsByClassName('menu')
    // Hide all menus
    for(let menu of menus){
        if(!menu.classList.contains('d-none'))
            menu.classList.add('d-none')
    }

    //Inactive all buttons
    for(let button of buttons){
        
        if(button.classList.contains('active'))
            button.classList.remove('active')
    }

    let menu = document.getElementById(menuid)
    let button = document.getElementById('btn-'+menuid)
    menu.classList.remove('d-none')
    button.classList.add('active')
    

}

function uploadProfileWpPic(e, type){
    // Obtenemos la imagen
    var target = e.target
    let files = target.files

    if(FileReader && files && files.length){

        var fr = new FileReader()
        fr.onload = function(){

            if(type == 'profile'){
                document.getElementsByClassName('profile-pic')[0].style.backgroundImage = 'url("'+fr.result+'")'
            }

            //console.log(fr.result)
        }
        fr.readAsDataURL(files[0])

        $("#uploadPicture").modal('show')

    } else {
        alert("Your browser dont support FileReader")
    }

}

$("#uploadPicture").on('hidden.bs.modal', function(e){
    document.getElementById('profilePic').value = ""
})

