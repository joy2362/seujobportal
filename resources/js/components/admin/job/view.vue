<template>
    <v-app>
        <TopNav :user="user"></TopNav>
    <v-container>
    <v-card>
        <v-card-title>
            <span class="headline">Job Details</span>
        </v-card-title>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12" md="5">
                        <h4 class="body-1">Job-Title:- {{job.name}} </h4>
                    </v-col>
                    <v-col cols="12" md="3">
                        <h4 v-if=" job.JobType === '1' " class="body-1"> Job Type:- Part Time</h4>
                        <h4 v-else class="body-1"> Job Type:- Full Time</h4>
                    </v-col>
                    <v-col cols="12" md="4">
                        <h4 v-if=" job.location === '1' " class="body-1"> Location:- Inside Dhaka</h4>
                        <h4 v-else class="body-1"> Location:- Out Dhaka</h4>
                    </v-col>

                    <v-col cols="12" md="4">
                        <h4 class="body-1">Company:- {{job.company}} </h4>
                    </v-col>
                    <v-col cols="12" md="6">
                        <h4 class="body-1">Address:- {{job.address}} </h4>
                    </v-col>
                    <v-col cols="12" md="3">
                        <h4 class="body-1">Last date:- {{job.lastdate}} </h4>
                    </v-col>
                    <v-col cols="12" md="2">
                        <h4 class="body-1">Duty start:- {{job.dutyStart}} </h4>
                    </v-col>
                    <v-col cols="12" md="2">
                        <h4 class="body-1">Duty End:- {{job.dutyEnd}} </h4>
                    </v-col>
                    <v-col cols="12" md="2">
                        <h4 class="body-1">Experience:- {{job.experience}} Years </h4>
                    </v-col>
                    <v-col cols="12" md="3">
                        <h4 class="body-1">Category:- {{job.category_name}}  </h4>
                    </v-col>

                    <v-col cols="12" md="6">
                        <h4 class="body-1">Off Day:- <span v-for="i in offday" :key="i.id"> {{i.day}} </span>{{job.offday}}  </h4>
                    </v-col>
                    <v-col cols="12" md="3">
                        <h4 class="body-1">Salary:- {{job.salary}} BDT</h4>
                    </v-col>
                    <v-col cols="12" md="3">
                        <h4 class="body-1">Vacancy:- {{job.vacency}}</h4>
                    </v-col>
                    <v-col cols="12" md="6">
                        <h4 class="body-1">Email:- {{job.email}}</h4>
                    </v-col>
                    <v-col cols="12" md="6">
                        <h4 class="body-1">Phone:- {{job.phone}}</h4>
                    </v-col>
                    <v-col class="mt-5" cols="12" >
                        <span>Job Details</span>
                        <div class="tiptap-vuetify-editor__content" v-html="job.jobDetails"/>
                    </v-col>
                    <v-col class="mt-5" cols="12" >
                        <span>Requerments</span>
                        <div class="tiptap-vuetify-editor__content" v-html="job.requerments"/>
                    </v-col>
                    <v-col class="mt-5" cols="12" >
                        <span>Edicational Qualification</span>
                        <div class="tiptap-vuetify-editor__content" v-html="job.qualification"/>
                    </v-col>
                    <v-col class="mt-5" cols="12" >
                        <span>Other Benifit</span>
                        <div class="tiptap-vuetify-editor__content" v-html="job.benefit"/>
                    </v-col>
                    <v-col cols="12" v-if="!job.verify">
                        <v-btn outlined color="indigo" @click="approve">Approved</v-btn>
                        <v-btn outlined color="red" @click="deleteJob">Delete</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
    </v-container>
        <v-footer>
            <BottomFooter></BottomFooter>
        </v-footer>
        <v-dialog
            v-model="loading"
            hide-overlay
            persistent
            width="300"
        >
            <v-card
                color="primary"
                dark
            >
                <v-card-text>
                    Please stand by
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
import User from "../../../helper/User";
import TopNav from "../navigationBar";
import BottomFooter from "../BottomFooter";
import { TiptapVuetify } from 'tiptap-vuetify'

    export default {
        name: "views",
        created() {
            if (!User.isExpired()){
                this.$router.push({name:'logout'});
            }
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
            this.fatchalldata();
            this.checkEmail();
            this.featchUserData();
        },
        data(){
            return {
                user:[],
                job:{},
                offday:[],
                loading:false,
            }
        },
        methods:{
            approve(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                        if (result.value) {
                            this.loading = true;
                            let id= this.$route.params.id;
                            axios.get('/api/admin/job/approve/'+id)
                                .then(res => {
                                    this.loading = false;
                                    Swal.fire(
                                        'Success!',
                                        res.data.msg,
                                        'success'
                                    )
                                    this.fatchalldata();
                                })
                                .catch(error => {
                                    this.loading = false;
                                    if (error.response.data.errors) {
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Something Wrong Try Again'
                                        })
                                    }
                                })
                        }
                })
            },
            featchUserData(){
                let id=User.id();
                axios.get('/api/admin/info/'+id)
                    .then(res =>{
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
            fatchalldata(){
                let id= this.$route.params.id;
                axios.get('/api/admin/job/show/'+id)
                    .then(res =>{
                    this.job=res.data[0][0];
                    this.offday=res.data[1];
                })
            },
            deleteJob(){
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
                        this.loading = true;
                        let id= this.$route.params.id;
                        axios.get('/api/admin/job/destroy/'+ id)
                            .then(res=>{
                                this.loading = false;
                                this.$router.push({name:'alljob'});
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
                                    'success'
                                )
                            } )
                            .catch(error => {
                                this.loading = false;
                                Swal.fire(
                                    'Sorry!',
                                    'Something wrong try again.',
                                    'error'
                                )
                            })
                    }
                })
            },
        },
        components:{
            TopNav,BottomFooter,TiptapVuetify
        }
    }
</script>

<style scoped>

</style>
