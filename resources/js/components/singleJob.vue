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
                    class="mx-auto my-12 blue-grey lighten-5"
                >
                    <v-card-title>{{job.name}}</v-card-title>

                    <v-card-text>
                        <v-row
                            align="center"
                            class="mx-0"
                        >
                            Posted By {{job.owner}}
                        </v-row>

                        <div class="my-4 subtitle-1">
                            sponsor {{job.company}}
                        </div>

                        <div>Location {{job.address}}</div>
                    </v-card-text>

                    <v-divider class="mx-4"></v-divider>

                    <v-card-title>Event Details</v-card-title>

                    <v-card-text>
                        <div class="tiptap-vuetify-editor__content" v-html="job.details"/>

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
                            {{job.eventDate}}
                        </v-chip>
                        <v-chip
                            class="ma-2"
                        >
                            <v-icon left> mdi-timer</v-icon>
                            {{job.eventStart}}
                        </v-chip>

                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</v-app>
</template>

<script>
import User from "../helper/User";
import topNavBar from "./layouts/topNavBar";
import bottomFooter from "./layouts/bottomFooter";
import { TiptapVuetify } from 'tiptap-vuetify'
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
    data(){
        return {
            user:{},
            job:{},
            owner:{},
            offdays:{},
        }
    },
    methods:{
        fetchEvent() {
            let id=this.$route.params.id;

            axios.get('/api/job/info/'+id)
                .then(res=>{
                    this.job=res.data.job;
                    this.owner=res.data.user;
                    this.offdays=res.data.offday;
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
