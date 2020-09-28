<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>
        <v-row>
            <v-col
                cols="12"
                md="6"
            >
                <v-row>
                    <v-col
                        cols="12"
                    >
                        <v-card-title  class="justify-center ">
                            <span class="font-weight-light">Job </span>
                        </v-card-title>
                        <v-divider></v-divider>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        cols="12"
                        v-for="row in job" :key="row.id"
                    >

                        <v-banner single-line >
                            <v-btn
                                text
                                small
                                :to="'/job/'+row.id"
                            >
                                {{row.name}}
                            </v-btn>
                            <template v-slot:actions>
                                <v-btn
                                    color="primary"
                                    text
                                    @click="removeJob(row.id)"
                                >
                                    <v-icon>
                                        mdi-close
                                    </v-icon>
                                </v-btn>
                            </template>
                        </v-banner>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <pagination
                            :data="jobs"
                            align="center"
                            @pagination-change-page="fetchJobList"></pagination>
                    </v-col>
                </v-row>
            </v-col>
            <v-col
                cols="12"
                md="6"
            >
                <v-row>
                    <v-col
                        cols="12"
                    >
                        <v-card-title  class="justify-center ">
                            <span class="font-weight-light">Event </span>
                        </v-card-title>
                        <v-divider></v-divider>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        cols="12"
                        v-for="row in event" :key="row.id"
                    >
                        <v-banner single-line  >
                            <v-btn
                                text
                                small
                                :to="'/event/'+row.id"
                            >
                                {{row.name}}
                            </v-btn>
                            <template v-slot:actions>
                                <v-btn
                                    color="primary"
                                    text
                                    @click="removeEvent(row.id)"
                                >
                                    <v-icon>
                                        mdi-close
                                    </v-icon>
                                </v-btn>
                            </template>
                        </v-banner>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <pagination
                            :data="events"
                            align="center"
                            @pagination-change-page="fetchEventList"></pagination>
                    </v-col>
                </v-row>
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
    name: "favList",
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
        this.fetchEventList();
        this.fetchJobList();
    },
    data(){
        return {
            user:{},
            event:{},
            events:{},
            job:{},
            jobs:{}
        }
    },
    methods:{
        fetchEventList(page = 1){
            let email=User.email();
            axios.get('/api/user/favourite/event/'+email+'?page=' + page)
                .then(res=>{
                    this.events=res.data.event;
                    this.event=res.data.event.data;
                })
        },
        fetchJobList(page = 1){
            let email=User.email();
            axios.get('/api/user/favourite/job/'+email+'?page=' + page)
                .then(res=>{
                    this.jobs=res.data.job;
                    this.job=res.data.job.data;
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
        removeJob(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                axios.get('/api/user/favourite/job/remove/'+id)
                    .then(res=>{
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.fetchJobList();
                    })
                    .catch(error=>{

                        Toast.fire({
                            icon: 'error',
                            title: 'Something wrong try again'
                        })

                    })
                }
            })
        },
        removeEvent(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios.get('/api/user/favourite/event/remove/'+id)
                        .then(res=>{
                            Swal.fire(
                                'Success!',
                                res.data.msg,
                                'success'
                            )
                            this.fetchEventList();
                        })
                        .catch(error=>{

                            Toast.fire({
                                icon: 'error',
                                title: 'Something wrong try again'
                            })

                        })
                }
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
