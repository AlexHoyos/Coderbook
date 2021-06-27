class User {

    constructor(user){
        Object.assign(this, user)
    }

    getProfilePic(){

        if(this.profile_pic.url === undefined){
            this.profile_pic.url = 'default.png'
        }

        return 'http://localhost:8000/media/usr/' +  this.id + '/' + this.profile_pic.url
    }

    getFullname(){
        return this.name + ' ' + this.lname 
    }

    getUsername(){
        return this.username
    }

}