<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>
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
                        <span class="font-weight-light">Setting</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-tabs
                        background-color="white"
                        color="deep-purple accent-4"
                        right
                    >
                        <v-tab>General</v-tab>
                        <v-tab>Password</v-tab>
                        <v-tab v-if="user.user_type === '3' || user.user_type === '4'">Other</v-tab>

                        <v-tab-item >
                            <v-card flat class="mr-12 ml-12">
                                <v-card-text>
                                    <v-form>
                                        <v-text-field
                                            v-model="fullname"
                                            label="Full name"
                                            :error-messages="fullnameErrors"
                                            @input="$v.fullname.$touch()"
                                            @blur="$v.fullname.$touch()"
                                        ></v-text-field>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions >
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" outlined @click="Updatename">Update</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat class="mr-12 ml-12">
                                <v-card-text>
                                    <v-form>
                                        <v-text-field
                                            v-model="oldpassword"
                                            label="Current Password"
                                            type="password"
                                            :error-messages="oldpasswordErrors"
                                            @input="$v.oldpassword.$touch()"
                                            @blur="$v.oldpassword.$touch()"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="newpassword"
                                            label="New Password"
                                            type="password"
                                            :error-messages="newpasswordErrors"
                                            @input="$v.newpassword.$touch()"
                                            @blur="$v.newpassword.$touch()"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="repeatpassword"
                                            label="Repeat Password"
                                            type="password"
                                            :error-messages="repeatpasswordErrors"
                                            @input="$v.repeatpassword.$touch()"
                                            @blur="$v.repeatpassword.$touch()"
                                        ></v-text-field>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions >
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" outlined @click="Updatepass">Update</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat class="mr-12 ml-12">
                                <v-card-text>
                                    <v-form>
                                        <v-file-input
                                            accept=".pdf"
                                            label="Cv"
                                            :error-messages="cvErrors"
                                            @input="$v.cv.$touch()"
                                            @blur="$v.cv.$touch()"
                                            v-model="cv"
                                            show-size
                                            prepend-icon="mdi-file-pdf"
                                        ></v-file-input>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions >
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" outlined @click="changeCv">Update</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-tab-item>
                    </v-tabs>
                </v-card>
            </v-col>
        </v-row>
    </v-container>

    <v-footer>
        <bottom-footer ></bottom-footer>
    </v-footer>

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
import topNavBar from "./layouts/topNavBar";
import bottomFooter from "./layouts/bottomFooter";
import User from "../helper/User";
import {minLength, sameAs, required} from 'vuelidate/lib/validators'


export default {
    name: "setting",
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
        fullname: { required ,minLength: minLength(5) },
        cv: { required },
        oldpassword: { required },
        newpassword: { required,minLength: minLength(6),
            strongPassword(password) {
                return (
                    /[a-z]/.test(password) && // checks for a-z
                    /[0-9]/.test(password) && // checks for 0-9
                    /\W|_/.test(password)  // checks for special char

                );
            }
        },
        repeatpassword:{required,minLength: minLength(6), sameAsPassword: sameAs("newpassword")},

    },

    data(){
        return {
            user:{},
            fullname:'',
            oldpassword:'',
            newpassword:'',
            repeatpassword:'',
            cv:null,
        }
    },
    computed:{
        fullnameErrors(){
            const errors = []
            if (!this.$v.fullname.$dirty) return errors
            !this.$v.fullname.minLength && errors.push('Full name Must Be At least 5 character')
            !this.$v.fullname.required && errors.push('Full name is required')
            return errors
        },

        oldpasswordErrors(){
            const errors = []
            if (!this.$v.oldpassword.$dirty) return errors
            !this.$v.oldpassword.required && errors.push('Current Password is required')
            return errors
        },

        newpasswordErrors () {
            const errors = []
            if (!this.$v.newpassword.$dirty) return errors
            !this.$v.newpassword.minLength && errors.push('Password Must Be At least 6 digit')
            !this.$v.newpassword.strongPassword && errors.push(' passwords need to have a letter, a number, a special character, and be more than 6 characters long.')
            !this.$v.newpassword.required && errors.push('Password is required')
            return errors
        },

        repeatpasswordErrors(){
            const errors = []
            if (!this.$v.repeatpassword.$dirty) return errors
            !this.$v.repeatpassword.minLength && errors.push('Repeat Password Must Be At least 6 digit')
            !this.$v.repeatpassword.sameAsPassword && errors.push('Repeat Password Not Match with Password ')
            !this.$v.repeatpassword.required && errors.push('Repeat password is required')
            return errors
        },
        cvErrors(){
            const errors = []
            if (!this.$v.cv.$dirty) return errors
            !this.$v.cv.required && errors.push('CV is required')
            return errors
        },

    },
    methods:{
        userData(){
            let email=User.email();
            axios.get('/api/user/profile/'+email)
                .then(res =>{
                    this.user=res.data.user;
                    this.fullname=this.user.name;
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
        changeCv(){
            this.loading=true;
            this.$v.cv.$touch()
            if (this.$v.cv.$invalid) {
                this.loading=false;
            }else{
                let email=User.email();
                const formData = new FormData();
                formData.append('cv', this.cv,this.cv.name);
                axios.post('/api/user/setting/cv/'+email,formData)
                    .then(res =>{
                        this.userData();
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
                                error.response.data.errors,
                                'error'
                            )
                        }
                    } )
            }
        },
        Updatepass(){
            this.loading=true;
            this.$v.oldpassword.$touch()
            this.$v.newpassword.$touch()
            this.$v.repeatpassword.$touch()
            if (this.$v.oldpassword.$invalid || this.$v.newpassword.$invalid ||this.$v.repeatpassword   .$invalid) {
                this.loading=false;
            }else{
                let email=User.email();
                const formData = new FormData();
                formData.append('oldpassword', this.oldpassword);
                formData.append('newpassword', this.newpassword);
                axios.post('/api/user/setting/password/'+email,formData)
                    .then(res =>{
                        this.userData();
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.loading=false;
                    })
                    .catch(error => {
                        this.loading=false;
                        if (error.response.data.msg){
                            Swal.fire(
                                'Sorry!',
                                error.response.data.msg,
                                'error'
                            )
                        }
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
        Updatename(){
            this.loading=true;
            this.$v.fullname.$touch()
            if (this.$v.fullname.$invalid) {
                this.loading=false;
            }else{
                let email=User.email();
                const formData = new FormData();
                formData.append('name', this.fullname);
                axios.post('/api/user/setting/name/'+email,formData)
                    .then(res =>{
                        this.userData();
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
                                error.response.data.errors,
                                'error'
                            )
                        }
                    } )
            }
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
