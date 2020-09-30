<template>
<v-app>
    <topNavBar :user="user"></topNavBar>
    <v-container>

        <v-form>
        <v-row>

            <v-col cols="12" md="2">
                <v-select
                    item-text="name"
                    item-value="id"
                    :items="category"
                    label="Category"
                    v-model="selectCategory"
                ></v-select>
            </v-col>
            <v-col cols="12" md="2">
                <v-select
                    item-text="name"
                    item-value="id"
                    :items="location"
                    label="Location"
                    v-model="selectLocation"
                ></v-select>
            </v-col>
            <v-col cols="12" md="2">
                <v-select
                    v-model="selectSalary"
                    item-text="name"
                    item-value="id"
                    :items="salary"
                    label="Salary"
                ></v-select>
            </v-col>
            <v-col cols="12" md="3">
                <v-range-slider
                    v-model="experience"
                    min="0"
                    max="20"
                    height="50"
                    label="experience"
                    thumb-color="red"
                    thumb-label="always"
                >
                </v-range-slider>
            </v-col>

            <v-col cols="12 " md="2">
                <v-btn  color="primary" outlined @click="filtered">Filter</v-btn>
            </v-col>

        </v-row>
        </v-form>

        <v-row  class=" ">
            <v-col
                cols="12"
                md="6"
                v-for="row in job" :key="row.id"
            >
                <v-card
                    outlined
                >
                    <v-list-item >
                        <v-list-item-content
                        >
                            <v-toolbar flat>
                                <v-toolbar-title>
                                    <v-btn
                                        text
                                        :to="'/job/'+row.id"
                                        class="body-1"
                                    >
                                        {{row.name}}
                                    </v-btn>
                                </v-toolbar-title>
                                <v-spacer></v-spacer>
                                <div>
                                    <v-btn icon color="pink" @click="shortlist(row.id)">
                                        <v-icon>mdi-star-outline</v-icon>
                                    </v-btn>
                                </div>
                            </v-toolbar>
                            <v-banner
                                single-line
                            >
                                Company:- {{row.company}}

                            </v-banner>
                            <v-list-item-subtitle
                            >
                                <v-chip
                                    class="ma-2"
                                    v-if="row.location === '1'"
                                >
                                    <v-icon left>mdi-map-marker</v-icon>
                                    Dhaka, Bangladesh
                                </v-chip>
                                <v-chip
                                    class="ma-2"
                                    v-if="row.location === '2'"
                                >
                                    <v-icon left>mdi-map-marker</v-icon>
                                    Outside Dhaka
                                </v-chip>
                                <v-chip
                                    class="ma-2"
                                    v-if="row.JobType === '2'"
                                >
                                    <v-icon left>mdi-timetable</v-icon>
                                    Full time
                                </v-chip>
                                <v-chip
                                    class="ma-2"
                                    v-if="row.JobType === '1'"
                                >
                                    <v-icon left>mdi-timetable</v-icon>
                                    Part time
                                </v-chip>
                            </v-list-item-subtitle>

                        </v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <pagination
                    :data="jobs"
                    align="center"
                    @pagination-change-page="filtered"
                    v-if="filteredJob"
                >
                </pagination>
                <pagination
                    :data="jobs"
                    align="center"
                    @pagination-change-page="fetchcategoryjob"
                    v-if="usedCategory"
                >
                </pagination>
                <pagination
                    :data="jobs"
                    align="center"
                    @pagination-change-page="fetchjob"
                    v-if="!usedCategory && !filteredJob"
                >
                </pagination>
            </v-col>
        </v-row>
        <v-row v-if="count<=0" align="center"
               justify="center">
            <v-card
                outlined
            >
                <v-list-item >
                    <v-list-item-avatar
                        tile
                        size="140"
                    >
                        <v-img
                            src="/asset/img/others/404/emoji.png"
                        >
                        </v-img>
                    </v-list-item-avatar>
                    <v-list-item-content
                    >
                        <v-list-item-title class=" font-weight-black" >
                            <h1  >Sorry</h1>
                        </v-list-item-title>
                        <v-list-item-title
                        >
                            <p>  No related post found</p>

                        </v-list-item-title>

                    </v-list-item-content>
                </v-list-item>
            </v-card>
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
import User from "../helper/User";
import topNavBar from "./layouts/topNavBar";
import bottomFooter from "./layouts/bottomFooter";

export default {
name: "allJob",
    created() {
        this.Created()

    },
    data(){
        return {
            loading:false,
            filteredJob:false,
            usedCategory:false,
            category:[ ],
            user:{},
            count:'',
            job:{},
            jobs:{},
            experience: [0, 20],
            selectSalary:[0, 100000000],
            selectCategory:'',
            selectLocation:'3',
            location:[
                {
                    id:'1',
                    name:'Inside Dhaka'
                },
                {
                    id:'2',
                    name:'Outside Dhaka'
                },
                {
                    id:'3',
                    name:'All'
                },

            ],
            salary:[
                {
                    name:'0-20000',
                    id:[0, 20000],
                },
                {
                    name:'20001-50000',
                    id:[20001, 50000],
                },
                {
                    name:'50001-75000',
                    id:[50001, 75000],
                },
                {
                    name:'75001-100000',
                    id:[75001, 100000],
                },
                {
                    name:'100001-*',
                    id:[100001, 100000000],
                },
                {
                    name:'0 - *',
                    id:[0, 100000000],
                },
            ],
        }
    },
    methods:{
        Created(){
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
            this.fatchallcategory();
            if(this.$route.params.category){
                this.fetchcategoryjob()
            }else{
                this.fetchjob();
            }
        },
        filtered(page = 1){
            this.loading=true;
            const formData = new FormData();
            for (var i = 0; i < this.experience.length; i++) {
                formData.append('experience[]', this.experience[i]);
            }
            for ( i = 0; i < this.selectSalary.length; i++) {
                formData.append('salary[]', this.selectSalary[i]);
            }
            formData.append('category', this.selectCategory);
            formData.append('location', this.selectLocation);
            axios.post('/api/job/filter?page=' + page,formData)
                .then(res =>{
                    this.loading=false;
                    this.filteredJob=true;
                    this.jobs=res.data.job;
                    this.job=res.data.job.data;
                    this.count=res.data.job.total;
                })
                .catch(error=>{
                    this.loading=false;
                    this.fetchjob();
                })
        },
        fatchallcategory(){
            axios.get('/api/admin/category/index')
                .then(res =>{
                    this.category=res.data;
                })
        },
        fetchcategoryjob(page = 1){
            let id= this.$route.params.category;

            axios.get('/api/job/all/'+id+'?page=' + page)
                .then(res=>{
                    this.usedCategory=true;
                    this.jobs=res.data.job;
                    this.job=res.data.job.data;
                    this.count=res.data.job.total;
                })
        },
        fetchjob(page = 1){
            axios.get('/api/job/all?page=' + page)
                .then(res=>{
                    this.jobs=res.data.job;
                    this.job=res.data.job.data;
                    this.count=res.data.job.total;
                })
        },
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
    },
    components:{
        topNavBar,
        bottomFooter,
    }

}
</script>

<style scoped>

</style>
