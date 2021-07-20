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
                console.log(results)
                let users = results.users
                let pages = results.pages
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

                }
                
                if(pages.length > 0){

                    var pageModel = document.getElementById('pageModel')
                    var pagesList = document.getElementById('pagesList')
                    pagesList.classList.remove('d-none')
                    for(let key in pages){
                        let page = new Page(pages[key])
                        let pageNode = pageModel.cloneNode(true)
                        pageNode.getElementsByClassName('pp-bubble')[0].style.backgroundImage = 'url(\''+ page.getProfilePic() +'\')'
                        pageNode.getElementsByClassName('page-title')[0].innerHTML = '<b>' + page.title + '</b>'
                        pageNode.setAttribute('onClick', 'javascript:Page.goToPage('+ page.id +')')
                        pageNode.id = 'page-'+page.id
                        pageNode.classList.remove('d-none')
                        pagesList.appendChild(pageNode)
                    }

                }

                if( users.length == 0 && pages.length == 0 )
                    document.getElementById('noResults').classList.remove('d-none')
            }).fail(function(error){
                document.getElementById('noResults').classList.remove('d-none')
                console.log(error)
            })

        }

    })

})
