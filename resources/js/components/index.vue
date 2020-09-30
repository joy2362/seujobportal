<template>
    <v-app>
        <!--navbar design extends from layouts/topnavbar-->
        <topNavBar :user="user"></topNavBar>
        <v-parallax
            dark
            src="asset/img/others/closeup-keybord.jpg"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col class="text-center" cols="12">
                    <h1 class="display-1 font-weight-thin mb-4 ">Looking for a job?</h1>
                    <h4 class="subheading">Find the most exciting startup jobs!</h4>
                    <v-form autocomplete="false">
                        <v-container>
                            <v-row
                                align="center"
                                justify="center"
                            >
                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-text-field
                                        flat
                                        dark
                                        label="Keyword"
                                        required
                                        v-model="title"
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-select
                                        dark
                                        item-text="name"
                                        item-value="id"
                                        :items="location"
                                        label="Location"
                                        required
                                        v-model="selectlocation"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-btn
                                    outlined
                                    dark
                                    color="success"
                                    @click="search"
                                    >
                                        Search
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-col>
            </v-row>
        </v-parallax>
        <v-container>
        <v-row
            align="center"
            justify="center"
            class="mt-15"
        >
            <v-col
                class="text-center"
                cols="12"
            >
                <span  class="font-weight-light h1 red--text  text-uppercase">Popolar <span class="font-weight-black">Categories</span></span>
            </v-col>
        </v-row>
        <v-row class="mt-8">
            <v-col
                md="3"
                cols="12"
                class="fill-height"
                align="center"
                v-for="item in category"
                :key="item.id"
            >
                <v-hover
                    v-slot:default="{ hover }"
                    close-delay="200"
                >
                    <v-card
                        :elevation="hover ? 16 : 2"
                        flat
                        class="pt-3"

                    >
                        <v-card-text>
                            <v-btn
                                text
                                small
                                :to="'/all/job/'+item.id"
                            >
                                {{item.name}}
                            </v-btn>
                            <p class="subtitle-1"> <v-chip >{{item.total_job}}</v-chip> Available position</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
        </v-row>
            <v-row
                align="center"
                justify="center"
                class="mt-15"
            >
                <v-col
                    class="text-center"
                    cols="12"
                >
                    <v-btn
                        x-large
                        color="success "
                        outlined
                        dark
                        to="/all/category"
                    >
                        Browse All Sector
                    </v-btn>
                </v-col>
            </v-row>
            <v-row
                align="center"
                justify="center"
                class="mt-15"
            >
                <v-col
                    class="text-center"
                    cols="12"
                >
                    <span  class="font-weight-light h1 red--text  text-uppercase">RECENT  <span class="font-weight-black">JOBS</span></span>
                </v-col>
            </v-row>
            <v-row
                class="mt-10"
            >
                <v-col
                cols="12"
                md="6"
                v-for="row in recentJob" :key="row.id"
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
        </v-container>
        <v-parallax
            class="mt-15 hidden-sm-and-down"
            dark
            src="asset/img/others/howtoapply/how-applybg.png"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col class="text-center" cols="12">
                    <h4  class="subheading font-weight-thin">APPLY PROCESS</h4>
                    <h4  class="display-1  mt-4 ">How it works</h4>

                        <v-container>
                            <v-row class="mt-8">
                                <v-col
                                    md="4"
                                    cols="12"
                                    class="fill-height"
                                    align="center"
                                >
                                    <v-hover
                                        v-slot:default="{ hover }"
                                        close-delay="200"
                                    >
                                        <v-card
                                            :elevation="hover ? 16 : 2"
                                            flat
                                            class="pt-3 indigo darken-1"
                                            dark
                                        >
                                            <v-icon
                                               size="50px"
                                            >
                                                mdi-magnify
                                            </v-icon>
                                            <v-card-text>
                                                <h1 class="h5">1. Search a job</h1>
                                                <p class="subtitle-1">Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
                                            </v-card-text>
                                        </v-card>
                                    </v-hover>
                                </v-col>
                                <v-col
                                    md="4"
                                    cols="12"
                                    class="fill-height"
                                    align="center"
                                >
                                    <v-hover
                                        v-slot:default="{ hover }"
                                        close-delay="200"
                                    >
                                        <v-card
                                            :elevation="hover ? 16 : 2"
                                            flat
                                            class="pt-3 indigo darken-1"
                                            dark
                                        >
                                            <v-icon
                                                size="50px"
                                            >
                                                mdi-checkbox-marked-circle-outline
                                            </v-icon>
                                            <v-card-text>
                                                <h1 class="h5">2. Apply for job</h1>
                                                <p class="subtitle-1">Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
                                            </v-card-text>
                                        </v-card>
                                    </v-hover>
                                </v-col>
                                <v-col
                                    md="4"
                                    cols="12"
                                    class="fill-height"
                                    align="center"
                                >
                                    <v-hover
                                        v-slot:default="{ hover }"
                                        close-delay="200"
                                    >
                                        <v-card
                                            dark
                                            :elevation="hover ? 16 : 2"
                                            flat
                                            class="pt-3 indigo darken-1"
                                        >
                                            <v-icon
                                                size="50px"
                                            >
                                                mdi-account-check
                                            </v-icon>
                                            <v-card-text
                                            >
                                                <h1 class=" h5">3.Get your job</h1>
                                                <p class="subtitle-1">Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
                                            </v-card-text>
                                        </v-card>
                                    </v-hover>
                                </v-col>
                            </v-row>
                        </v-container>
                </v-col>
            </v-row>
        </v-parallax>
        <v-container>
            <v-row
                align="center"
                justify="center"
                class="mt-15"
            >
                <v-col
                    class="text-center"
                    cols="12"
                >
                    <span  class="font-weight-light h1 red--text  text-uppercase">Featured  <span class="font-weight-black ">Jobs</span></span>
                </v-col>
            </v-row>
            <v-row  class="mt-10">
                <v-col
                    cols="12"
                    md="6"
                    v-for="row in featuredJob" :key="row.id"
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
                                    <div >
                                        <v-btn icon color="pink"  @click="shortlist(row.id)">
                                            <v-icon>mdi-star-outline</v-icon>
                                        </v-btn>
                                    </div>
                                </v-toolbar>
                                <v-banner
                                    single-line
                                >
                                    Company - {{row.company}}

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
            <v-row
                align="center"
                justify="center"
                class="mt-15"
            >
                <v-col
                    class="text-center"
                    cols="12"
                >
                    <span  class="font-weight-light h1 red--text">UPCOMMING  <span class="font-weight-black">EVENTS</span></span>
                </v-col>
            </v-row>
            <v-row  class="mt-10 mb-10">
                <v-col
                    cols="12"
                    md="6"
                    v-for="row in events" :key="row.id"
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
                                            :to="'/event/'+row.id"
                                            class="body-1"
                                        >
                                            {{row.name}}
                                        </v-btn>
                                    </v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <div >
                                        <v-btn icon color="pink"  @click="shortlistEvent(row.id)">
                                            <v-icon>mdi-star-outline</v-icon>
                                        </v-btn>
                                    </div>
                                </v-toolbar>
                                <v-banner
                                    single-line
                                >
                                    Company - {{row.company}}
                                </v-banner>

                                <v-list-item-subtitle>
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
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        {{ row.eventDate }}
                                    </v-chip>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <bottom-footer ></bottom-footer>
    </v-app>
