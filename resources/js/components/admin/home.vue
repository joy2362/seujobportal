<template>
    <v-app>
        <v-container >
            <v-toolbar  flat >
                <v-toolbar-items >
                    <v-app-bar-nav-icon  @click="sideMenu = !sideMenu"></v-app-bar-nav-icon>
                </v-toolbar-items>
                <v-toolbar-title class="text-uppercase red--text">
                    <span  class="font-weight-light">Admin<span class="font-weight-black">Panel</span></span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items >
                    <v-menu  offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-avatar
                                size="52"
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-img
                                    :src="'/'+user.image"
                                >
                                </v-img>
                            </v-avatar>
                        </template>
                        <v-list>
                            <v-list-item
                                to="/"
                            >
                                <v-list-item-title>
                                    <v-icon>
                                        mdi-account
                                    </v-icon>
                                    Profile
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                to="/"
                            >
                                <v-list-item-title>
                                    <v-icon>
                                        mdi-tune
                                    </v-icon>
                                    Setting</v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                to="/logout"
                            >
                                <v-list-item-title>
                                <v-icon>mdi-exit-to-app</v-icon>
                                    Logout
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                </v-toolbar-items>
            </v-toolbar>
            <v-navigation-drawer
                v-model="sideMenu"
                app
                temporary
            >
                <v-list nav>
                    <v-list-item two-line :class=" 'px-0'">
                        <v-list-item-avatar>
                            <v-img
                                :src="'/'+user.image"
                            >
                            </v-img>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title>{{user.name}}</v-list-item-title>
                            <v-list-item-subtitle >Logged In</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                        <v-list-item
                            to="/"
                        >
                            <v-list-item-icon>
                                <v-icon>mdi-view-dashboard</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>Dashboard</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    <v-list-item to='/'>
                        <v-list-item-content >
                            <v-list-item-title dark>About</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to='/'>
                        <v-list-item-content>
                            <v-list-item-title dark>Contact</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

            </v-navigation-drawer>
        </v-container>
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
            <v-row>
                <v-col
                    class="grey darken-4 py-4 text-center white--text"
                    cols="12"
                >
                    Copyright &copy;{{ new Date().getFullYear() }} | Southeast University | All rights reserved | Developed with
                    <v-icon color="red">mdi-heart</v-icon> by <v-btn text dark href="#" target="_blank">
                    Joy2362
                </v-btn>
                </v-col>
            </v-row>
        </v-footer>
    </v-app>
</template>

<script>
    import User from "../../helper/User";

    export default {
        name: "home",
        created() {
            if (!User.loggedIn()) {
                this.$router.push({name: 'login'});
            }
            if (!User.isAdmin()) {
                this.$router.push({name: 'home'});
            }
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
        },
        data(){
            return{
                user:{
                    name:User.name(),
                    email:User.email(),
                    image:User.picture(),
                },
                sideMenu:false,
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
    }
</script>

<style scoped>

</style>
