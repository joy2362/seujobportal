<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>
        <v-row>
            <v-col
                md="6"
                cols="12"
                class="location"
            >
                <v-card-text class="white--text">
                    <v-row
                        align="center"
                        class="mx-0"
                    >
                        <v-icon  class="white--text mr-4">
                            mdi-map-marker
                        </v-icon>
                        <div class="my-4 h4 font-weight-black">
                            Address
                        </div>
                    </v-row>
                    <div class="mx-9"> 251/A and 252 Tejgaon Industrial Area Dhaka-1208</div>
                </v-card-text>

                <v-card-text class="white--text">
                    <v-row
                        align="center"
                        class="mx-0"
                    >
                        <v-icon  class="white--text mr-4">
                            mdi-phone
                        </v-icon>
                        <div class="my-4 h4 font-weight-black">
                            Lets Talk
                        </div>
                    </v-row>
                    <div class="mx-9"> 01911781327, 01766348518</div>
                </v-card-text>

                <v-card-text class="white--text">
                    <v-row
                        align="center"
                        class="mx-0"
                    >
                        <v-icon  class="white--text mr-4">
                            mdi-message-text
                        </v-icon>
                        <div class="my-4 h4 font-weight-black">
                            General Support
                        </div>
                    </v-row>
                    <div class="mx-9">  admission@seu.ac.bd</div>
                </v-card-text>

            </v-col>
            <v-col
                md="6"
                cols="12"
            >
                <v-card>
                    <v-toolbar
                        flat
                        dark
                        class="blue lighten-1"
                    >
                        <v-toolbar-title class="text-uppercase" >Send Us A Message</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>

                        <v-form>
                            <v-text-field
                                v-model="name"
                                label="Name"
                                readonly
                            ></v-text-field>
                            <v-text-field
                                v-model="email"
                                label="E-mail"
                                readonly
                            ></v-text-field>
                            <v-textarea
                                v-model="review"
                                label="Write us a message"
                                auto-grow
                                rows="1"
                                :error-messages="reviewErrors"
                                @input="$v.review.$touch()"
                                @blur="$v.review.$touch()"
                            ></v-textarea>

                        </v-form>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="primary" outlined @click="feadback">Send Message</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <bottom-footer ></bottom-footer>
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
import topNavBar from "./layouts/topNavBar";
import bottomFooter from "./layouts/bottomFooter";
import { required  } from 'vuelidate/lib/validators'

export default {
name: "contactUs",
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
    },
    validations: {
        review: { required  },
    },
    data(){
        return {
            user:{},
            email:'',
            name:"",
            review:'',
            loading:false,
        }
    },
    computed:{
        reviewErrors () {
            const errors = []
            if (!this.$v.review.$dirty) return errors
            !this.$v.review.required && errors.push('Message is required')
            return errors
        },
    },
    methods:{
        userData(){
            let email=User.email();
            axios.get('/api/user/info/'+email)
                .then(res=>{
                    this.user=res.data.user;
                    this.email=this.user.email;
                    this.name=this.user.name;
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
        feadback(){
            this.loading=true;
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.loading=false;
            } else {
                const formData = new FormData();
                formData.append('email', User.email());
                formData.append('review', this.review);
                axios.post('/api/feadback/add',formData)
                    .then(res =>{
                        this.loading = false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                    })
                    .catch(error=>{
                        this.loading = false;
                        Toast.fire({
                            icon: 'error',
                            title: 'Something Wrong Try Again'
                        })
                    })
            }

        }
    },
    components:{
        topNavBar,
        bottomFooter,
    },
}
</script>

<style scoped>
.location{
    background: url('/asset/img/others/contact/bg.jpg')no-repeat center center;
    background-size: cover;
}
</style>
