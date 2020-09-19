<template>
    <v-app>
        <v-container
            class="fill-height"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    md="4"
                    cols="12"
                >
                    <v-card>
                        <v-toolbar
                            flat
                            dark
                            class="blue lighten-1"
                        >
                            <v-toolbar-title class="text-uppercase ">Sign Up</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                    v-model="name"
                                    prepend-icon="mdi-account"
                                    label="Full name"
                                    required
                                    :error-messages="nameErrors"
                                    @input="$v.name.$touch()"
                                    @blur="$v.name.$touch()"
                                ></v-text-field>
                                <v-text-field
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    label="University E-mail"
                                    prepend-icon="mdi-email"
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                ></v-text-field>
                                <v-text-field
                                    type="password"
                                    v-model="password"
                                    :error-messages="passwordErrors"
                                    label="Password"
                                    prepend-icon="mdi-lock"
                                    @input="$v.password.$touch()"
                                    @blur="$v.password.$touch()"
                                ></v-text-field>
                                <v-text-field
                                    type="password"
                                    v-model="repeatpassword"
                                    :error-messages="repeatpasswordErrors"
                                    label="Repeat Password"
                                    prepend-icon="mdi-lock"
                                    @input="$v.repeatpassword.$touch()"
                                    @blur="$v.repeatpassword.$touch()"
                                ></v-text-field>
                                <v-file-input
                                    v-model="cv"
                                    :error-messages="cvErrors"
                                    prepend-icon="mdi-file-pdf"
                                    @input="$v.cv.$touch()"
                                    @blur="$v.cv.$touch()"
                                    accept=".pdf"
                                    label="CV"
                                ></v-file-input>
                            </v-form>
                        </v-card-text>

                        <v-card-text class="text-center">
                            <p >Already have account?
                                <v-btn small text to="/">Login</v-btn>
                                Or
                                <v-btn small text to="/reg">Back</v-btn>
                            </p>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" outlined @click="reg">Sign Up</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
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
    import { required, email ,sameAs,minLength   } from 'vuelidate/lib/validators'
    import User from "../../helper/User";
    export default {
        name: "studentreg",
        created() {
            if (User.loggedIn()){
                this.$router.push({name:'home'});
            }
            this.fatchdata();
        },
        validations: {
            email: { required ,email  },
            password: { required,minLength: minLength(6),
                strongPassword(password) {
                    return (
                        /[a-z]/.test(password) && // checks for a-z
                        /[0-9]/.test(password) && // checks for 0-9
                        /\W|_/.test(password)  // checks for special char

                    );
                }
            },
            name:{required,minLength:minLength(5)},
            repeatpassword:{required,minLength: minLength(6), sameAsPassword: sameAs("password")},
            cv:{required},

        },
        data() {
            return {
                email:'',
                password:'',
                name:'',
                repeatpassword:'',
                cv:null,
                loading:false,
            }
        },
        computed:{
            emailErrors () {
                const errors = []
                if (!this.$v.email.$dirty) return errors
                !this.$v.email.email && errors.push('Must be Your University Email')
                !this.$v.email.required && errors.push('E-mail is required')
                return errors
            },
            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.minLength && errors.push('Password Must Be 6 characters long')
                !this.$v.password.strongPassword && errors.push(' passwords need to have a letter, a number, a special character, and be more than 6 characters long.')
                !this.$v.password.required && errors.push('Password is required')
                return errors
            },
            nameErrors(){
                const errors = []
                if (!this.$v.name.$dirty) return errors
                !this.$v.name.minLength && errors.push('Full name Must Be At least 5 character')
                !this.$v.name.required && errors.push('Full name is required')
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
                !this.$v.cv.required && errors.push('Interest field is required')
                return errors
            }
        },
        methods:{
            reg(){
                this.loading=true;
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.loading=false;
                    Toast.fire({
                        icon: 'error',
                        title: 'Form Not Filled Correctly'
                    })
                } else {
                    const formData = new FormData();
                    formData.append('name', this.name);
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    formData.append('cv', this.cv,this.cv.name);

                    axios.post('/api/auth/student/signup',formData)
                        .then(res =>{
                            this.loading=false
                            Swal.fire(
                                'Registation Complete!',
                                res.data.message,
                                'success'
                            )
                            this.$router.push('/');
                        })
                        .catch(error => {
                            this.loading=false;
                            if (error.response.data.errors.email){
                                Swal.fire(
                                    'Sorry!',
                                    error.response.data.errors.email[0],
                                    'error'
                                )
                            }else{
                                Swal.fire(
                                    'Sorry!',
                                    error.response.data.message,
                                    'error'
                                )
                            }
                        } )
                }
            }
        },
    }
</script>

<style scoped>

</style>
