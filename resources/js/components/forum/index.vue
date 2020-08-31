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
                <v-col
                    md="8"
                >
                    <v-expansion-panels
                        focusable
                        class="mt-4"
                        accordion
                    >
                        <v-expansion-panel class="mb-3">
                            <v-expansion-panel-header>My post</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-card
                                    class="mt-4"
                                    v-for="row in myPost"
                                    :key="row.id"
                                >
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title class="headline">{{row.title}}</v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-card-text>
                                        {{row.description | sortPost}}
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn
                                            text
                                            color="deep-purple accent-4"
                                            @click="viewPost(row.id)"
                                        >
                                            Read More
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel>

                        <v-expansion-panel  class="mb-3">
                            <v-expansion-panel-header>Other post</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-card
                                    class="mt-4"
                                    v-for="row in otherPost"
                                    :key="row.id"
                                >
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title class="headline">{{row.title}}</v-list-item-title>
                                            <v-list-item-subtitle>by {{ row.email }}</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-card-text>
                                        {{row.description | sortPost}}
                                    </v-card-text>
                                    <v-card-actions>

                                        <v-btn
                                            text
                                            color="deep-purple accent-4"
                                            @click="viewPost(row.id)"
                                        >
                                            Read More
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
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
    name: "forum",
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
        this.fatchMyPost();
        this.fatchOtherPost();

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
            myPost:[],
            otherPost:[],
            user:{},
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
        fatchOtherPost(){
            axios.get('/api/forum/other/'+User.email())
                .then(res=>{
                    this.otherPost=res.data.otherPost;
                })
        },
        fatchMyPost(){
            axios.get('/api/forum/mypost/'+User.email())
                .then(res=>{
                    this.myPost=res.data.myPost;
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
                formData.append('email', this.user.email);
                if(this.image){
                    formData.append('image', this.image,this.image.name);
                }
                axios.post('/api/forum/create',formData)
                    .then(res=>{
                        this.loading=false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.fatchMyPost();
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
        viewPost(id){
            this.$root.$router.push({ name: 'singleforum', params: { id } })
        }
    },
    components:{
        topNavBar,
        bottomFooter,
    }


}
</script>

<style scoped>

</style>
