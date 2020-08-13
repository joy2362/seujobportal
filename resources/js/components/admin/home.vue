<template>
    <v-app>
        <Navbars></Navbars>
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
                        <h2 class="title">1990</h2>
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
                           <h2 class="title">19</h2>
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
                           <h1 class="title">Total  Application</h1>
                       </v-card-title>
                       <v-card-text
                           align="center"
                           justify="center"
                       >
                           <h2 class="title">1990</h2>
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
                           Recent Application
                           <v-spacer></v-spacer>
                           <v-text-field
                               v-model="recentApplicationsearch"
                               append-icon="mdi-magnify"
                               label="Search"
                               single-line
                               hide-details
                           ></v-text-field>
                       </v-card-title>
                       <v-data-table
                           :headers="recentApplicationheaders"
                           :items="recentApplication"
                           :search="recentApplicationsearch"
                       ></v-data-table>
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
                        ></v-data-table>
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
                        ></v-data-table>
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
                        ></v-data-table>
                    </v-card>
                </v-col>

            </v-row>
           <v-row class="mt-15">
               <v-col
                   col="12"
               >
                   <v-card class="success white--text" >
                       <v-card-title class="mb-3">
                           Upcomming Event
                           <v-spacer></v-spacer>
                           <v-text-field
                               v-model="recenteventsearch"
                               append-icon="mdi-magnify"
                               label="Search"
                               single-line
                               hide-details
                           ></v-text-field>
                       </v-card-title>
                       <v-data-table
                           :headers="recentEventheaders"
                           :items="recentEvent"
                           :search="recenteventsearch"
                       ></v-data-table>
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
        },
        data(){
            return{

                recentApplicationsearch: '',
                recentStudentsearch: '',
                recentAlumnisearch: '',
                recentFacultysearch: '',
                recenteventsearch: '',

                recentApplicationheaders: [
                    {
                        text: 'Student name',
                        align: 'start',
                        value: 'name',
                    },
                    { text: 'Position', value: 'job' },
                    { text: 'Conpany name', value: 'company' },
                    { text: 'Date ', value: 'date' },

                ],
                recentEventheaders: [
                    {
                        text: 'Event name',
                        align: 'start',
                        value: 'name',
                    },
                    { text: 'company', value: 'company' },
                    { text: 'Date ', value: 'date' },

                ],

                recentUserheaders: [
                    {
                        text: 'Name',
                        align: 'start',
                        value: 'name',
                    },
                    { text: 'Join Date ', value: 'date' },

                ],
                recentApplication: [
                    {
                        name: 'Zahid',
                        job: 'web-developer',
                        company: 'web-developer',
                        date: "6/12/2020",
                    },
                    {
                        name: 'Zahid',
                        job: 'web-developer',
                        company: 'web-developer',
                        date: "6/12/2020",
                    },
                ],
                recentEvent: [
                    {
                        name: 'Graphic designer',
                        company: 'Samsung',
                        date: "6/12/2020",
                    },
                    {
                        name: 'Seminer',
                        company: 'Seu',
                        date: "6/12/2020",
                    },
                ],
                recentStudent: [
                    {
                        name: 'Zahid',
                        date: "6/12/2020",
                    },
                    {
                        name: 'Ripon',
                        date: "6/12/2020",
                    },
                ],
                recentAlumni: [
                    {
                        name: 'zahid234',
                        date: "6/12/2020",
                    },
                    {
                        name: 'Ripon234',
                        date: "6/12/2020",
                    },
                ],
                recentFaculty: [
                    {
                        name: 'Ripon123',
                        date: "6/12/2020",
                    },
                    {
                        name: 'zahid123',
                        date: "6/12/2020",
                    },
                ],
            }


        },
        methods:{
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
            Navbars,BottomFooter
        },
    }
</script>

<style scoped>

</style>
