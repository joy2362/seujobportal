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
                    >
                        <v-toolbar
                            flat
                            dark
                            class="blue lighten-1"
                        >
                            <v-toolbar-title class="text-uppercase ">Admin Access </v-toolbar-title>
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
                            </v-form>
                        </v-card-text>
                        <v-card-text class="text-center">
                              <v-btn small text to="/home">Go Back</v-btn>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" outlined @click="verify">Verify</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    import User from "../../helper/User";
    import {email, required} from 'vuelidate/lib/validators'
    export default {
        name: "index",
        created() {
        if (! User.loggedIn()){
            this.$router.push({name:'login'});
        }
        if (! User.isAdmin()){
            this.$router.push({name:'home'});
        }
            if (User.hasadminaccess()) {
                this.$router.push({name: 'adminhome'});
            }

    },
    validations: {
        password: { required  },
    },
    data(){
        return{
            user:{
                email:User.email(),
            },
            password:'',
        }
    },
        computed:{
            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.required && errors.push('Password is required')
                return errors
            },
        },
        methods:{
            verify(){
                this.$v.$touch()
                if (this.$v.$invalid) {
                    this.loading=false;
                    Toast.fire({
                        icon: 'error',
                        title: 'Enter Password first'
                    })
                } else {
                    const formData = new FormData();
                    formData.append('email', this.user.email);
                    formData.append('password', this.password);

                    axios.post('/api/admin/verify',formData)
                        .then(res =>{
                            User.responseafteradminverify()
                            Swal.fire(
                                'Success!',
                                res.data.message,
                                'success'
                            )
                            this.$router.push({name:'adminhome'});
                        })
                        .catch(error => {
                            if (error.response.data.message){
                                Swal.fire(
                                    'Sorry!',
                                    error.response.data.message,
                                    'error'
                                )
                            }0
                        } )
                }
            }
        }
    }
</script>

<style scoped>

</style>
