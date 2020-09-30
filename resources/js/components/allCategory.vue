<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>
        <v-row>
            <v-col
                md="3"
                cols="12"
                class="fill-height"
                align="center"
                v-for="item in category"
                :key="item.id"
            >
                <v-hover
                    v-slot:default="{ hover }"
                    close-delay="200"
                >
                    <v-card
                        :elevation="hover ? 16 : 2"
                        flat
                        class="pt-3"

                    >
                        <v-card-text>
                            <v-btn
                                text
                                small
                                :to="'/all/job/'+item.id"
                            >
                                {{item.name}}
                            </v-btn>
                            <p class="subtitle-1"> <v-chip >{{item.total_job}}</v-chip> Available position</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <pagination
                    :data="categories"
                    align="center"
                    @pagination-change-page="fetchCategory"></pagination>
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
name: "allCategory",
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
        this.userData();
        this.fetchCategory();
    },
    data(){
        return {
            user:{},
            category:{},
            categories:{},
        }
    },
    methods:{
        fetchCategory(page = 1){
            axios.get('/api/category/all?page=' + page)
                .then(res=>{
                    this.categories=res.data.category;
                    this.category=res.data.category.data;
                })
        },
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
    },
    components:{
        topNavBar,
        bottomFooter,
    }
}
</script>

<style scoped>

</style>
