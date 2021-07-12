var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')
$(document).ready(function(){
    
    $.ajax({
        method: "GET",
        url: API_URL + "users/"+user_id,
        beforeSend: function(xhr){
            xhr.setRequestHeader('api_token', api_token)
            xhr.setRequestHeader('user_id', user_id)
        },
        contentType: "application/json",
    }).done(function(ownUser){

        var search = getParameterByName('search')
        if(search != ''){

            document.getElementById('resultsOf').innerText = search
            $.ajax({
                method: 'GET',
                url: API_URL + 'search/' + search,
                beforeSend: function(xhr){
                    xhr.setRequestHeader('api_token', api_token)
                    xhr.setRequestHeader('user_id', user_id)
                }
            }).done(function(results){
                let users = results.users
                if(users.length > 0){
                    
                    var userModel = document.getElementById('userModel')
                    var usersList = document.getElementById('usersList')
                    usersList.classList.remove('d-none')
                    for(let key in users){
                        let user = new User(users[key])
                        let userNode = userModel.cloneNode(true)
                        userNode.getElementsByClassName('pp-bubble')[0].style.backgroundImage = 'url(\''+ user.getProfilePic() +'\')'
                        userNode.getElementsByClassName('user-fullname')[0].innerHTML = '<b>' + user.getFullname() + '</b>'
                        userNode.setAttribute('onClick', 'javascript:User.goToProfile('+ user.id +')')
                        userNode.id = 'user-'+user.id
                        userNode.classList.remove('d-none')
                        usersList.appendChild(userNode)
                    }

                } else {
                    document.getElementById('noResults').classList.remove('d-none')
                }
            }).fail(function(error){
                document.getElementById('noResults').classList.remove('d-none')
            })

        }

    })

})
