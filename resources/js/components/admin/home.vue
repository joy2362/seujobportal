<template>
    <v-app>
        <Navbars :user="user"></Navbars>
        <!--this end  navigration-->
       <v-container>
           <v-row>
               <v-col
                   md="1"
               >
               </v-col>
               <v-col
                   md="3"
                   cols="12"
               >
                <v-card>
                    <v-card-title primary-title class="layout justify-center success white--text">
                        <h1 class="title">Total User</h1>
                    </v-card-title>
                    <v-card-text
                        align="center"
                        justify="center"
                    >
                        <h2 class="title">{{totalUser}}</h2>
                    </v-card-text>
                </v-card>
               </v-col>
               <v-col
               md="1"
               >
               </v-col>
               <v-col
                   md="3"
                   cols="12"
               >
                   <v-card>
                       <v-card-title primary-title class="layout justify-center primary white--text">
                           <h1 class="title">Job circular</h1>
                       </v-card-title>
                       <v-card-text
                           align="center"
                           justify="center"
                       >
                           <h2 class="title">{{totalJob}}</h2>
                       </v-card-text>
                   </v-card>
               </v-col>
               <v-col
                   md="1"
               >
               </v-col>
               <v-col
                   md="3"
                   cols="12"
               >
                   <v-card>
                       <v-card-title primary-title class="layout justify-center info white--text">
                           <h1 class="title">Total Events</h1>
                       </v-card-title>
                       <v-card-text
                           align="center"
                           justify="center"
                       >
                           <h2 class="title">{{totalEvents}}</h2>
                       </v-card-text>
                   </v-card>
               </v-col>
           </v-row>
           <v-row class="mt-15">
               <v-col
               col="12"
               >
                   <v-card class="red white--text" >
                       <v-card-title class="mb-3">
                          Expired Job post
                           <v-spacer></v-spacer>
                           <v-text-field
                               v-model="ExpiredJobSearch"
                               append-icon="mdi-magnify"
                               label="Search"
                               single-line
                               hide-details
                           ></v-text-field>
                       </v-card-title>
                       <v-data-table
                           :headers="expiredJobHeader"
                           :items="expiredJob"
                           :search="ExpiredJobSearch"
                       >
                           <template v-slot:item.controls="expiredJob">
                               <v-btn class="mx-1" icon  @click="deleteJob(expiredJob.item)">
                                   <v-icon dark>mdi-delete</v-icon>
                               </v-btn>
                           </template>
                       </v-data-table>
                   </v-card>
               </v-col>
           </v-row>
           <v-row class="mt-15">
               <v-col
                   col="12"
               >
                   <v-card class="blue-grey lighten-1 white--text" >
                       <v-card-title class="mb-3">
                           Pending Job post
                           <v-spacer></v-spacer>
                           <v-text-field
                               v-model="pendingJobSearch"
                               append-icon="mdi-magnify"
                               label="Search"
                               single-line
                               hide-details
                           ></v-text-field>
                       </v-card-title>
                       <v-data-table
                           :headers="pendingJobHeader"
                           :items="pendingJob"
                           :search="pendingJobSearch"
                       >
                           <template v-slot:item.controls="pendingJob">
                               <v-btn class="mx-1" icon dark small color="success" @click="JobShow(pendingJob.item)">
                                   <v-icon dark>mdi-open-in-new</v-icon>
                               </v-btn>
                           </template>
                       </v-data-table>
                   </v-card>
               </v-col>
           </v-row>
            <v-row
            class="mt-15"
            >
                <v-col
                md="4"
                cols="12"
                >
                    <v-card class="info white--text" >
                        <v-card-title class="mb-3">
                            Student
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="recentStudentsearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :headers="recentUserheaders"
                            :items="recentStudent"
                            :search="recentStudentsearch"
                        >
                            <template v-slot:item.controls="recentStudent">
                                <v-btn class="mx-1" icon  @click="deleteStudent(recentStudent.item)">
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
                <v-col
                    md="4"
                    cols="12"
                >
                    <v-card class="info white--text" >
                        <v-card-title class="mb-3">
                            Alumni
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="recentAlumnisearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :headers="recentUserheaders"
                            :items="recentAlumni"
                            :search="recentAlumnisearch"
                        >
                            <template v-slot:item.controls="recentAlumni">
                                <v-btn class="mx-1" icon  @click="deletealumni(recentAlumni.item)">
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
                <v-col
                    md="4"
                    cols="12"
                >
                    <v-card class="info white--text" >
                        <v-card-title class="mb-3">
                            Faculty
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="recentFacultysearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :headers="recentUserheaders"
                            :items="recentFaculty"
                            :search="recentFacultysearch"
                        >
                            <template v-slot:item.controls="recentFaculty">
                                <v-btn class="mx-1" icon  @click="deleteFaculty(recentFaculty.item)">
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>

            </v-row>
           <v-row class="mt-15">
               <v-col
                   col="12"
               >
                   <v-card class="success white--text" >
                       <v-card-title class="mb-3">
                          Event
                           <v-spacer></v-spacer>
                           <v-text-field
                               v-model="expiredeventsearch"
                               append-icon="mdi-magnify"
                               label="Search"
                               single-line
                               hide-details
                           ></v-text-field>
                       </v-card-title>
                       <v-data-table
                           :headers="expiredEventheaders"
                           :items="expiredEvent"
                           :search="expiredeventsearch"
                       >
                           <template v-slot:item.controls="expiredEvent">
                               <v-btn class="mx-1" icon  @click="deleteevent(expiredEvent.item)">
                                   <v-icon dark>mdi-delete</v-icon>
                               </v-btn>
                           </template>
                       </v-data-table>
                   </v-card>
               </v-col>
           </v-row>
       </v-container>
        <v-footer>
            <BottomFooter></BottomFooter>
        </v-footer>
    </v-app>
