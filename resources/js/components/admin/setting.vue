<template>
<v-app>
    <Navbars :user="user"></Navbars>
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
                        <v-tab>Verification</v-tab>

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
                                        <v-text-field
                                            v-model="oldvalidation"
                                            label="Current Validation code"
                                            type="password"
                                            :error-messages="oldvalidationErrors"
                                            @input="$v.oldvalidation.$touch()"
                                            @blur="$v.oldvalidation.$touch()"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="newvalidation"
                                            label="New Validation code"
                                            type="password"
                                            :error-messages="newvalidationErrors"
                                            @input="$v.newvalidation.$touch()"
                                            @blur="$v.newvalidation.$touch()"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="repeatvalidation"
                                            label="Repeat Validation code"
                                            type="password"
                                            :error-messages="repeatvalidationErrors"
                                            @input="$v.repeatvalidation.$touch()"
                                            @blur="$v.repeatvalidation.$touch()"
                                        ></v-text-field>

                                    </v-form>
                                </v-card-text>
                                <v-card-actions >
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" outlined @click="changevalidation">Update</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-tab-item>
                    </v-tabs>
                </v-card>
            </v-col>
        </v-row>

    </v-container>

    <v-footer fixed>
        <BottomFooter></BottomFooter>
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
import User from "../../helper/User";
import Navbars from "./navigationBar";
import BottomFooter from "./BottomFooter";
import {minLength, sameAs, required} from 'vuelidate/lib/validators'

export default {
    name: "setting",
    created() {
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.hasadminaccess()) {
            this.$router.push({name: 'adminauth'});
        }
        this.checkEmail();
        this.featchUserData();
    },
    validations: {
        fullname: { required ,minLength: minLength(5) },
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

        oldvalidation: { required },
        newvalidation: { required,minLength: minLength(6),
            strongPassword(password) {
                return (
                    /[a-z]/.test(password) && // checks for a-z
                    /[0-9]/.test(password) && // checks for 0-9
                    /\W|_/.test(password)  // checks for special char

                );
            }
        },
        repeatvalidation:{required,minLength: minLength(6), sameAsPassword: sameAs("newvalidation")},

    },
    data(){
        return {
            loading:false,
            user:[],
            fullname:'',
            oldpassword:'',
            newpassword:'',
            repeatpassword:'',
            oldvalidation:'',
            newvalidation:'',
            repeatvalidation:'',
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
        oldvalidationErrors(){
            const errors = []
            if (!this.$v.oldvalidation.$dirty) return errors
            !this.$v.oldvalidation.required && errors.push('Current Validation code is required')
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
        newvalidationErrors () {
            const errors = []
            if (!this.$v.newvalidation.$dirty) return errors
            !this.$v.newvalidation.minLength && errors.push('Validation Must Be At least 6 digit')
            !this.$v.newvalidation.strongPassword && errors.push(' Validation need to have a letter, a number, a special character, and be more than 6 characters long.')
            !this.$v.newvalidation.required && errors.push('Validation is required')
            return errors
        },
        repeatvalidationErrors(){
            const errors = []
            if (!this.$v.repeatvalidation.$dirty) return errors
            !this.$v.repeatvalidation.minLength && errors.push('Repeat Validation Must Be At least 6 digit')
            !this.$v.repeatvalidation.sameAsPassword && errors.push('Repeat Validation Not Match with Password ')
            !this.$v.repeatvalidation.required && errors.push('Repeat Validation is required')
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
    },
    methods:{
        featchUserData(){
            let id=User.id();
            axios.get('/api/admin/info/'+id)
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
        Updatename(){
            this.loading=true;
            this.$v.fullname.$touch()
            if (this.$v.fullname.$invalid) {
                this.loading=false;
            }else{
                let id=User.id();
                const formData = new FormData();
                formData.append('name', this.fullname);
                axios.post('/api/admin/setting/name/'+id,formData)
                    .then(res =>{
                        this.featchUserData();
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
                let id=User.id();
                const formData = new FormData();
                formData.append('oldpassword', this.oldpassword);
                formData.append('newpassword', this.newpassword);
                axios.post('/api/admin/setting/password/'+id,formData)
                    .then(res =>{
                        this.featchUserData();
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
        changevalidation(){
            this.loading=true;
            this.$v.oldvalidation.$touch()
            this.$v.newvalidation.$touch()
            this.$v.repeatvalidation.$touch()
            if (this.$v.oldvalidation.$invalid || this.$v.newvalidation.$invalid ||this.$v.repeatvalidation.$invalid) {
                this.loading=false;
            }else{
                let id=User.id();
                const formData = new FormData();
                formData.append('oldvalidation', this.oldvalidation);
                formData.append('newvalidation', this.newvalidation);
                axios.post('/api/admin/setting/validation/'+id,formData)
                    .then(res =>{
                        this.featchUserData();
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

        }
    },
    components:{
        Navbars,BottomFooter
    },
}
</script>

<style scoped>

</style>
