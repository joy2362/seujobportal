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
                            <v-toolbar-title class="text-uppercase ">Veify Email</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <p class="body-2">Please Verify your email before continue.Verification Email Already send to your e-mail.
                                <v-btn
                                    small
                                    text
                                    @click="emailsendagain"
                                >Resend</v-btn>
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    import User from "../../helper/User";

    export default {
        name: "resendEmailverificatin",
        created() {
            if (User.isverifiedAccount()){
                this.$router.push({name:'home'});
            }
            this.resendemail();
        },
        data(){
            return{
                email:"",
                loading:true,
            }
        },
        methods:{
            emailsendagain(){
                this.loading=true;
                const formData = new FormData();
                formData.append('email', this.email);
                axios.post('/api/email/resend',formData)
                .then(res =>{
                    Swal.fire(
                        'Success!',
                        res.data.msg,
                        'success'
                    )
                    this.loading=false;
                })
                .catch(error=>{
                    if (error){
                        Swal.fire(
                            'Sorry!',
                            error.response.data.message,
                            'error'
                        )
                    }
                    this.loading=false;
                })
            },
            resendemail(){
                this.email=User.email();
                const formData = new FormData();
                formData.append('email', this.email);
                axios.post('/api/email/resend',formData)
                .then(res =>{
                    Swal.fire(
                        'Success!',
                        res.data.msg,
                        'success'
                    )
                    User.logout();
                    this.loading=false;
                })
                .catch(error=>{
                    if (error){
                        Swal.fire(
                            'Sorry!',
                            error.response.data.message,
                            'error'
                        )
                    }
                    this.loading=false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
