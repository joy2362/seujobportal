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
                    <v-toolbar flat>
                        <v-toolbar-title>
                            {{event.name}}
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <div >
                            <v-btn icon color="pink"  @click="shortlistEvent(event.id)">
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

                        <div class="my-4 subtitle-1">
                                sponsor {{event.company}}
                        </div>

                        <div>Location {{event.address}}</div>
                    </v-card-text>

                    <v-divider class="mx-4"></v-divider>

                    <v-card-title>Event Details</v-card-title>

                    <v-card-text>
                        <div class="tiptap-vuetify-editor__content" v-html="event.details"/>

                    </v-card-text>
                    <v-card-text>
                        <v-chip
                            class="ma-2"
                            v-if="event.location === '1'"
                        >
                            <v-icon left>mdi-map-marker</v-icon>
                            Dhaka, Bangladesh
                        </v-chip>

                        <v-chip
                            class="ma-2"
                            v-if="event.location === '2'"
                        >
                            <v-icon left>mdi-map-marker</v-icon>
                            Outside Dhaka
                        </v-chip>
                        <v-chip
                            class="ma-2"
                        >
                            <v-icon left>mdi-calendar-check</v-icon>
                            {{event.eventDate}}
                        </v-chip>
                        <v-chip
                            class="ma-2"
                        >
                            <v-icon left> mdi-timer</v-icon>
                            {{event.eventStart}}
                        </v-chip>

                    </v-card-text>
                </v-card>
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
import { TiptapVuetify } from 'tiptap-vuetify'

export default {
name: "singleEvent",
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
            event:{},
            owner:{},
        }
    },
    methods:{
        shortlistEvent(id){
            const formData = new FormData();
            formData.append('email', User.email());
            formData.append('eventId', id);
            axios.post('/api/event/shortlist/add',formData)
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

            axios.get('/api/event/info/'+id)
                .then(res=>{
                    this.event=res.data.event;
                    this.owner=res.data.user;
                })
                .catch(error=>{
                    this.$router.push({name:'findEvent'});
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
