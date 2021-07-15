var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')

var isAdjImage = false

var photo = null;
var ppX = 0
var ppY = 0
var ppSize = 120
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
            var namei =document.getElementById('name')
            var lnamei = document.getElementById('lname')
            var userni = document.getElementById('usern')
            var emaili = document.getElementById('email')
            var bioinfoi = document.getElementById('bio_info')

            namei.value = ownUser.name
            lnamei.value = ownUser.lname
            userni.value = ownUser.username
            emaili.value = ownUser.email
            bioinfoi.value = ownUser.bio_info

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

            ppX = (actualX + diffX)
            ppY = (actualY + diffY)
            profilePic.style.backgroundPositionX = ppX + 'px'
            profilePic.style.backgroundPositionY = ppY + 'px'
        }
    })

    window.addEventListener('mouseup', function(event){
        if(isAdjImage === true){
            isAdjImage = false
        }
    })

    profilePicSize.addEventListener('change', function (event){
        ppSize = (100+parseInt(event.target.value))
        profilePic.style.backgroundSize = ppSize + '%'
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

        var profilePic = document.getElementById('profile-pic-opt')
        var wallpaperPic = document.getElementById('wallpaper-pic-opt')
        var btnConfirm = document.getElementById('btnConfirm')
        fr.onload = function(){

            if(type == 'profile'){
                if(!wallpaperPic.classList.contains('d-none'))
                    wallpaperPic.classList.add('d-none')

                profilePic.classList.remove('d-none')
                document.getElementsByClassName('profile-pic')[0].style.backgroundImage = 'url("'+fr.result+'")'
                btnConfirm.setAttribute('onclick', 'postImage("profilePic")')
            } else {
                if(!profilePic.classList.contains('d-none'))
                    profilePic.classList.add('d-none')

                wallpaperPic.classList.remove('d-none')
                document.getElementsByClassName('wallpaper-pic')[0].style.backgroundImage = 'url("'+fr.result+'")'
                btnConfirm.setAttribute('onclick', 'postImage("wallpaperPic")')
            }
            photo = files[0]
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

function updateProfile(){
    var name =document.getElementById('name').value
    var lname = document.getElementById('lname').value
    var usern = document.getElementById('usern').value
    var email = document.getElementById('email').value
    var bioinfo = document.getElementById('bio_info').value
    $.ajax({
        method:'PATCH',
        url: API_URL + 'users',
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        data: {
            name: name,
            lname: lname,
            username: usern,
            email: email,
            bio_info: bioinfo
        }
    }).done(function(response){
        alert("Datos actualizados con exito")
    }).fail(function(error){
        alert(error.responseJSON.error)
    })
}

function updatePassword(){
    var oldpassw =document.getElementById('oldpassw').value
    var passw = document.getElementById('passw').value
    var rpassw = document.getElementById('rpassw').value

    if(passw != rpassw){
        alert("Las contraseñas no coinciden")
    } else {
        $.ajax({
            method:'PATCH',
            url: API_URL + 'users',
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            data: {
                old_password: oldpassw,
                passw: passw,
            }
        }).done(function(response){
            alert("Contraseña actualizada con exito")
            window.location.href= './config.php'
        }).fail(function(error){
            alert(error.responseJSON.error)
        })
    }

    
}

function postImage(type){

    if(photo != null){

        var profilePic = document.getElementsByClassName('profile-pic')[0]
        var profilePicSize = document.getElementById('profilePicSize')

        if(type == 'profilePic'){
            console.log(ppX)
            postData = new FormData()
            postData.append('content', document.getElementById('postContent').value)
            postData.append('privacy', 'public')
            postData.append('type', 'profile_pic')
            postData.append('mmedias', photo)
            postData.append('pp_x', ppX)
            postData.append('pp_y', ppY)
            postData.append('pp_size', ppSize)
            $.ajax({
                method: 'POST',
                url: API_URL + 'posts',
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
                data: postData,
                processData: false,
                contentType: false,
                cache: false,
            }).done(function(response){
                alert("Foto cambiada!")
                window.location.href= './config.php'
            }).fail(function(error){
                console.log(error)
            })
    
        } else {
            console.log(ppX)
            postData = new FormData()
            postData.append('content', document.getElementById('postContent').value)
            postData.append('privacy', 'public')
            postData.append('type', 'wallpaper_pic')
            postData.append('mmedias', photo)
            $.ajax({
                method: 'POST',
                url: API_URL + 'posts',
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                },
                data: postData,
                processData: false,
                contentType: false,
                cache: false,
            }).done(function(response){
                console.log(response)
            }).fail(function(error){
                console.log(error)
            })
        }

    }

}