</template>
<script>
    import User from "../helper/User";
    import topNavBar from "./layouts/topNavBar"
    import bottomFooter from "./layouts/bottomFooter"
export default {
    name:"index",
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
        this.fatchcategory();
        this.userData();
        this.fatchAllData();
    },
    data(){
        return {
            user:{},
            title:'',
            selectlocation:'',

            location:[

                {
                    id:'1',
                    name:'Inside Dhaka'
                },
                {
                    id:'2',
                    name:'Outside Dhaka'
                },

            ],
            category:[],
            recentJob:[],
            featuredJob:[],
            events:[],
        }
    },
    methods:{
        search(){
            this.$router.push('/search/job/'+this.title+'/'+this.selectlocation)
        },
        shortlist(id){
            const formData = new FormData();
            formData.append('email', User.email());
            formData.append('jobId', id);
            axios.post('/api/shortlist/add',formData)
            .then(res =>{
                Toast.fire({
                    icon: 'success',
                    title: 'Successfully Added to your favourite list'
                })
            })
            .catch(error=>{
                if(error.response.data.msg){
                    Toast.fire({
                        icon: 'error',
                        title: 'Already Added'
                    })
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Somthing wrong try again'
                    })
                }
            })
         },
        shortlistEvent(id){
            const formData = new FormData();
            formData.append('email', User.email());
            formData.append('eventId', id);
            axios.post('/api/event/shortlist/add',formData)
                .then(res =>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Successfully Added to your favourite list'
                    })
                })
                .catch(error=>{
                 if(error.response.data.msg){
                     Toast.fire({
                         icon: 'error',
                         title: 'Already Added'
                     })
                 }else{
                     Toast.fire({
                         icon: 'error',
                         title: 'Something wrong try again'
                     })
                 }

                })
        },
        fatchAllData(){
            axios.get('/api/home/all')
                .then(res=>{
                    this.recentJob=res.data.recentJob;
                    this.featuredJob=res.data.featuredJob;
                    this.events=res.data.event;
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
        fatchcategory(){
            axios.get('/api/admin/category/index')
            .then(res =>{
                this.category=res.data;
            })
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
