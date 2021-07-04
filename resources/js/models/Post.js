class Post {

    constructor(post ,ownUser, sharedContent = false){
        Object.assign(this, post);
        this.ownUser = ownUser
        this.sharedContent = sharedContent
        //console.log(Object.values(this))
    }

    createNode(newPost){

        let mmediasNode = null
        let images = 0
        let postedSince = ""

        let Author = new User(this.user)
        let Client = new User(this.ownUser)
        let profilePic = Author.getProfilePic();
        images = 0
        let urlMMedia = 'http://localhost:8000/media/usr/'+Author.id+'/';

        
        newPost.classList.remove('d-none');
        newPost.id = 'post-' + this.id;

        if(this.type == 'profile_pic'){
            mmediasNode = newPost.getElementsByClassName('post-profile-img')[0];
            mmediasNode.classList.remove('d-none')
            mmediasNode.getElementsByClassName('post-img')[0].style.backgroundImage = 'url(\''+urlMMedia + this.mmedias[0].url+'\')'
        } else if(this.type == 'shared'){
            
            var sharedPost = new Post(this.shared_post, this.ownUser, true)
            let sharedPostNode = newPost.getElementsByClassName('postNodeShared')[0];
            sharedPost.createNode(sharedPostNode)
            
            

        }else if(this.mmedias.length != 0){

            images = (this.mmedias.length > 4) ? 4 : this.mmedias.length;
            mmediasNode = newPost.getElementsByClassName('post-'+images+'-img')[0];
            mmediasNode.classList.remove('d-none');
            this.mmedias.forEach(function(mmedia, i){
                mmediasNode.getElementsByClassName('post-img')[i].style.backgroundImage = 'url(\''+urlMMedia + mmedia.url+'\')'
            })
        }

        postedSince = this.getPostedSince()

        newPost.getElementsByClassName('post-time')[0].innerHTML = 'Hace '+postedSince                        
        newPost.getElementsByClassName('post-pp')[0].style.backgroundImage = 'url(\''+profilePic+'\')'
        newPost.getElementsByClassName('post-head')[0].innerHTML = this.getPostHeader(Author);
        newPost.getElementsByClassName('post-content')[0].innerHTML = this.content;

        if(this.sharedContent === false){
            let msg = '<span><li class="fas fa-thumbs-up"></li> Chilo</span>';
            if(this.user_liked){
            
                msg = react(newPost, this.user_reaction)
                newPost.getElementsByClassName('like-btn')[0].innerHTML= msg + newPost.getElementsByClassName('like-btn')[0].innerHTML
                newPost.getElementsByClassName('like-btn')[0].getElementsByTagName('span')[0].setAttribute('onClick', 'unlike('+this.id+')')
                
            } else {
                newPost.getElementsByClassName('like-btn')[0].innerHTML= msg + newPost.getElementsByClassName('like-btn')[0].innerHTML
                newPost.getElementsByClassName('like-btn')[0].getElementsByTagName('span')[0].setAttribute('onClick', 'like('+this.id+', \'like\')')
            }
    
            changeLikes(this.reactions_count, newPost, this.most_react);
            newPost.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[0].setAttribute('onClick', 'like('+this.id+', \'like\')')
            newPost.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[1].setAttribute('onClick', 'like('+this.id+', \'love\')')
            newPost.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[2].setAttribute('onClick', 'like('+this.id+', \'lol\')')
            newPost.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[3].setAttribute('onClick', 'like('+this.id+', \'wow\')')
            newPost.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[4].setAttribute('onClick', 'like('+this.id+', \'sad\')')
            newPost.getElementsByClassName('like-btn')[0].getElementsByClassName('reaction')[5].setAttribute('onClick', 'like('+this.id+', \'angry\')')
            newPost.getElementsByClassName('comment-own-pp')[0].style.backgroundImage = 'url(\''+ Client.getProfilePic() +'\')'
            newPost.getElementsByClassName('response-own-pp')[0].style.backgroundImage = 'url(\''+ Client.getProfilePic() +'\')'
            newPost.getElementsByClassName('post-create-comment')[0].setAttribute('onkeydown', 'sendComment(event, this, '+ this.id +')')
            newPost.getElementsByClassName('post-comments')[0].innerHTML = (this.comments_count==0) ? '' : this.comments_count + ((this.comments_count == 1) ? ' comentario' : ' comentarios')
            newPost.getElementsByClassName('post-comments')[0].setAttribute('onClick', 'showComments('+this.id+')')
            newPost.getElementsByClassName('comment-btn')[0].setAttribute('onClick', 'showComments('+this.id+')')
            newPost.getElementsByClassName('post-shares')[0].innerHTML = (this.shared_count==0) ? '' : this.shared_count + ((this.shared_count == 1) ? ' vez' : ' veces') + ' compartido'

            if(this.type == 'shared'){
                newPost.getElementsByClassName('post-shareNow')[0].setAttribute('onClick', 'Post.share('+sharedPost.id+')')
                newPost.getElementsByClassName('post-shareWithContent')[0].setAttribute('onClick', 'openShareContentModal('+sharedPost.id+')')
            } else {
                newPost.getElementsByClassName('post-shareNow')[0].setAttribute('onClick', 'Post.share('+this.id+')')
                newPost.getElementsByClassName('post-shareWithContent')[0].setAttribute('onClick', 'openShareContentModal('+this.id+')')
                window.sessionStorage.setItem('post-'+this.id, JSON.stringify(this))
            }

            if(this.privacy == 'private'){
                newPost.getElementsByClassName('post-privacy')[0].classList.remove('fa-globe-americas')
                newPost.getElementsByClassName('post-privacy')[0].classList.add('fa-lock')
            }
            

            newPost.getElementsByClassName('basic-actions-post')[0].classList.remove('d-none')
            newPost.getElementsByClassName('basic-post-info')[0].classList.remove('d-none')

        } else {
            newPost.id = 'shared-post-' + this.id;
        }

        return newPost

    }

    getPostedSince(){
        return getTimeStr(Math.floor(Date.now()/1000) - this.created_at)
    }

    getPostHeader(Author){
        let extraData = ''
        if(this.type == 'profile_pic'){
            extraData = ' ha cambiado su foto de perfil'
        } else if(this.type == 'wallpaper_pic'){
            extraData = ' ha cambiado su foto de portada'
        } else if(this.type == 'shared'){
            extraData = ' ha compartido una publicacion'
        }
        return'<b>'+ Author.getFullname() +'</b>'+extraData
    }

    static share(id, withContent=false){
        let content = ""
        if(withContent === true){
            content = document.getElementById('sharedPostContent').value
           
        }

        var data = new FormData()
        data.append('shared_post_id', id)
        data.append('content', content)
        data.append('privacy', 'public')
        data.append('type', 'shared')

        $.ajax({
            method: 'POST',
            enctype: 'multipart/form-data',
            url: 'http://localhost:8000/posts',
            beforeSend: function(xhr){
                xhr.setRequestHeader('api_token', api_token)
                xhr.setRequestHeader('user_id', user_id)
            },
            data: data,
            processData: false,
            contentType: false,
            cache: false,
        }).done(function(res){

            $('#postContent').modal('hide')
            alert("Compartido!")

        }).fail(function(res){
            //console.log(res)
        })

    }

}

