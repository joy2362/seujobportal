<template>
    <v-app>
        <TopNav :user="user"></TopNav>
        <v-container>
            <v-card>
                <v-card-title>
                    <span class="headline">Event Details</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="5">
                                <h4 class="body-1">Event Name:- {{event.name}} </h4>
                            </v-col>
                            <v-col cols="12" md="4">
                                <h4 class="body-1">Company:- {{event.company}} </h4>
                            </v-col>
                            <v-col cols="12" md="3">
                                <h4 v-if=" event.location === '1' " class="body-1"> Location:- Inside Dhaka</h4>
                                <h4 v-else class="body-1"> Location:- Out Dhaka</h4>
                            </v-col>
                            <v-col cols="12" md="6">
                                <h4 class="body-1">Address:- {{event.address}} </h4>
                            </v-col>
                            <v-col cols="12" md="3">
                                <h4 class="body-1">Event date:- {{event.eventDate}} </h4>
                            </v-col>
                            <v-col cols="12" md="2">
                                <h4 class="body-1">Event start:- {{event.eventStart}} </h4>
                            </v-col>
                            <v-col class="mt-5" cols="12" >
                                <span>Event Details</span>
                                <div class="tiptap-vuetify-editor__content" v-html="event.details"/>
                            </v-col>
                            <v-col cols="12" v-if="!event.verify">
                                <v-btn outlined color="indigo" @click="approve">Approved</v-btn>
                                <v-btn outlined color="red" @click="deleteevent">Delete</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-container>
        <v-footer >
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
            event:{},
            loading:false,
        }
    },
    methods:{
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
            axios.get('/api/admin/event/show/'+id)
                .then(res =>{
                    this.event=res.data;
                })
        },
        deleteevent(){
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
                    this.loading=true;
                    let id= this.$route.params.id;
                    axios.get('/api/admin/event/destroy/'+ id)
                        .then(res=>{
                            this.loading=false;
                            this.$router.push({name:'allevent'});
                            Swal.fire(
                                'Deleted!',
                                res.data.msg,
                                'success'
                            )
                        } )
                        .catch(error => {
                            this.loading=false;
                            Swal.fire(
                                'Sorry!',
                                'Something wrong try again.',
                                'error'
                            )
                        })
                }
            })
        },
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
                    let id = this.$route.params.id;
                    axios.get('/api/admin/event/approve/' + id)
                        .then(res => {
                            this.loading = false;
                            this.$router.push({name: 'allevent'});
                            Swal.fire(
                                'Success!',
                                res.data.msg,
                                'success'
                            )
                        })
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
        }
    },
    components:{
        TopNav,BottomFooter,TiptapVuetify
    }
}
</script>

<style scoped>

</style>
