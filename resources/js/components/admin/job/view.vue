<template>
    <v-app>


    <TopNav></TopNav>
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

                    <v-col cols="12" md="4">
                        <h4 class="body-1">Off Day:- {{job.offday}}  </h4>
                    </v-col>
                    <v-col cols="12" md="4">
                        <h4 class="body-1">Salary:- {{job.salary}} BDT</h4>
                    </v-col>
                    <v-col cols="12" md="4">
                        <h4 class="body-1">Vacency:- {{job.vacency}}</h4>
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
                    <v-col class="mt-5" cols="12" md="6" >
                        <span>Image</span>
                        <v-img :src="'/'+job.image" height="250px" width="250px"></v-img>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
    </v-container>
        <v-footer>
            <BottomFooter></BottomFooter>
        </v-footer>
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
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
            this.fatchalldata();
        },
        data(){
            return {
                job:{},
            }
        },
        methods:{
            fatchalldata(){
                let id= this.$route.params.id;
                axios.get('/api/admin/job/show/'+id)
                    .then(res =>{
                        this.job=res.data[0];
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
