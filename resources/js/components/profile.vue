<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container
    >
        <v-row
            align="center"
            justify="center"
        >
            <v-col
                md="8"
                cols="12"
            >
                <v-card>
                    <v-card-title  class="justify-center ">
                        <span class="font-weight-light">User Profile</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-row>
                            <v-col
                                cols="12"
                                md="5"
                            >
                                <v-hover v-slot:default="{ hover }">
                                    <v-img
                                        class="rounded-circle"
                                        height="250"
                                        width="250"
                                        :src="'/'+user.pro_pic"
                                    >
                                        <v-expand-transition>
                                            <v-btn
                                                v-if="hover"
                                                class="d-flex dark  v-card--reveal "
                                                style="height:20%;"
                                                @click="edit=!edit"
                                            >
                                                change image
                                            </v-btn>
                                        </v-expand-transition>
                                    </v-img>
                                </v-hover>
                            </v-col>
                            <v-divider
                                class="mx-4"
                                inset
                                vertical
                            ></v-divider>
                            <v-col
                                cols="12"
                                md="6"
                            >
                                <v-simple-table >
                                    <template v-slot:default>

                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{user.name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{user.email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email Verify </td>
                                            <td>{{verify}}</td>
                                        </tr>
                                        <tr>
                                            <td>Account created </td>
                                            <td>{{created}}</td>
                                        </tr>
                                        <tr>
                                            <td>User Type </td>
                                            <td v-if="user.user_type ===  '2'">Faculty</td>
                                            <td v-if="user.user_type ===  '4'">Student</td>
                                            <td v-if="user.user_type ===  '3'">Alumni</td>
                                        </tr>
                                        </tbody>

                                    </template>
                                </v-simple-table>

                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>

        </v-row>

    </v-container>
    <v-footer >
        <bottom-footer ></bottom-footer>
    </v-footer>
    <v-dialog v-model="edit"  max-width="600px">
        <v-card>
            <v-toolbar
                flat
                dark
                class="red lighten-1"
            >
                <v-toolbar-title class="text-uppercase ">Change Image</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <v-form>
                    <v-file-input
                        v-model="newImage"
                        accept="image/*"
                        label="Image"
                        prepend-icon="mdi-cloud-upload"
                        :error-messages="newImageErrors"
                        @input="$v.newImage.$touch()"
                        @blur="$v.newImage.$touch()"
                    >
                    </v-file-input>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="edit = false">Close</v-btn>
                <v-btn color="blue darken-1" text @click="Update">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
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
import User from "../helper/User";
import {required} from "vuelidate/lib/validators";
import topNavBar from "./layouts/topNavBar"
import bottomFooter from "./layouts/bottomFooter"

export default {
name: "profile",
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
        this.featchUserData();
    },
    validations: {
        newImage:{required},
    },
    data(){
        return {
            loading:false,
            edit:false,
            user:[],
            verify:'',
            created:'',
            newImage:null,
        }
    },
    methods:{
        featchUserData(){
            let email=User.email();
            axios.get('/api/user/profile/'+email)
                .then(res =>{
                    this.user=res.data.user;
                    this.verify=res.data.verify;
                    this.created=res.data.create;
                })
        },
        Update(){
            this.loading=true;
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.loading=false;
                Toast.fire({
                    icon: 'error',
                    title: 'Select a image first!!'
                })
            }else{
                let email=User.email();
                const formData = new FormData();
                formData.append('image', this.newImage,this.newImage.name);
                axios.post('/api/user/profile/image/'+email,formData)
                    .then(res =>{
                        this.featchUserData();
                        this.edit = false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.loading=false;
                    })
                    .catch(error => {
                        this.loading=false;
                        if (error.response.data.errors){
                            Swal.fire(
                                'Sorry!',
                                error.response.data.errors.image[0],
                                'error'
                            )
                        }
                    } )
            }

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
.v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: .7;
    position: absolute;
    width: 100%;
}
</style>
