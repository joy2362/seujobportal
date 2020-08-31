<template>
    <v-app>
        <topNavBar :user="user"></topNavBar>
        <v-container>
            <v-row
                align="center"
                justify="center">
                <v-col
                    md="4"
                    cols="12"
                >
                    <v-card>
                        <v-list-item >
                            <v-list-item-content>
                                <v-list-item-title class="headline">What's on your mind </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                    v-model="title"
                                    label="Title"
                                    :error-messages="titleErrors"
                                    @input="$v.title.$touch()"
                                    @blur="$v.title.$touch()"
                                ></v-text-field>
                                <v-textarea
                                    v-model="detail"
                                    auto-grow
                                    filled
                                    label="Details"
                                    rows="3"
                                    :error-messages="detailErrors"
                                    @input="$v.detail.$touch()"
                                    @blur="$v.detail.$touch()"
                                ></v-textarea>
                                <v-file-input
                                    accept="image/png, image/jpeg, image/bmp"
                                    prepend-icon="mdi-camera"
                                    label="Add Image"
                                    v-model="image"
                                ></v-file-input>
                            </v-form>
                            <v-card-actions>
                                <v-btn color="primary" @click="post">Post</v-btn>
                            </v-card-actions>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <bottom-footer ></bottom-footer>
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
import User from "../../helper/User";
import topNavBar from "../layouts/topNavBar"
import bottomFooter from "../layouts/bottomFooter"
import {required, minLength} from 'vuelidate/lib/validators'
export default {
name: "edit",
    created() {
        if (! User.loggedIn()){
            this.$router.push({name:'login'});
        }
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.isverifiedAccount()){
            this.$router.push({name:'emailverify'});
        }
        this.userData();
        this.checkEmail();
        this.fatchPost();

    },
    validations: {
        title: { required ,minLength: minLength(10) },
        detail: { required,minLength: minLength(20)  },
    },
    data(){
        return {
            loading:false,
            title:'',
            detail:'',
            image:null,
            user:{},
            post_id:this.$route.params.id,
        }
    },
    computed:{
        titleErrors () {
            const errors = []
            if (!this.$v.title.$dirty) return errors
            !this.$v.title.minLength && errors.push('Title Must have 10 character')
            !this.$v.title.required && errors.push('Title is required')
            return errors
        },
        detailErrors () {
            const errors = []
            if (!this.$v.detail.$dirty) return errors
            !this.$v.detail.minLength && errors.push('Post Details Must have 20 character')
            !this.$v.detail.required && errors.push('Post Details is required')
            return errors
        },
    },
    methods:{
        userData(){
            let email=User.email();
            axios.get('/api/user/info/'+email)
                .then(res=>{
                    this.user=res.data.user;
                })
        },
        fatchPost(){
            axios.get('/api/forum/show/'+this.post_id)
                .then(res=>{
                    console.log(res.data.post)
                    this.title=res.data.post.title;
                    this.detail=res.data.post.description;
                })
        },

        checkEmail(){
            const formData = new FormData();
            formData.append('email', User.email());
            formData.append('type', User.permission());
            axios.post('/api/auth/check/email',formData)
                .then(res =>{

                })
                .catch(error=>{
                    this.$router.push({name:'logout'});
                })
        },
        post(){
            this.loading=true;
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.loading=false;
            }else{
                const formData = new FormData();
                formData.append('title', this.title);
                formData.append('detail', this.detail);

                if(this.image){
                    formData.append('image', this.image,this.image.name);
                }

                axios.post('/api/forum/update/'+this.post_id,formData)
                    .then(res=>{
                        this.loading=false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.$router.go(-1);
                    })
                    .catch(error=>{
                        this.loading=false;
                        if (error.response.data.errors){
                            Swal.fire(
                                'Sorry!',
                                error.response.data.message,
                                'error'
                            )
                        }
                    })
            }
        },
    },
    components:{
        topNavBar,
        bottomFooter,
    }
}
</script>

<style scoped>

</style>