</template>

<script>
    import User from "../../helper/User";
    import Navbars from "./navigationBar"
    import BottomFooter from "./BottomFooter"
    export default {
        name: "home",
        created() {
            if (!User.isExpired()){
                this.$router.push({name:'logout'});
            }
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
            this.checkEmail();
            this.featchAllData();
            this.featchUserData();
        },
        data(){
            return{
                user:[],

                totalUser:'',
                totalJob:'',
                totalEvents:'',

                ExpiredJobSearch:'',
                pendingJobSearch:'',
                recentStudentsearch: '',
                recentAlumnisearch: '',
                recentFacultysearch: '',
                expiredeventsearch: '',

                expiredJobHeader: [
                    {
                        text: 'Title',
                        align: 'start',
                        value: 'name',
                    },
                    { text: 'Conpany name', value: 'company' },
                    { text: 'Date ', value: 'lastdate' },
                    { text: "Action", value: "controls", sortable: false }

                ],
                pendingJobHeader: [
                    {
                        text: 'Title',
                        align: 'start',
                        value: 'name',
                    },
                    { text: 'Conpany name', value: 'company' },
                    { text: 'Date ', value: 'lastdate' },
                    { text: "Action", value: "controls", sortable: false }

                ],

                expiredEventheaders: [
                    {
                        text: 'Event name',
                        align: 'start',
                        value: 'name',
                    },
                    { text: 'company', value: 'company' },
                    { text: 'Date ', value: 'eventDate' },
                    { text: "Action", value: "controls", sortable: false }

                ],

                recentUserheaders: [
                    {
                        text: 'Name',
                        align: 'start',
                        value: 'email',
                    },
                    { text: "Action", value: "controls", sortable: false }

                ],

                expiredJob:[],
                pendingJob:[],
                recentStudent: [],
                recentAlumni: [],
                recentFaculty: [],
                expiredEvent: [],
            }
        },
        methods:{
            JobShow(item){
                this.$router.push('/show/job/'+ item.id);
            },
            featchUserData(){
                let id=User.id();
                axios.get('/api/admin/info/'+id)
                    .then(res =>{
                        this.user=res.data.user;
                    })
            },
            featchAllData(){
                axios.get('/api/admin/home/all')
                .then(res =>{
                    this.totalUser=res.data.totaluser;
                    this.totalJob=res.data.totalJob;
                    this.totalEvents=res.data.totalEvents;
                    this.expiredEvent=res.data.event;
                    this.recentStudent=res.data.student;
                    this.recentAlumni=res.data.alumni;
                    this.recentFaculty=res.data.faculty;
                    this.expiredJob=res.data.job;
                    this.pendingJob=res.data.pendingJob;
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
            deleteevent(item){
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
                        axios.get('/api/admin/event/destroy/'+ item.id)
                            .then(res=>{
                                this.featchAllData();
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
                                    'success'
                                )
                            } )
                            .catch(error => {
                                Swal.fire(
                                    'Sorry!',
                                    'Something wrong try again.',
                                    'error'
                                )
                            })
                    }
                })
            },
            deleteStudent(item){
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
                        axios.get('/api/admin/student/destroy/'+ item.id)
                            .then(res=>{
                                this.featchAllData();
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
                                    'success'
                                )
                            } )
                            .catch(error => {
                                Swal.fire(
                                    'Sorry!',
                                    'Something wrong try again.',
                                    'error'
                                )
                            })
                    }
                })
            },
            deletealumni(item){
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
                        axios.get('/api/admin/alumni/destroy/'+ item.id)
                            .then(res=>{
                                this.featchAllData();
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
                                    'success'
                                )
                            } )
                            .catch(error => {
                                Swal.fire(
                                    'Sorry!',
                                    'Something wrong try again.',
                                    'error'
                                )
                            })
                    }
                })
            },
            deleteFaculty(item){
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
                        axios.get('/api/admin/faculty/destroy/'+ item.id)
                            .then(res=>{
                                this.featchAllData();
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
                                    'success'
                                )
                            } )
                            .catch(error => {
                                Swal.fire(
                                    'Sorry!',
                                    'Something wrong try again.',
                                    'error'
                                )
                            })
                    }
                })
            },
            deleteJob(item){
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
                        axios.get('/api/admin/job/destroy/'+ item.id)
                            .then(res=>{
                                this.featchAllData();
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
                                    'success'
                                )
                            } )
                            .catch(error => {
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
            Navbars,BottomFooter
        },
    }
</script>

<style scoped>

</style>
