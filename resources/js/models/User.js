class User {

    constructor(user){
        Object.assign(this, user)
    }

    getProfilePic(){

        if(this.profile_pic === null){
            return API_URL + 'media/usr/default.png'
        } else {
            return API_URL + 'media/usr/' +  this.id + '/' + this.profile_pic.url
        }

        
    }

    getFullname(){
        return this.name + ' ' + this.lname 
    }

    getUsername(){
        return this.username
    }

    static goToProfile(uid){
        window.location.href = SERVER_URL + 'profile.php?uid='+uid
    }

}