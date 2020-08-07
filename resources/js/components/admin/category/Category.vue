<template>
<v-app>
    <TopNav></TopNav>
    <v-container>
        <v-row class="mt-15">
            <v-col
                col="12"
            >
                <v-card class="red white--text" >
                    <v-card-title class="mb-3">
                        <span class="mr-5">Category</span>
                        <v-dialog v-model="dialog"  max-width="600px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    outlined
                                    color="white"
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    Add new
                                </v-btn>
                            </template>
                            <v-card>
                                <v-toolbar
                                    flat
                                    dark
                                    class="red lighten-1"
                                >
                                    <v-toolbar-title class="text-uppercase ">Add Category</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text>

                                    <v-form>
                                        <v-text-field
                                            class="mb-5"
                                            v-model="name"
                                            :error-messages="nameErrors"
                                            label="Category name"
                                            @input="$v.name.$touch()"
                                            @blur="$v.name.$touch()"
                                        ></v-text-field>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                                    <v-btn color="blue darken-1" text @click="add">Add</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-spacer></v-spacer>
                        <v-text-field
                            v-model="categorysearch"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-card-title>
                    <v-data-table
                        :headers="categoryheaders"
                        :search="categorysearch"
                        :items="category"
                    >
                        <template v-slot:item.controls="category">
                            <v-btn class="mx-1" fab dark small color="info" @click="CategoryEdit(category.item)">
                                <v-icon dark>mdi-open-in-new</v-icon>
                            </v-btn>
                            <v-btn class="mx-1" fab dark small color="red" @click="deleteCategory(category.item)">
                                <v-icon dark>mdi-delete</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog v-model="edit"  max-width="600px">
        <v-card>
            <v-toolbar
                flat
                dark
                class="red lighten-1"
            >
                <v-toolbar-title class="text-uppercase ">Edit Category</v-toolbar-title>
            </v-toolbar>
            <v-card-text>

                <v-form>
                    <v-text-field
                        class="mb-5"
                        v-model="editCategory"

                        label="Category name"

                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="edit = false">Close</v-btn>
                <v-btn color="blue darken-1" text @click="Update">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-footer
        fixed
    >
        <BottomFooter></BottomFooter>
    </v-footer>
</v-app>
</template>

<script>
    import User from "../../../helper/User";
    import TopNav from "../navigationBar"
    import {required, minLength} from 'vuelidate/lib/validators'
    import BottomFooter from "../BottomFooter"
    export default {
        name: "addCategory",

        created() {
            if (!User.loggedIn()) {
                this.$router.push({name: 'login'});
            }
            if (!User.isAdmin()) {
                this.$router.push({name: 'home'});
            }
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
            this.fatchallcategory();
        },
        validations: {
            name:{required,minLength:minLength(2)},
        },
        data(){
            return{
                name:'',
                dialog: false,
                categorysearch:'',
                categoryheaders: [
                    {
                        text: '#',
                        align: 'start',
                        value: 'id',
                    },
                    { text: 'Name', value: 'name' },
                    { text: "Action", value: "controls", sortable: false }
                ],
                category:[],
                edit:false,
                editCategory:"",
                editCategoryId:"",
            }
        },
        computed:{
            nameErrors(){
                const errors = []
                if (!this.$v.name.$dirty) return errors
                !this.$v.name.minLength && errors.push('Category Name Must Be At least 2 character')
                !this.$v.name.required && errors.push('Category Name is required')
                return errors
            },

        },
        methods:{
            fatchallcategory(){
                axios.get('/api/admin/category/index')
                    .then(res =>{
                        this.category=res.data;
                    })
            },
            clear(){
                this.name="";
            },
            add(){
                this.$v.$touch()
                if (this.$v.$invalid) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Form Not Filled Correctly'
                    })
                } else {
                    const formData = new FormData();
                    formData.append('name', this.name);
                    axios.post('/api/admin/category/add',formData)
                    .then(res =>{
                        this.fatchallcategory();
                        this.clear();
                        this.dialog = false;
                        Toast.fire({
                            icon: 'success',
                            title: 'Category Added'
                        })

                    })
                    .catch(error => {
                        if (error.response.data.errors){
                            Swal.fire(
                                'Sorry!',
                                error.response.data.errors.name[0],
                                'error'
                            )
                        }
                    } )
                }
            },
            CategoryEdit(item){
              this.editCategory=item.name;
              this.editCategoryId=item.id;
              this.edit=true;
            },
            clearEdit(){
                this.editCategory="";
                this.editCategoryId="";
            },
            Update(){
                const formData = new FormData();
                formData.append('name', this.editCategory);
                formData.append('id', this.editCategoryId);
                axios.post('/api/admin/category/update',formData)
                .then(res=>{
                    this.fatchallcategory();
                    this.edit=false;
                    this.clearEdit();
                    Swal.fire(
                        'Success!',
                        res.data.msg,
                        'success'
                    )
                } )
                .catch(error => {
                    if (error.response.data.errors){
                        Swal.fire(
                            'Sorry!',
                            error.response.data.errors.name[0],
                            'error'
                        )
                    }
                } )
            },
            deleteCategory(item){
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
                        axios.get('/api/admin/category/destroy/'+ item.id)
                            .then(()=>{
                                this.fatchallcategory();
                                Swal.fire(
                                    'Deleted!',
                                    'Category delete successfully.',
                                    'success'
                                )
                            } )
                            .catch(error => {
                                Swal.fire(
                                    'Sorry!',
                                    'Something wrong try again.',
                                    'error'
                                )
                            })
                    }
                })
            }
        },
        components:{
            TopNav,BottomFooter
        }

    }
</script>

<style scoped>

</style>
