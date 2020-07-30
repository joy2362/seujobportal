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
                                    label="E-mail"
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
                                    v-model="image"
                                    :error-messages="imageErrors"
                                    prepend-icon="mdi-camera"
                                    @input="$v.image.$touch()"
                                    @blur="$v.image.$touch()"
                                    accept="image/*" label="Profile Picture"
                                ></v-file-input>
                                <v-select
                                    v-model="selectedfiled"
                                    item-text="name"
                                    item-value="id"
                                    :items="category"
                                    chips
                                    label="Interest Fields"
                                    multiple
                                    prepend-icon="mdi-playlist-plus"
                                    @input="$v.selectedfiled.$touch()"
                                    @blur="$v.selectedfiled.$touch()"
                                    :error-messages="selectedfiledErrors"
                                ></v-select>
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
    </v-app>
</template>

<script>
    import { required, email ,sameAs,minLength   } from 'vuelidate/lib/validators'
    import User from "../../helper/User";
    export default {
        name: "alumnireg",
        created() {
            if (User.loggedIn()){
                this.$router.push({name:'home'});
            }
            this.fatchdata();
        },
        validations: {
            email: { required ,email },
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
            image:{required},
            selectedfiled:{required},
            cv:{required},

        },
        data() {
            return {
                email:'',
                password:'',
                name:'',
                repeatpassword:'',
                image:null,
                selectedfiled: [],
                cv:null,
                category: [],
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
            imageErrors(){
                const errors = []
                if (!this.$v.image.$dirty) return errors
                !this.$v.image.required && errors.push('Profile image is required')
                return errors
            },
            selectedfiledErrors(){
                const errors = []
                if (!this.$v.selectedfiled.$dirty) return errors
                !this.$v.selectedfiled.required && errors.push('Interest field is required')
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
            fatchdata(){
                axios.get('/api/admin/category/index')
                .then(res =>{
                    this.category=res.data;
                })
            },
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
                    for (var i = 0; i < this.selectedfiled.length; i++) {
                        formData.append('interestfield[]', this.selectedfiled[i]);
                    }
                    formData.append('cv', this.cv,this.cv.name);

                    axios.post('/api/auth/alumni/signup',formData)
                        .then(res =>{
                            this.loading=false
                            Toast.fire({
                                icon: 'success',
                                title: 'Registation Complete'
                            })
                            this.$router.push('/');
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
            }
        },
    }
</script>

<style scoped>

</style>
