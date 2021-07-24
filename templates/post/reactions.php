<div class="modal" id="postReactions" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button class="reaction_menu all total_reactions reaction_selected" onclick="showOnly()"> 342 </button>
                <button class="reaction_menu like d-none" onclick="showOnly('like')"> <li class="fas fa-thumbs-up" style="color:rgb(100,160,240);"></li> </button>
                <button class="reaction_menu love d-none" onclick="showOnly('love')"> <li class="fas fa-heart" style="color:rgb(242, 82, 104);"></li> </button>
                <button class="reaction_menu lol d-none" onclick="showOnly('lol')"> <i class="fas fa-laugh-squint" style="color:rgb(240, 186, 21);"></i> </button>
                <button class="reaction_menu wow d-none" onclick="showOnly('wow')"> <i class="fas fa-surprise" style="color:rgb(240, 186, 21);"></i> </button>
                <button class="reaction_menu sad d-none" onclick="showOnly('sad')"> <i class="fas fa-sad-tear" style="color:rgb(240, 186, 21);"></i> </button>
                <button class="reaction_menu angry d-none" onclick="showOnly('angry')"> <i class="fas fa-angry" style="color:rgb(247, 113, 75);"></i> </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:50vh">

            </div>

            <div class="w-100 row m-0 mb-2 p-0 reactorModel d-none">

                <div class="col-2 row m-0 p-0 pr-2 align-content-center justify-content-end">
                    <div class="d-inline my-auto pr-2 reactor_type"><i class="fas fa-heart text-danger reaction_type"></i></div>
                    <a href="#" class="profile-btn"> <div class="pp-bubble profile_pic"></div> </a>
                </div>
                <div class="col-8 row m-0 p-0 align-content-center reactioner_name">
                    <a href="#" class="profile-btn"> <b>Alex Hoyos</b> </a>
                </div>
            </div>

            </div>
        </div>
    </div>

<script>

function showOnly(react = 'all'){
    var reactionsModal = document.getElementById('postReactions')
    var reactorsBox = reactionsModal.getElementsByClassName('modal-body')[0]
    reactorsBox.innerHTML = ""
    var reactorModel = reactionsModal.getElementsByClassName('reactorModel')[0]
    var reactions = JSON.parse(window.localStorage.getItem('reaction_selected'))

    reactionsModal.getElementsByClassName('reaction_menu')[0].classList.remove('reaction_selected')
    reactionsModal.getElementsByClassName('reaction_menu')[1].classList.remove('reaction_selected')
    reactionsModal.getElementsByClassName('reaction_menu')[2].classList.remove('reaction_selected')
    reactionsModal.getElementsByClassName('reaction_menu')[3].classList.remove('reaction_selected')
    reactionsModal.getElementsByClassName('reaction_menu')[4].classList.remove('reaction_selected')
    reactionsModal.getElementsByClassName('reaction_menu')[5].classList.remove('reaction_selected')
    reactionsModal.getElementsByClassName('reaction_menu')[6].classList.remove('reaction_selected')

    reactionsModal.getElementsByClassName(react)[0].classList.add('reaction_selected')

    reactions.forEach(function(reaction){
        if(react == 'all' || reaction.reaction == react){
            var reactorNode = reactorModel.cloneNode(true)
            let user = new User(reaction.user)
            reactorNode.getElementsByClassName('reactor_type')[0].innerHTML = getReactIcon(reaction.reaction)
            reactorNode.getElementsByClassName('pp-bubble')[0].style.backgroundImage = 'url("'+ user.getProfilePic() + '")'
            reactorNode.getElementsByClassName('profile-btn')[1].innerHTML = '<b>'+ user.getFullname() +'</b>'
            reactorNode.getElementsByClassName('profile-btn')[1].href="./profile.php?uid="+user.id
            reactorNode.getElementsByClassName('profile-btn')[0].href="./profile.php?uid="+user.id
            reactorNode.classList.remove('d-none')
            reactorsBox.appendChild(reactorNode)
        }
    })
}

</script>