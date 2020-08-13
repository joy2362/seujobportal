<template>
    <v-app>
        <TopNav></TopNav>
        <v-container>
            <v-row class="mt-15">
                <v-col
                    col="12"
                >
                    <v-card class="red white--text" >
                        <v-card-title class="mb-3">
                            <span class="mr-5">Event</span>
                            <v-toolbar-title
                                class="text-uppercase"
                            >
                                <v-btn
                                    small
                                    text
                                    class="white--text"
                                    to="/admin/event/add"
                                >
                                    Add New
                                </v-btn>
                            </v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="eventSearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :headers="eventheaders"
                            :search="eventSearch"
                            :items="event"
                        >
                            <template v-slot:item.controls="event">
                                <v-btn class="mx-1" fab dark small color="success" @click="eventShow(event.item)">
                                    <v-icon dark>mdi-open-in-new</v-icon>
                                </v-btn>
                                <v-btn class="mx-1" fab dark small color="info" @click="eventEdit(event.item)">
                                    <v-icon dark>mdi-tune</v-icon>
                                </v-btn>
                                <v-btn class="mx-1" fab dark small color="red" @click="deleteevent(event.item)">
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-footer
            fixed
        >
            <BottomFooter></BottomFooter>
        </v-footer>
    </v-app>
</template>

<script>
import User from "../../../helper/User";
import TopNav from "../navigationBar";
import BottomFooter from "../BottomFooter";

export default {
    name: "index",
    created() {
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.hasadminaccess()) {
            this.$router.push({name: 'adminauth'});
        }
        this.fatchalldata();
        this.checkEmail();
    },
    data(){
        return{
            event:[],
            eventSearch:'',
            eventheaders: [
                {
                    text: '#',
                    align: 'start',
                    value: 'id',
                },
                { text: 'Title', value: 'name' },
                { text: 'Event Date', value: 'eventDate' },
                { text: 'Time', value: 'eventStart' },
                { text: "Action", value: "controls", sortable: false }
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
        fatchalldata(){
            axios.get('/api/admin/event/index')
                .then(res =>{
                    this.event=res.data;
                })
        },
        eventEdit(item){
            this.$router.push('/edit/event/'+ item.id);
        },
       eventShow(item){
            this.$router.push('/show/event/'+ item.id);
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
                            this.fatchalldata();
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
        TopNav,BottomFooter
    }
}
</script>

<style scoped>

</style>
