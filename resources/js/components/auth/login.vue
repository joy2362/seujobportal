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
                        <v-toolbar-title class="text-uppercase ">Login</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>

                    <v-form>
                        <v-text-field
                            class="mb-5"
                            v-model="email"
                            :error-messages="emailErrors"
                            label="E-mail"
                            prepend-icon="mdi-account"
                            @input="$v.email.$touch()"
                            @blur="$v.email.$touch()"
                        ></v-text-field>
                        <v-text-field
                            v-model="password"
                            :error-messages="passwordErrors"
                            label="Password"
                            :append-icon="value == 'text' ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="() => (value == 'text' ? value='password' :value='text')"
                            :type="value"
                            prepend-icon="mdi-lock"
                            @input="$v.password.$touch()"
                            @blur="$v.password.$touch()"
                        ></v-text-field>

                    </v-form>

                    </v-card-text>
                    <v-card-actions>
                        <v-btn  text small to="/forget">Forget password?</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn  text small to="/reg">Sign up</v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-btn color="primary" outlined @click="login">Login</v-btn>
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
    import { required, email   } from 'vuelidate/lib/validators'
    import User from "../../helper/User";
    export default {
        name: "login",
        created() {
            if (User.loggedIn()){
                this.$router.push({name:'home'});
            }
        },
        validations: {
            email: { required ,email },
            password: { required  },
        },
        data() {
            return {
                email:'',
                password:'',
                value: 'password',
                loading:false,
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
                !this.$v.password.required && errors.push('Password is required')
                return errors
            },
        },
        methods:{
            login(){
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
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    axios.post('/api/auth/login',formData)
                        .then(res =>{
                            this.loading=false
                            User.responseafterlogin(res);
                            this.$router.push({name:'home'});
                        })
                        .catch(error=>{
                            this.loading=false
                            if (error){
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Invalid Email or Password'
                                })
                            }
                        })
                }
            }
        },
    }
</script>

<style scoped>

</style>
