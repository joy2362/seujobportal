<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>
        <v-row>
            <v-col
                md="4"
                cols="12"
            >
                <h2>you got me</h2>
            </v-col>
            <v-col
                md="8"
                cols="12"
            >
                <h2>you got me too</h2>
            </v-col>
        </v-row>
    </v-container>
    <bottom-footer ></bottom-footer>
</v-app>
</template>

<script>
import User from "../helper/User";
import topNavBar from "./layouts/topNavBar";
import bottomFooter from "./layouts/bottomFooter";

export default {
name: "findJob",
    created() {
        if (! User.loggedIn()){
            this.$router.push({name:'logout'});
        }
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.isverifiedAccount()){
            this.$router.push({name:'emailverify'});
        }
        this.checkEmail();
        this.fatchcategory();
        this.userData();
        this.fatchAllData();
    },
    data(){
        return {
            category:[],
            user:{},
        }
    },
    methods:{
        userData(){
            let email=User.email();
            axios.get('/api/user/info/'+email)
                .then(res=>{
                    this.user=res.data.user;
                })
        },
        checkEmail(){
            const formData = new FormData();
            formData.append('email', User.email());
            formData.append('type', User.permission());
            axios.post('/api/auth/check/email',formData)
                .then(res =>{

                })
                .catch(error=>{
                    this.$router.push({name:'logout'});
                })
        },
        fatchcategory(){
            axios.get('/api/admin/category/index')
                .then(res =>{
                    this.category=res.data;
                })
        }
    },
    components:{
        topNavBar,
        bottomFooter,
    }
}
</script>

<style scoped>

</style>
