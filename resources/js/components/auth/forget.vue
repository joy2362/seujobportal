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
                    <v-card
                        :loading="loading"
                    >
                        <v-toolbar
                            flat
                            dark
                            class="blue lighten-1"
                        >
                            <v-toolbar-title class="text-uppercase ">Forget Password</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    label="E-mail"
                                    prepend-icon="mdi-account"
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-text class="text-center">
                            <p >Back to
                                <v-btn small text to="/">Login</v-btn>
                            </p>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" :loading="loading" outlined @click="forget">Submit</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    import { required, email   } from 'vuelidate/lib/validators'
    import User from "../../helper/User";
    export default {
        name: "forget",
        created() {
            if (User.loggedIn()){
                this.$router.push({name:'home'});
            }
        },
        validations: {
            email: { required ,email },
        },
        data() {
            return {
                email:'',
                sentmessage:'',
                errormessage:'',
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
        },
        methods:{
            forget(){
                this.loading=true;
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.loading=false;
                    Toast.fire({
                        icon: 'error',
                        title: 'Enter the email First'
                    })
                } else {
                    const formData = new FormData();
                    formData.append('email', this.email);
                    axios.post('/api/password/create',formData)
                        .then(res =>{
                            this.loading=false
                            this.sentmessage=res.data.message;
                            Swal.fire(
                                'Success!',
                                this.sentmessage,
                                'success'
                            )
                        })
                        .catch(error=>{
                            this.loading=false;
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
