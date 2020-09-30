<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container  class="fill-height">
        <v-row
            align="center"
            justify="center"
        >
            <v-col
                md="6"
                cols="12"
            >
                <v-card
                    class=" blue-grey lighten-5"
                >
                    <v-toolbar flat>
                        <v-toolbar-title>
                                {{job.name}}
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <div >
                            <v-btn icon color="pink"  @click="shortlist(job.id)">
                                <v-icon>mdi-star-outline</v-icon>
                            </v-btn>
                        </div>
                    </v-toolbar>


                    <v-card-text>
                        <v-row
                            align="center"
                            class="mx-0"
                        >
                            Posted By {{owner.name}}
                        </v-row>

                        <div class="my-4 ">
                            Company {{job.company}}
                        </div>

                        <div>Location {{job.address}}</div>
                    </v-card-text>

                    <v-divider class="mx-4"></v-divider>


                    <v-card-text>
                        <v-row
                            align="center"
                            class="mx-0"
                        >
                            Category {{category.name}}
                        </v-row>

                        <div class="my-4 " v-if="job.JobType==1">
                            Job Type part-time
                        </div>
                        <div class="my-4 " v-else>
                            Job Type full-time
                        </div>

                        <div class="my-4 ">Experience {{job.experience}} year</div>
                        <div class="my-4 ">Office Time {{job.dutyStart}} - {{job.dutyEnd}}</div>
                        <div>Salary  {{job.salary}} BDT</div>
                    </v-card-text>
                    <v-divider class="mx-4"></v-divider>
                    <v-card-text>
                        <v-row
                            align="center"
                            class="mx-0"
                        >
                           Email {{job.email}}
                        </v-row>

                        <div class="mt-4 ">
                            Phone {{job.phone}}
                        </div>

                    </v-card-text>

                    <v-divider class="mx-4"></v-divider>
                    <v-card-title>Job Description</v-card-title>

                    <v-card-text>
                        <div class="tiptap-vuetify-editor__content" v-html="job.jobDetails"/>

                    </v-card-text>
                    <v-divider class="mx-4"></v-divider>
                    <v-card-title>Requerments</v-card-title>

                    <v-card-text>
                        <div class="tiptap-vuetify-editor__content" v-html="job.requerments"/>

                    </v-card-text>
                    <v-divider class="mx-4"></v-divider>
                    <v-card-title>Education</v-card-title>

                    <v-card-text>
                        <div class="tiptap-vuetify-editor__content" v-html="job.qualification"/>

                    </v-card-text>
                    <v-divider class="mx-4"></v-divider>
                    <v-card-title>Benifit</v-card-title>

                    <v-card-text>
                        <div class="tiptap-vuetify-editor__content" v-html="job.benefit"/>

                    </v-card-text>

                    <v-card-text>
                        <v-chip
                            class="ma-2"
                            v-if="job.location === '1'"
                        >
                            <v-icon left>mdi-map-marker</v-icon>
                            Dhaka, Bangladesh
                        </v-chip>

                        <v-chip
                            class="ma-2"
                            v-if="job.location === '2'"
                        >
                            <v-icon left>mdi-map-marker</v-icon>
                            Outside Dhaka
                        </v-chip>
                        <v-chip
                            class="ma-2"
                        >
                            <v-icon left>mdi-calendar-check</v-icon>
                            {{job.lastdate}}
                        </v-chip>

                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="deep-purple lighten-2"
                            text
                            @click="applyJob"
                        >
                            Apply now
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog v-model="addCv"  max-width="600px">
        <v-card>
            <v-toolbar
                flat
                dark
                class="red lighten-1"
            >
                <v-toolbar-title class="text-uppercase ">Add CV</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <v-form>
                    <v-file-input
                        v-model="cv"
                        accept=".pdf"
                        label="CV"
                        prepend-icon="mdi-cloud-upload"
                        :error-messages="cvErrors"
                        @input="$v.cv.$touch()"
                        @blur="$v.cv.$touch()"
                    >
                    </v-file-input>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="addCv = false">Close</v-btn>
                <v-btn color="blue darken-1" text @click="Update">Apply now</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
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
import User from "../helper/User";
import topNavBar from "./layouts/topNavBar";
import bottomFooter from "./layouts/bottomFooter";
import { TiptapVuetify } from 'tiptap-vuetify'
import {required} from "vuelidate/lib/validators";

export default {
name: "singleJob",
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
        this.fetchEvent();
    },
    validations: {
        cv:{required},
    },
    data(){
        return {
            user:{},
            job:{},
            owner:{},
            offdays:{},
            category:{},
            addCv:false,
            loading:false,
            cv:null,
        }
    },
    computed:{
        cvErrors () {
            const errors = []
            if (!this.$v.cv.$dirty) return errors
            !this.$v.cv.required && errors.push('CV is required')
            return errors
        },

    },
    methods:{
        Update(){
            this.loading=true;
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.loading=false;
                Toast.fire({
                    icon: 'error',
                    title: 'Select a image first!!'
                })
            }else{
                const formData = new FormData();
                let id=this.$route.params.id;
                formData.append('email', this.user.email);
                formData.append('id', id);
                formData.append('cv', this.cv,this.cv.name);
                axios.post('/api/faculty/job/apply',formData)
                    .then(res =>{
                        this.loading=false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                    })
                    .catch(error=>{
                        this.loading=false;
                        if(error.response.data.msg){
                            Toast.fire({
                                icon: 'error',
                                title: 'Already Applied this job'
                            })
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: 'Something wrong try again'
                            })
                        }
                    })
            }
        },
        applyJob(){
            this.loading=true;
            let id=this.$route.params.id;
            if(this.user.user_type){
                if(this.user.user_type === '4' || this.user.user_type === '3' ){
                    const formData = new FormData();
                    formData.append('email', this.user.email);
                    formData.append('id', id);
                    axios.post('/api/job/apply',formData)
                        .then(res =>{
                            this.loading=false;
                            Swal.fire(
                                'Success!',
                                res.data.msg,
                                'success'
                            )
                        })
                        .catch(error=>{
                            this.loading=false;
                            if(error.response.data.msg){
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Already Applied this job'
                                })
                            }else{
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Something wrong try again'
                                })
                            }
                        })

                }else{
                    this.loading=false;
                    this.addCv=!this.addCv;

                }
            }else{
                this.loading=false;
                Swal.fire(
                    'Sorry!',
                    "Admin Are not Allow to Apply for job",
                    'error'
                )
            }


        },
        shortlist(id){
            const formData = new FormData();
            formData.append('email', User.email());
            formData.append('jobId', id);
            axios.post('/api/shortlist/add',formData)
                .then(res =>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Successfully Added to your favourite list'
                    })
                })
                .catch(error=>{
                    if(error.response.data.msg){
                        Toast.fire({
                            icon: 'error',
                            title: 'Already Added'
                        })
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Something wrong try again'
                        })
                    }
                })
        },
        fetchEvent() {
            let id=this.$route.params.id;

            axios.get('/api/job/info/'+id)
                .then(res=>{
                    this.job=res.data.job;
                    this.owner=res.data.user;
                    this.offdays=res.data.offday;
                    this.category=res.data.category;
                })
                .catch(error=>{
                    this.$router.push({name:'findJob'});
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
        TiptapVuetify
    },
}
</script>

<style scoped>

</style>
