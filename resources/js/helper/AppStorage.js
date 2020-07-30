class AppStorage {
    storeToken(token){
        localStorage.setItem('token',token);
    }
    storeName(user){
        localStorage.setItem('name',user);
    }
    storeEmail(email){
        localStorage.setItem('email',email);
    }
    storeProfile_pic(profile_pic){
        localStorage.setItem('profile_pic',profile_pic);
    }
    storePermission(permission){
        localStorage.setItem('permission',permission);
    }
    storeemailVerify(emailVerify){
        localStorage.setItem('emailVerify',emailVerify);
    }
    store(access_token,name,email,profile_pic,permission,emailVerify){
        this.storeToken(access_token);
        this.storeName(name);
        this.storeEmail(email);
        this.storeProfile_pic(profile_pic);
        this.storePermission(permission);
        this.storeemailVerify(emailVerify);
    }
    storeAdmin(access){
        localStorage.setItem('adminAccess',access);
    }
    clear(){
        localStorage.clear()
    }
    getToken(){
        localStorage.getItem('token');
    }
    getName(){
        localStorage.getItem('name');
    }
    getEmail(){
        localStorage.getItem('email');
    }
    getProfile_pic(){
        localStorage.getItem('profile_pic');
    }
    getPermission(){
        localStorage.getItem('permission');
    }


}

export default AppStorage =new AppStorage();
