class Token {
    isValid(token){
        const payload =this.payload(token);
        if(payload){
           // if (payload.iss === "http://testseu.herokuapp.com/api/auth/login"  ) {
                return true
           // }
        }
        return false;
    }
    isExpired(token){
        const payload =this.payload(token);
        if(payload){
            if (payload.exp *1000 > Date.now() ) {
                return true
            }
        }
        return false;
    }

    payload(token){
        const payload = token.split('.')[1]
        return this.decode(payload)
    }

    decode(payload){
            return JSON.parse(atob(payload))
    }
}

export default Token=new Token();
