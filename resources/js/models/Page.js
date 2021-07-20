class Page {

    constructor(page){
        Object.assign(this, page)
    }

    getProfilePic(){
        if(this.principal_pic == null){
            return API_URL + 'media/usr/default.png'
        } else {
            return API_URL + 'media/page/' + this.id + '/'+this.principal_pic.url
        }
    }

    getFullname(){
        return this.title
    }

    /*getUsername(){
        return this.username
    }*/

    static goToPage(uid){
        window.location.href = SERVER_URL + 'page.php?page='+uid
    }

}