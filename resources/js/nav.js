var api_token = window.localStorage.getItem('api_token')
var user_id = window.localStorage.getItem('user_id')
$(document).ready(function(){



})

function openCreatePage(){

    $("#createPage").modal('show')

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