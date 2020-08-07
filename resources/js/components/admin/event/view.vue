<template>
    <v-app>
        <TopNav></TopNav>
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
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-container>
        <v-footer fixed>
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
            event:{},
        }
    },
    methods:{
        fatchalldata(){
            let id= this.$route.params.id;
            axios.get('/api/admin/event/show/'+id)
                .then(res =>{
                    this.event=res.data;
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
