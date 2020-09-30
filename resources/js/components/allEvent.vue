<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
   <v-container>
       <v-row  class="mt-10 mb-10">
           <v-col
               cols="12"
               md="6"
               v-for="row in event" :key="row.id"
           >
               <v-card
                   outlined
               >
                   <v-list-item >
                       <v-list-item-content
                       >
                           <v-toolbar flat>
                               <v-toolbar-title>
                                   <v-btn
                                       text
                                       :to="'/event/'+row.id"
                                       class="body-1"
                                   >
                                       {{row.name}}
                                   </v-btn>
                               </v-toolbar-title>
                               <v-spacer></v-spacer>
                               <div >
                                   <v-btn icon color="pink"  @click="shortlistEvent(row.id)">
                                       <v-icon>mdi-star-outline</v-icon>
                                   </v-btn>
                               </div>
                           </v-toolbar>
                           <v-banner
                               single-line
                           >
                               Company - {{row.company}}
                           </v-banner>

                           <v-list-item-subtitle>
                               <v-chip
                                   class="ma-2"
                                   v-if="row.location === '1'"
                               >
                                   <v-icon left>mdi-map-marker</v-icon>
                                   Dhaka, Bangladesh
                               </v-chip>

                               <v-chip
                                   class="ma-2"
                                   v-if="row.location === '2'"
                               >
                                   <v-icon left>mdi-map-marker</v-icon>
                                   Outside Dhaka
                               </v-chip>

                               <v-chip
                                   class="ma-2"
                               >
                                   <v-icon left>mdi-timetable</v-icon>
                                   {{ row.eventDate }}
                               </v-chip>
                           </v-list-item-subtitle>
                       </v-list-item-content>
                   </v-list-item>
               </v-card>
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
       <v-row v-if="count<=0" align="center"
              justify="center">
           <v-card
               outlined
           >
               <v-list-item >
                   <v-list-item-avatar
                       tile
                       size="140"
                   >
                       <v-img
                           src="/asset/img/others/404/emoji.png"
                       >
                       </v-img>
                   </v-list-item-avatar>
                   <v-list-item-content
                   >
                       <v-list-item-title class=" font-weight-black" >
                           <h1 >Sorry</h1>
                       </v-list-item-title>
                       <v-list-item-title
                       >
                           <p>  No related post found</p>

                       </v-list-item-title>

                   </v-list-item-content>
               </v-list-item>
           </v-card>
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
name: "allEvent",
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
    },
    data(){
        return {
            user:{},
            event:{},
            events:{},
            count:'',
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
        fetchEventList(page = 1){
            axios.get('/api/event/all?page=' + page)
                .then(res=>{
                    this.events=res.data.event;
                    this.event=res.data.event.data;
                    this.count=res.data.event.total;
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
    }
}
</script>

<style scoped>

</style>
