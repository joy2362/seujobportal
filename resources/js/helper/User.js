import Token from './token'
import AppStorage from "./AppStorage";


    class User {
        responseafteradminverify(){
            const access = true;
            AppStorage.storeAdmin(access);
        }


        responseafterlogin(res){
            const access_token = res.data.access_token;
            const name = res.data.name;
            const email = res.data.email;
            const profile_pic = res.data.profile_pic;
            const permission = res.data.permission;
            if (Token.isValid(access_token , name , email ,profile_pic , permission)){
                AppStorage.store(access_token,name,email,profile_pic,permission)
            }
        }

        hasToken(){
            const storeToken = localStorage.getItem('token');
            if (storeToken){
                return Token.isValid(storeToken)?true : false
            }
        }

        loggedIn(){
            return this.hasToken()
        }

        isAdmin(){
            const permission = localStorage.getItem('permission')
            if(permission == "1"){
                return true
            }else{
                return false
            }
        }

        isFaculty(){
            const permission = localStorage.getItem('permission')
            if(permission == "2"){
                return true
            }else{
                return false
            }
        }

        logout() {
            AppStorage.clear();
        }

        name(){
            if (this.loggedIn()){
                return localStorage.getItem('name')
            }
        }

        email(){
            if (this.loggedIn()){
                return localStorage.getItem('email')
            }
        }

        picture(){
            if (this.loggedIn()){
                return localStorage.getItem('profile_pic')
            }
        }

        permission(){
            if (this.loggedIn()){
                return localStorage.getItem('permission')
            }
        }

        token(){
            if (this.loggedIn()){
                localStorage.getItem('token');
            }
        }

        id(){
            if (this.loggedIn()){
                const payload = Token.payload(localStorage.getItem('token'))
                return payload.sub
            }
        }
    }

export default User = new User();
