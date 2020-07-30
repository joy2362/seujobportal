import Token from './token'
import AppStorage from "./AppStorage";


    class User {
        responseafteradminverify(){
            const access = true;
            AppStorage.storeAdmin(access);
        }
        hasadminaccess(){
            const access = localStorage.getItem('adminAccess');
            if(access){
                return true
            }else {
                return false
            }
        }

        responseafterlogin(res){
            const access_token = res.data.access_token;
            const name = res.data.name;
            const email = res.data.email;
            const profile_pic = res.data.profile_pic;
            const permission = res.data.permission;
            const emailVerify=res.data.emailVerify;
            if (Token.isValid(access_token)){
                AppStorage.store(access_token,name,email,profile_pic,permission,emailVerify)
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
        isverifiedAccount(){
            const emailVerify = localStorage.getItem('emailVerify')
            if (emailVerify === "0" || emailVerify === "false" ){
                return false;
            }else{
                return true;
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
