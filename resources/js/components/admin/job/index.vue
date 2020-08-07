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
                        <span class="mr-5">Job Post</span>
                        <v-toolbar-title
                            class="text-uppercase"
                        >
                            <v-btn
                                small
                                text
                                class="white--text"
                                to="/admin/job/add"
                            >
                               Add New
                            </v-btn>
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-text-field
                            v-model="jobsearch"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-card-title>
                    <v-data-table
                        :headers="jobheaders"
                        :search="jobsearch"
                        :items="jobs"
                    >
                        <template v-slot:item.controls="jobs">
                            <v-btn class="mx-1" fab dark small color="success" @click="JobShow(jobs.item)">
                                <v-icon dark>mdi-open-in-new</v-icon>
                            </v-btn>
                            <v-btn class="mx-1" fab dark small color="info" @click="JobEdit(jobs.item)">
                                <v-icon dark>mdi-tune</v-icon>
                            </v-btn>
                            <v-btn class="mx-1" fab dark small color="red" @click="deleteJob(jobs.item)">
                                <v-icon dark>mdi-delete</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <v-footer
    fixed
    >
        <BottomFooter></BottomFooter>
    </v-footer>
</v-app>
</template>

<script>
    import User from "../../../helper/User";
    import TopNav from "../navigationBar";
    import BottomFooter from "../BottomFooter";

    export default {
        name: "index",
        created() {
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
            this.fatchalldata();
        },
        data(){
            return{
                jobs:[],
                jobsearch:'',
                jobheaders: [
                    {
                        text: '#',
                        align: 'start',
                        value: 'id',
                    },
                    { text: 'Title', value: 'name' },
                    { text: 'Last date of Application', value: 'lastdate' },
                    { text: 'Vacency', value: 'vacency' },
                    { text: "Action", value: "controls", sortable: false }
                ],
            }
        },
        methods:{
            fatchalldata(){
                axios.get('/api/admin/job/index')
                    .then(res =>{
                        this.jobs=res.data;
                        console.log(this.jobs);
                    })
            },
            JobEdit(item){
                this.$router.push('/edit/job/'+ item.id);
            },
            JobShow(item){
                this.$router.push('/show/job/'+ item.id);
            },
            deleteJob(item){
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
                        axios.get('/api/admin/job/destroy/'+ item.id)
                            .then(res=>{
                                this.fatchalldata();
                                Swal.fire(
                                    'Deleted!',
                                    res.data.msg,
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
