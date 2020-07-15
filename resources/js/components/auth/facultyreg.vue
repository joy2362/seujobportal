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
                            <v-form >
                                <v-text-field
                                    v-model="name"
                                    prepend-icon="mdi-account"
                                    label="Full name"
                                    required
                                    :error-messages="fullnameErrors"
                                    @input="$v.name.$touch()"
                                    @blur="$v.name.$touch()"
                                ></v-text-field>
                                <small class="text-danger" v-if="errorName">{{errorName}}</small>
                                <v-text-field
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    label="E-mail"
                                    prepend-icon="mdi-email"
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                ></v-text-field>
                                <small class="text-danger" v-if="errorEmail">{{errorEmail}}</small>
                                <v-text-field
                                    type="password"
                                    v-model="password"
                                    :error-messages="passwordErrors"
                                    label="Password"
                                    prepend-icon="mdi-lock"
                                    @input="$v.password.$touch()"
                                    @blur="$v.password.$touch()"
                                ></v-text-field>
                                <small class="text-danger" v-if="errorPass">{{errorPass}}</small>
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
                                   v-model="image"
                                   accept="image/*"
                                   label="Profile Image"
                                   prepend-icon="mdi-camera"
                                   >
                               </v-file-input>
                                <small class="text-danger" v-if="errorImage">{{errorImage}}</small>
                            </v-form>
                        </v-card-text>

                        <v-card-text class="text-center">
                            <p >Already have account?
                                <v-btn small text to="/">Login</v-btn>
                            </p>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" outlined @click="reg">Sign Up</v-btn>
                        </v-card-actions>

                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    import { required, email ,sameAs,minLength   } from 'vuelidate/lib/validators'
    export default {
        name: "facultyreg",
        validations: {
            email: { required ,email },
            password: { required,minLength: minLength(6)  },
            name:{required,minLength:minLength(5)},
            repeatpassword:{required,minLength: minLength(6), sameAsPassword: sameAs("password")},
            image:{required},
        },
        data() {
            return {
                email:'',
                password:'',
                name:'',
                repeatpassword:'',
                image:null,
                errorEmail:'',
                errorPass:'',
                errorName:'',
                errorImage:'',


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
            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.minLength && errors.push('Password Must Be At least 6 digit')
                !this.$v.password.required && errors.push('Password is required')
                return errors
            },
            fullnameErrors(){
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
            imageErrors(){
                const errors = []
                if (!this.$v.image.$dirty) return errors
                !this.$v.image.required && errors.push('Profile image is required')
                return errors
            }
        },
        methods:{
            reg(){
                this.$v.$touch()
                if (this.$v.$invalid) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Form Not Filled Correctly'
                    })
                } else {

                    const formData = new FormData();
                    formData.append('image', this.image, this.image.name);
                    formData.append('name', this.name);
                    formData.append('email', this.email);
                    formData.append('password', this.password);

                    axios.post('/api/auth/teacher/signup',formData)
                        .then(data =>{
                            console.log(data)
                        })

                    .catch(error => {
                            if (error.response.data.errors.email){
                                this.errorEmail=error.response.data.errors.email[0];
                            }else{
                                this.errorEmail="";
                            }
                            if(error.response.data.errors.password){
                                this.errorPass=error.response.data.errors.password[0];
                            }else{
                                this.errorPass="";
                            }
                            if(error.response.data.errors.name){
                                this.errorName=error.response.data.errors.name[0];
                            }else{
                                this.errorName="";
                            }
                            if(error.response.data.errors.image){
                                this.errorImage=error.response.data.errors.image[0];
                            }else{
                                this.errorImage="";
                            }
                        } )

                }
            }
        },
    }
</script>

<style scoped>

</style>
