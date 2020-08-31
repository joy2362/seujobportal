<template>
    <v-app>
        <topNavBar :user="user"></topNavBar>
        <v-container>
            <v-row
                align="center"
                justify="center">

                <v-col
                    md="6"
                    cols="12"
                >
                    <v-card>
                        <v-list-item >
                            <v-list-item-content>
                                <v-list-item-title class="headline">{{post.title}} </v-list-item-title>
                                    <v-list-item-subtitle class="mt-4" v-if="post.email == user.email">
                                        <v-btn small class="primary"@click="editPost">
                                            EDIT
                                        </v-btn>
                                        <v-btn small class="error" @click="deletePost">
                                            DELETE
                                        </v-btn>
                                    </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            {{post.description}}
                        </v-card-text>
                        <v-card-text v-if="post.image">
                            <v-img :src="'/'+post.image" height="250" width="100%"></v-img>
                        </v-card-text>
                        <v-card-text>
                            Comments
                            <v-form>
                                <v-textarea
                                    v-model="comment"
                                    filled
                                    rows="1"
                                    label="comment"
                                    auto-grow
                                    :error-messages="commentErrors"
                                    @input="$v.comment.$touch()"
                                    @blur="$v.comment.$touch()"
                                ></v-textarea>
                                <v-btn class="primary"text small @click="newComment">Add comment</v-btn>
                            </v-form>
                        </v-card-text>
                        <v-card-text v-for="row in comments" :key="row.id"  >
                            <v-list-item >
                                <v-list-item-content>
                                    <v-list-item-title class="body">{{ row.comment }}</v-list-item-title>
                                    <v-list-item-subtitle>by {{ row.email }}</v-list-item-subtitle>
                                    <v-list-item-subtitle v-if="row.email == user.email">
                                        <v-btn small class="primary"@click="editComment(row)">
                                            EDIT
                                        </v-btn>
                                        <v-btn small class="error" @click="deleteComment(row.id)">
                                            DELETE
                                        </v-btn>
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
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
        <v-dialog v-model="edit"  max-width="600px">
            <v-card>
                <v-toolbar
                    flat
                    dark
                    class="red lighten-1"
                >
                    <v-toolbar-title class="text-uppercase ">Edit Comment</v-toolbar-title>
                </v-toolbar>
                <v-card-text>

                    <v-form>
                        <v-textarea
                        v-model="commentEdit"
                        filled
                        rows="1"
                        label="comment"
                        auto-grow
                        :error-messages="commentEditErrors"
                        @input="$v.commentEdit.$touch()"
                        @blur="$v.commentEdit.$touch()"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="edit = false">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="updateComment">Update</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
import User from "../../helper/User";
import topNavBar from "../layouts/topNavBar"
import bottomFooter from "../layouts/bottomFooter"
import { required} from 'vuelidate/lib/validators'
export default {
    name: "viewPost",
    created() {
        if (! User.loggedIn()){
            this.$router.push({name:'logout'});
        }
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.isverifiedAccount()){
            this.$router.push({name:'emailverify'});
        }
        this.checkEmail();
        this.userData();
        this.fatchPost();
        this.fatchComments();
    },
    validations: {
        comment:{required},
        commentEdit:{required}
    },
    data(){
        return {
            edit:false,
            loading:false,
            user:{},
            post:[],
            comment:'',
            comments:{},
            post_id:this.$route.params.id,
            commentEdit:'',
            editId:'',
        }
    },
    computed:{

        commentErrors(){
            const errors = []
            if (!this.$v.comment.$dirty) return errors
            !this.$v.comment.required && errors.push('comment required')
            return errors
        },
        commentEditErrors(){
            const errors = []
            if (!this.$v.commentEdit.$dirty) return errors
            !this.$v.commentEdit.required && errors.push('comment required')
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
        fatchPost(){
             //this.post_id = this.$route.params.id;
            axios.get('/api/forum/show/'+this.post_id)
            .then(res=>{
                this.post=res.data.post;
            })
        },
        newComment(){
            this.loading=true;
            this.$v.comment.$touch()
            if (this.$v.comment.$invalid) {
                this.loading=false;
            }else{
                const formData = new FormData();
                formData.append('email', this.user.email);
                formData.append('post_id', this.post_id);
                formData.append('comment', this.comment);
                axios.post('/api/comment/new',formData)
                .then(res=>{
                    this.loading=false;
                    this.fatchComments();
                    Toast.fire({
                        icon: 'success',
                        title: 'Comment Added'
                    })
                })
                .catch(error =>{
                    this.loading=false;
                    Toast.fire({
                        icon: 'error',
                        title: 'Something wrong try again'
                    })
                })
            }

        },
        fatchComments(){
            axios.get('/api/comment/all/'+this.post_id)
            .then(res=>{
                this.comments=res.data.comments;
            })
        },
        deletePost(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios.get('/api/forum/delete/'+this.post_id)
                        .then(res=>{
                            Swal.fire(
                                'Success',
                                res.data.msg,
                                'success'
                            )
                            this.$router.go(-1);
                        })
                        .catch(error => {
                            Swal.fire(
                                'Sorry!',
                                'Something wrong try again.',
                                'error'
                            )
                        })
                }
            })
        },
        editPost(){
            this.$router.push('/forum/edit/'+this.post_id);
        },
        deleteComment(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios.get('/api/comment/delete/'+id)
                        .then(res=>{
                            Swal.fire(
                                'Success',
                                res.data.msg,
                                'success'
                            )
                            this.fatchComments();
                        })
                        .catch(error => {
                            Swal.fire(
                                'Sorry!',
                                'Something wrong try again.',
                                'error'
                            )
                        })
                }
            })
        },
        editComment(comment){
            this.commentEdit=comment.comment;
            this.edit=true;
            this.editId=comment.id;
        },
        updateComment(){
            this.loading=true;
            this.$v.commentEdit.$touch()
            if (this.$v.commentEdit.$invalid) {
                this.loading=false;
            }else{
                const formData = new FormData();
                formData.append('comment', this.commentEdit);
                axios.post('/api/comment/update/'+this.editId,formData)
                    .then(res=>{
                        this.loading=false;
                        this.fatchComments();
                        Toast.fire({
                            icon: 'success',
                            title: 'Comment Edited'
                        })
                        this.edit=false;
                    })
                    .catch(error =>{
                        this.loading=false;
                        Toast.fire({
                            icon: 'error',
                            title: 'Something wrong try again'
                        })
                    })
            }
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
