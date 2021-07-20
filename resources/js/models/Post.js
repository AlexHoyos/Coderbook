class Post {

    constructor(post ,ownUser, sharedContent = false, isPage = false){
        Object.assign(this, post);
        this.ownUser = ownUser
        this.sharedContent = sharedContent
        this.isPage = isPage

        if(this.page_id != null){
            this.isPage = true;
        }

        let Author = null;
        if(this.isPage === true){
            Author = new Page(this.page)
        } else {
            Author = new User(this.user)
        }

        this.Author = Author

        let urlMMedia = ""
        if(this.isPage === true){
            urlMMedia = API_URL+'media/page/'+Author.id+'/';
        } else {
            urlMMedia = API_URL+'media/usr/'+Author.id+'/';
        }

        this.urlMMedia = urlMMedia

        //console.log(Object.values(this))
    }

    createNode(newPost){

        let mmediasNode = null
        let images = 0
        let postedSince = ""
        let Author = this.Author;
        
        let Client = new User(this.ownUser)
        let profilePic = Author.getProfilePic();
        images = 0
        let urlMMedia = this.urlMMedia

        
        newPost.classList.remove('d-none');
        newPost.id = 'post-' + this.id;

        if(this.type == 'profile_pic'){
            mmediasNode = newPost.getElementsByClassName('post-profile-img')[0];
            mmediasNode.classList.remove('d-none')
            mmediasNode.getElementsByClassName('post-img')[0].style.backgroundImage = 'url(\''+urlMMedia + this.mmedias[0].url+'\')'
            mmediasNode.getElementsByClassName('post-img')[0].style.backgroundPositionX = this.mmedias[0].pp_x + 'px'
            mmediasNode.getElementsByClassName('post-img')[0].style.backgroundPositionY = this.mmedias[0].pp_y + 'px'
            mmediasNode.getElementsByClassName('post-img')[0].style.backgroundSize = this.mmedias[0].pp_size + '%'
            mmediasNode.getElementsByClassName('post-img')[0].setAttribute('onClick', 'showPostImages('+ this.id +')')
        } else if(this.type == 'shared'){
            var sharedPost = null;
            if(this.shared_post.page_id == null){
                sharedPost = new Post(this.shared_post, this.ownUser, true)
            } else {
                sharedPost = new Post(this.shared_post, this.ownUser, true, true)
            }
            let sharedPostNode = newPost.getElementsByClassName('postNodeShared')[0];
            sharedPost.createNode(sharedPostNode)
            
            

        }else if(this.mmedias.length != 0){

            images = (this.mmedias.length > 4) ? 4 : this.mmedias.length;
            mmediasNode = newPost.getElementsByClassName('post-'+images+'-img')[0];
            mmediasNode.classList.remove('d-none');
            /*this.mmedias.forEach(function(mmedia, i){
                mmediasNode.getElementsByClassName('post-img')[i].style.backgroundImage = 'url(\''+urlMMedia + mmedia.url+'\')'
                mmediasNode.getElementsByClassName('post-img')[i].setAttribute('onClick', 'showPostImages('+ this.id +')')
            })*/

            for(let i = 0; i < images; i++){
                mmediasNode.getElementsByClassName('post-img')[i].style.backgroundImage = 'url(\''+urlMMedia + this.mmedias[i].url+'\')'
                mmediasNode.getElementsByClassName('post-img')[i].setAttribute('onClick', 'showPostImages('+ this.id +')')
            }

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
                newPost.getElementsByClassName('post-shareLink')[0].setAttribute('onClick', 'javascript:Post.copyPostUrl('+ sharedPost.id +')')
            } else {
                newPost.getElementsByClassName('post-shareNow')[0].setAttribute('onClick', 'Post.share('+this.id+')')
                newPost.getElementsByClassName('post-shareWithContent')[0].setAttribute('onClick', 'openShareContentModal('+this.id+')')
                newPost.getElementsByClassName('post-shareLink')[0].setAttribute('onClick', 'javascript:Post.copyPostUrl('+ this.id +')')
                window.localStorage.setItem('post-'+this.id, JSON.stringify(this))
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
        } else if(this.type == 'to_user'){
            let toUser = new User(this.to_user)
            extraData = ' <i class="fas fa-caret-right"></i><b> ' + toUser.getFullname() + '</b>'
        }
        return'<b>'+ Author.getFullname() +'</b>'+extraData
    }

    showImagesComplete(carouselid){

        let Author = null;
        if(this.isPage === true){
            Author = new Page(this.page)
        } else {
            Author = new User(this.user)
        }

        this.Author = Author

        let urlMMedia = ""
        if(this.isPage === true){
            urlMMedia = API_URL+'media/page/'+Author.id+'/';
        } else {
            urlMMedia = API_URL+'media/usr/'+Author.id+'/';
        }

        this.urlMMedia = urlMMedia

        let carousel = document.getElementById(carouselid)
        let carouselInner = carousel.getElementsByClassName('carousel-inner')[0]
        let carouselItem = carousel.getElementsByClassName('carousel-item')[0]

        carouselInner.innerHTML = ""
        
        if(this.mmedias.length == 1){
            if(!carousel.getElementsByClassName('carousel-control-prev')[0].classList.contains('d-none')){
                carousel.getElementsByClassName('carousel-control-prev')[0].classList.add('d-none')
                carousel.getElementsByClassName('carousel-control-next')[0].classList.add('d-none')
            }
        } else {
            if(carousel.getElementsByClassName('carousel-control-prev')[0].classList.contains('d-none')){
                carousel.getElementsByClassName('carousel-control-prev')[0].classList.remove('d-none')
                carousel.getElementsByClassName('carousel-control-next')[0].classList.remove('d-none')
            }
        }

        this.mmedias.forEach(function(mmedia, i){
             let carouselItemClone = carouselItem.cloneNode(true)
             carouselItemClone.getElementsByClassName('car-image')[0].src = urlMMedia + mmedia.url
             if(i==0){
                carouselItemClone.classList.add('active')
            }
            carouselItemClone.classList.remove('d-none')
            carouselInner.appendChild(carouselItemClone)
        })

    }

    static copyPostUrl(id) {
        var aux = document.createElement("input");
        aux.setAttribute("value", window.location.host + '/social_net1/post.php?id=' + id);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
        console.log('copied')
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
            url: API_URL+'posts',
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

