class User {

    constructor(user){
        Object.assign(this, user)
    }

    getProfilePic(){

        if(this.profile_pic === undefined){
            this.profile_pic.url = 'default.png'
        }

        return API_URL + 'media/usr/' +  this.id + '/' + this.profile_pic.url
    }

    getFullname(){
        return this.name + ' ' + this.lname 
    }

    getUsername(){
        return this.username
    }

}