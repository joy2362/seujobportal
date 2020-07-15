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
                                    v-model="fullname"
                                    prepend-icon="mdi-account"
                                    label="Full name"
                                    required
                                    :error-messages="fullnameErrors"
                                    @input="$v.fullname.$touch()"
                                    @blur="$v.fullname.$touch()"
                                ></v-text-field>
                                <v-text-field
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    label="E-mail"
                                    prepend-icon="mdi-email"
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                ></v-text-field>
                                <v-text-field
                                    v-model="password"
                                    :error-messages="passwordErrors"
                                    label="Password"
                                    prepend-icon="mdi-lock"
                                    @input="$v.password.$touch()"
                                    @blur="$v.password.$touch()"
                                ></v-text-field>
                                <v-text-field
                                    v-model="repeatpassword"
                                    :error-messages="repeatpasswordErrors"
                                    label="Repeat Password"
                                    prepend-icon="mdi-lock"
                                    @input="$v.repeatpassword.$touch()"
                                    @blur="$v.repeatpassword.$touch()"
                                ></v-text-field>
                                <v-file-input
                                    v-model="image"
                                    :error-messages="imageErrors"
                                    prepend-icon="mdi-camera"
                                    @input="$v.image.$touch()"
                                    @blur="$v.image.$touch()"
                                    accept="image/*" label="Profile Picture"
                                ></v-file-input>
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
        name: "alumnireg",
        validations: {
            email: { required ,email },
            password: { required,minLength: minLength(6)  },
            fullname:{required,minLength:minLength(5)},
            repeatpassword:{required,minLength: minLength(6), sameAsPassword: sameAs("password")},
            image:{required},
        },
        data() {
            return {
                email:'',
                password:'',
                fullname:'',
                repeatpassword:'',
                image:null,
                form:{
                    fullname:'',
                    email:'',
                    password:'',
                    image:'',
                }
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
                if (!this.$v.fullname.$dirty) return errors
                !this.$v.fullname.minLength && errors.push('Full name Must Be At least 5 character')
                !this.$v.fullname.required && errors.push('Full name is required')
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
                !this.$v.image.required && errors.push('Repeat password is required')
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
                    this.form.fullname=this.fullname;
                    this.form.email=this.email;
                    this.form.password=this.password;
                    this.form.image=this.image;
                    console.log(this.form)
                }
            }
        },
    }
</script>

<style scoped>

</style>
