<template>
    <v-app>
        <TopNav :user="user"></TopNav>
        <v-container>
            <v-row class="mt-15">
                <v-col
                    col="12"
                >
                    <v-card class="red white--text" >
                        <v-card-title class="mb-3">
                            <span class="mr-5">Admin</span>
                            <v-toolbar-title
                                class="text-uppercase"
                            >
                                <v-btn
                                    small
                                    text
                                    class="white--text"
                                    to="/admin/add"
                                >
                                    Add New
                                </v-btn>
                            </v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="adminsearch"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :headers="adminheader"
                            :search="adminsearch"
                            :items="admins"
                        >
                            <template v-slot:item.controls="admins">
                                <v-btn class="mx-1" icon dark small color="red" @click="deleteAdmin(admins.item)">
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
import User from "../../../helper/User"
import TopNav from "../navigationBar"
import BottomFooter from "../BottomFooter"

export default {
    name: "moreadminview",
    created() {
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.hasadminaccess()) {
            this.$router.push({name: 'adminauth'});
        }
        this.fatchalladmin();
        this.checkEmail();
        this.featchUserData();
    },
    data(){
      return {
          user:[],

          admins:[],
          adminsearch:'',
          adminheader:[
              {
                  text: 'id',
                  align: 'start',
                  value: 'id',
              },
              { text: 'Name', value: 'name' },
              { text: 'email', value: 'email' },
              { text: "Action", value: "controls", sortable: false }
          ],
      }
    },
    methods:{
        featchUserData(){
            let id=User.id();
            axios.get('/api/admin/info/'+id)
                .then(res =>{
                    this.user=res.data.user;
                    this.verify=res.data.verify;
                    this.created=res.data.create;
                })
        },
        fatchalladmin(){
            axios.post('/api/admin/all')
            .then(res =>{
                this.admins=res.data;
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
        deleteAdmin(item){
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
                    console.log(item.id)
                    axios.get('/api/admin/remove/'+ item.id)
                        .then(res=>{
                            this.fatchalladmin();
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
    },

}
</script>

<style scoped>

</style>
