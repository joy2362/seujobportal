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
                            <v-toolbar-title class="text-uppercase ">{{email}} </v-toolbar-title>
                            </v-toolbar>
                        <v-card-text>
                            <v-form>
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
                            </v-form>
                        </v-card-text>
                        <v-card-text class="text-center">
                            <p >Back to
                                <v-btn small text to="/">Login</v-btn>
                            </p>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" outlined :loading="loading" @click="change">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    import { required, sameAs,minLength   } from 'vuelidate/lib/validators'
    import User from "../../helper/User";
    export default {
        name: "reset",
        created() {
            if (User.loggedIn()){
                this.$router.push({name:'home'});
            }
            this.token = this.$route.params.token;
            axios.get('/api/password/find/'+this.token)
                .then(res =>{
                    this.email=res.data;
                })
                .catch(error=>{
                    Swal.fire(
                        'Sorry!',
                        error.response.data.message,
                        'error'
                    )
                    this.$router.push({name:'forget'});
                })
        },
        validations: {
            password: { required,minLength: minLength(6)  },
            repeatpassword:{required,minLength: minLength(6), sameAsPassword: sameAs("password")},
        },
        data() {
            return {
                password:'',
                repeatpassword:'',
                email:'',
                token:'',
                sentmessage:'',
                errormessage:'',
                loading:false,
            }
        },
        computed:{
            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.minLength && errors.push('Password Must Be At least 6 digit')
                !this.$v.password.required && errors.push('Password is required')
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

            change(){
                this.loading=true;
                this.$v.$touch()
                if (this.$v.$invalid) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Enter the email First'
                    })
                } else {
                    const formData = new FormData();
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    formData.append('token', this.token);
                     axios.post('/api/password/reset',formData)
                         .then(res =>{
                             this.loading=false
                             this.sentmessage = res.data.message
                             Swal.fire(
                                 'Congrats!',
                                 this.sentmessage,
                                 'success'
                             )
                             this.$router.push({name:'login'});
                         })
                         .catch(error=>{
                             this.loading=false
                             this.errormessage = error.response.data.message
                             Swal.fire(
                                 'Sorry!',
                                 this.errormessage,
                                 'error'
                             )

                         })
                }
            }
        },

    }
</script>

<style scoped>

</style>
