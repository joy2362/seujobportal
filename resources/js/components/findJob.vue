<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>
            <v-row v-if="count<=0" align="center"
                   justify="center">
                <v-row v-if="count<=0" align="center"
                       justify="center">
                    <v-card
                        outlined
                    >
                        <v-list-item >
                            <v-list-item-avatar
                                tile
                                size="140"
                            >
                                <v-img
                                    src="/asset/img/others/404/emoji.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" font-weight-black" >
                                    <h1  >Sorry</h1>
                                </v-list-item-title>
                                <v-list-item-title
                                >
                                    <p>  No related post found</p>

                                </v-list-item-title>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-row>
            </v-row>
        <v-row v-else>
            <v-col
                cols="12"
                md="6"
                v-for="row in job" :key="row.id"
            >
                <v-card
                    outlined
                >
                    <v-list-item >
                        <v-list-item-content
                        >
                            <v-toolbar flat>
                                <v-toolbar-title>
                                    <v-btn
                                        text
                                        :to="'/job/'+row.id"
                                        class="body-1"
                                    >
                                        {{row.name}}
                                    </v-btn>
                                </v-toolbar-title>
                                <v-spacer></v-spacer>
                                <div>
                                    <v-btn icon color="pink" @click="shortlist(row.id)">
                                        <v-icon>mdi-star-outline</v-icon>
                                    </v-btn>
                                </div>
                            </v-toolbar>
                            <v-banner
                                single-line
                            >
                                Company:- {{row.company}}

                            </v-banner>
                            <v-list-item-subtitle
                            >
                                <v-chip
                                    class="ma-2"
                                    v-if="row.location === '1'"
                                >
                                    <v-icon left>mdi-map-marker</v-icon>
                                    Dhaka, Bangladesh
                                </v-chip>
                                <v-chip
                                    class="ma-2"
                                    v-if="row.location === '2'"
                                >
                                    <v-icon left>mdi-map-marker</v-icon>
                                    Outside Dhaka
                                </v-chip>
                                <v-chip
                                    class="ma-2"
                                    v-if="row.JobType === '2'"
                                >
                                    <v-icon left>mdi-timetable</v-icon>
                                    Full time
                                </v-chip>
                                <v-chip
                                    class="ma-2"
                                    v-if="row.JobType === '1'"
                                >
                                    <v-icon left>mdi-timetable</v-icon>
                                    Part time
                                </v-chip>
                            </v-list-item-subtitle>

                        </v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <pagination
                    :data="jobs"
                    align="center"
                    @pagination-change-page="fatchAllData"
                >
                </pagination>
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
        this.userData();
        this.fatchAllData();
    },
    data(){
        return {
            user:{},
            count:'',
            job:{},
            jobs:{},
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
        fatchAllData(page = 1){
            let location= this.$route.params.location;
            let title= this.$route.params.title;
            const formData = new FormData();
            formData.append('location', location);
            formData.append('title', title);
            axios.post('/api/job/search?page=' + page,formData)
                .then(res=>{
                    this.count=res.data.job.total;
                    this.jobs=res.data.job;
                    this.job=res.data.job.data;
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
