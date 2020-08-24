<template>
    <v-app>
        <TopNav :user="user"></TopNav>
        <v-container
            class="fill-height"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    md="10"
                    cols="12"
                >
                    <v-card
                    >
                        <v-toolbar
                            flat
                            class="red"
                            dark
                        >
                            <v-toolbar-title class="text-uppercase ">Add New Admin</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-title class="text-uppercase ">
                                <v-btn small text to="/admin/all">All Admin</v-btn>
                            </v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-model="name"
                                            :error-messages="nameErrors"
                                            @input="$v.name.$touch()"
                                            @blur="$v.name.$touch()"
                                            label="Full Name"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="email"
                                            :error-messages="emailErrors"
                                            label="E-mail"
                                            @input="$v.email.$touch()"
                                            @blur="$v.email.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col md="6" cols="12">
                                        <v-text-field
                                            v-model="password"
                                            :error-messages="passwordErrors"
                                            label="Password"
                                            @input="$v.password.$touch()"
                                            @blur="$v.password.$touch()"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col md="6" cols="12">
                                        <v-text-field
                                            v-model="verification"
                                            :error-messages="verificationErrors"
                                            label="Verification code"
                                            @input="$v.verification.$touch()"
                                            @blur="$v.verification.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" outlined  @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-footer>
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
import User from "../../../helper/User";
import TopNav from "../navigationBar";
import BottomFooter from "../BottomFooter";
import {required, minLength, email} from 'vuelidate/lib/validators'
export default {
    name: "add",
    created() {
        if (!User.hasadminaccess()) {
            this.$router.push({name: 'adminauth'});
        }
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        this.checkEmail();
        this.featchUserData();
    },
    validations: {
        email: { required ,email },
        name:{required,minLength:minLength(5)},
        password: { required,minLength: minLength(6),
            strongPassword(password) {
            return (
                /[a-z]/.test(password) && // checks for a-z
                /[0-9]/.test(password) && // checks for 0-9
                /\W|_/.test(password)  // checks for special char

            );
        }
        },
        verification:{ required,minLength: minLength(6),
            strongPassword(password) {
                return (
                    /[a-z]/.test(password) && // checks for a-z
                    /[0-9]/.test(password) && // checks for 0-9
                    /\W|_/.test(password)  // checks for special char

                );
            }
        },
    },
    data(){
        return {
            user:[],
            loading:false,
            verification:'',
            password:'',
            email:'',
            name:'',
        }
    },
    computed:{
        emailErrors () {
            const errors = []
            if (!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Must be valid e-mail')
            !this.$v.email.required && errors.push('E-mail is required')
            return errors
        },
        nameErrors(){
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.name.minLength && errors.push('Full name Must Be At least 5 character')
            !this.$v.name.required && errors.push('Full name required')
            return errors
        },
        passwordErrors(){
            const errors = []
            if (!this.$v.password.$dirty) return errors
            !this.$v.password.minLength && errors.push('Password Must Be At least 6 character')
            !this.$v.password.strongPassword && errors.push(' passwords need to have a letter, a number, a special character, and be more than 6 characters long.')
            !this.$v.password.required && errors.push('Password required')
            return errors
        },
        verificationErrors(){
            const errors = []
            if (!this.$v.verification.$dirty) return errors
            !this.$v.verification.minLength && errors.push('Verification Code Must Be At least 6 character')
            !this.$v.verification.strongPassword && errors.push('Verification Code need to have a letter, a number, a special character, and be more than 6 characters long.')
            !this.$v.verification.required && errors.push('Verification Code required')
            return errors
        },
    },
    methods:{
        featchUserData(){
            let id=User.id();
            axios.get('/api/admin/info/'+id)
                .then(res =>{
                    this.user=res.data.user;
                })
        },
        save(){
            this.loading=true;
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.loading=false;
                Toast.fire({
                    icon: 'error',
                    title: 'Form Not Filled Correctly'
                })
            }else{
                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('verification', this.verification);
                axios.post('/api/auth/admin/signup',formData)
                    .then(res =>{
                        this.loading=false
                        Swal.fire(
                            'Success',
                            res.data.message,
                            'success'
                        )
                        //this.$router.push('/');
                    })
                    .catch(error => {
                        this.loading=false;
                        if (error.response.data.message){
                            Swal.fire(
                                'Sorry!',
                                error.response.data.message,
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
                .then(() =>{

                })
                .catch(()=>{
                    this.$router.push({name:'logout'});
                })
        },
    },
    components:{
        TopNav,BottomFooter,
    },
}
</script>

<style scoped>

</style>
