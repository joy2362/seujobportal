<template>
    <v-app>
        <TopNav :user="user"></TopNav>
        <v-container
            class="fill-height"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    md="10"
                    cols="12"
                >
                    <v-card
                    >
                        <v-toolbar
                            flat
                            class="red"
                            dark
                        >
                            <v-toolbar-title class="text-uppercase ">Update Job Post</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-title class="text-uppercase ">
                                <v-btn small text to="/admin/job/all">All Job</v-btn>
                            </v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="name"
                                            :error-messages="nameErrors"
                                            @input="$v.name.$touch()"
                                            @blur="$v.name.$touch()"
                                            label="Title"
                                        ></v-text-field>
                                        <small class="text-danger" v-if="nameError">{{nameError}}</small>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-select
                                            v-model="selectedJobType"
                                            item-text="name"
                                            item-value="id"
                                            :items="jobType"
                                            label="Job Type"
                                            :error-messages="selectedJobTypeErrors"
                                            @input="$v.selectedJobType.$touch()"
                                            @blur="$v.selectedJobType.$touch()"
                                        ></v-select>

                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >
                                        <v-select
                                            v-model="selectedLocation"
                                            item-text="name"
                                            item-value="id"
                                            :items="location"
                                            label="Job Location"
                                            :error-messages="selectedLocationErrors"
                                            @input="$v.selectedLocation.$touch()"
                                            @blur="$v.selectedLocation.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="company"
                                            label="Company name"
                                            :error-messages="companyErrors"
                                            @input="$v.company.$touch()"
                                            @blur="$v.company.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="8"
                                    >
                                        <v-text-field
                                            :error-messages="addressErrors"
                                            @input="$v.address.$touch()"
                                            @blur="$v.address.$touch()"
                                            v-model="address"
                                            label="Address"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col cols="12"  md="3">
                                        <v-dialog
                                            ref="dialog"
                                            v-model="datemenu"
                                            :return-value.sync="lastdate"
                                            persistent
                                            width="290px"
                                        >
                                            <template v-slot:activator="{ on, datePicker }">
                                                <v-text-field
                                                    v-model="lastdate"
                                                    label="Last date of Application"
                                                    readonly
                                                    v-bind="datePicker"
                                                    v-on="on"
                                                    :error-messages="lastdateErrors"
                                                    @input="$v.lastdate.$touch()"
                                                    @blur="$v.lastdate.$touch()"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker v-model="lastdate" scrollable  :min="nowDate">
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary" @click="datemenu = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.dialog.save(lastdate)">OK</v-btn>
                                            </v-date-picker>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-dialog
                                            ref="starttimeselect"
                                            v-model="dutyStartMenu"
                                            :return-value.sync="dutyStart"
                                            persistent
                                            width="290px"
                                        >
                                            <template v-slot:activator="{ on, startTime }">
                                                <v-text-field
                                                    v-model="dutyStart"
                                                    label="Duty Start"
                                                    readonly
                                                    v-bind="startTime"
                                                    v-on="on"
                                                    :error-messages="dutyStartErrors"
                                                    @input="$v.dutyStart.$touch()"
                                                    @blur="$v.dutyStart.$touch()"
                                                ></v-text-field>
                                            </template>
                                            <v-time-picker
                                                v-if="dutyStartMenu"
                                                v-model="dutyStart"
                                                full-width
                                                :max="dutyEnd"
                                                format="24hr"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary" @click="dutyStartMenu = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.starttimeselect.save(dutyStart)">OK</v-btn>
                                            </v-time-picker>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-dialog
                                            ref="endtimeselect"
                                            v-model="dutyEndMenu"
                                            :return-value.sync="dutyEnd"
                                            persistent
                                            width="290px"
                                        >
                                            <template v-slot:activator="{ on, endTime }">
                                                <v-text-field
                                                    v-model="dutyEnd"
                                                    label="Duty End"
                                                    readonly
                                                    v-bind="endTime"
                                                    v-on="on"
                                                    :error-messages="dutyEndErrors"
                                                    @input="$v.dutyEnd.$touch()"
                                                    @blur="$v.dutyEnd.$touch()"
                                                ></v-text-field>
                                            </template>
                                            <v-time-picker
                                                v-if="dutyEndMenu"
                                                full-width
                                                :min="dutyStart"
                                                format="24hr"
                                                v-model="dutyEnd"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary" @click="dutyEndMenu = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.endtimeselect.save(dutyEnd)">OK</v-btn>
                                            </v-time-picker>
                                        </v-dialog>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <v-text-field
                                            v-model="experience"
                                            label="Experience"
                                            :error-messages="experienceErrors"
                                            @input="$v.experience.$touch()"
                                            @blur="$v.experience.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="3"
                                    >

                                        <v-select
                                            v-model="selectedCategory"
                                            item-text="name"
                                            item-value="id"
                                            :items="category"
                                            label="Category"
                                            :error-messages="selectedCategoryErrors"
                                            @input="$v.selectedCategory.$touch()"
                                            @blur="$v.selectedCategory.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="email"
                                            :error-messages="emailErrors"
                                            label="Official E-mail"
                                            @input="$v.email.$touch()"
                                            @blur="$v.email.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                    >
                                        <v-text-field
                                            v-model="phone"
                                            :error-messages="phoneErrors"
                                            label="Contact number"
                                            @input="$v.phone.$touch()"
                                            @blur="$v.phone.$touch()"
                                        ></v-text-field>
                                        <small class="text-danger" v-if="phoneError">{{phoneError}}</small>

                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-select
                                            chips
                                            multiple
                                            v-model="selectedOffday"
                                            :items="offdays"
                                            label="Off day"
                                            :error-messages="selectedOffdayErrors"
                                            @input="$v.selectedOffday.$touch()"
                                            @blur="$v.selectedOffday.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="salary"
                                            label="Salary"
                                            :error-messages="salaryErrors"
                                            @input="$v.salary.$touch()"
                                            @blur="$v.salary.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                    >
                                        <v-text-field
                                            v-model="vacency"
                                            label="Vacancy"
                                            :error-messages="vacencyErrors"
                                            @input="$v.vacency.$touch()"
                                            @blur="$v.vacency.$touch()"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                    >
                                        <div>
                                            <tiptap-vuetify
                                                v-model="jobDetails"
                                                :extensions="extensions"
                                                placeholder="Job Details"
                                            />
                                            <small class="text-danger" v-if="jobDetailsError">{{jobDetailsError}}</small>
                                        </div>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                    >
                                        <div>
                                            <tiptap-vuetify
                                                v-model="requerments"
                                                :extensions="extensions"
                                                placeholder="Requerments"
                                            />
                                            <small class="text-danger" v-if="requermentsError">{{requermentsError}}</small>
                                        </div>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                    >
                                        <div>
                                            <tiptap-vuetify
                                                v-model="qualification"
                                                :extensions="extensions"
                                                placeholder="Educational Qualification"
                                            />
                                            <small class="text-danger" v-if="qualificationError">{{qualificationError}}</small>
                                        </div>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                    >
                                        <div>
                                            <tiptap-vuetify
                                                v-model="benefit"
                                                :extensions="extensions"
                                                placeholder="Other benefit"
                                            />
                                            <small class="text-danger" v-if="benefitError">{{benefitError}}</small>
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" outlined  @click="save">Update</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-footer>
            <BottomFooter></BottomFooter>
        </v-footer>
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

import User from "../../../helper/User";
import TopNav from "../navigationBar";
import BottomFooter from "../BottomFooter";
import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
import {required, minLength, integer, email, minValue} from 'vuelidate/lib/validators'
export default {
    name:'edit',
    created() {
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.hasadminaccess()) {
            this.$router.push({name: 'adminauth'});
        }
        this.fatchallcategory();
        this.fatchjobpost();
        this.checkEmail();
        this.featchUserData();

    },
    validations: {
        email: { required ,email },
        name:{required,minLength:minLength(5)},
        selectedJobType:{required},
        selectedLocation:{required},
        experience:{required,integer,minValue:minValue(0)},
        selectedCategory:{required},
        selectedOffday:{required},
        salary:{required,integer,minValue:minValue(1)},
        vacency:{required,integer,minValue:minValue(1)},
        lastdate:{required},
        dutyStart:{required},
        dutyEnd:{required},
        phone:{required,minLength:minLength(11),integer},
        company:{required,minLength:minLength(5)},
        address:{required,minLength:minLength(5)},
    },
    data(){
        return {
            user:[],
            nowDate: new Date().toISOString().slice(0,10),
            nameError:'',
            qualificationError:'',
            requermentsError:'',
            jobDetailsError:'',
            benefitError:'',
            phoneError:'',

            loading: false,

            phone:'',
            email:'',
            name:'',
            selectedJobType:'',
            selectedLocation:'',
            company:'',
            address:'',
            experience:'',
            selectedCategory:'',
            selectedOffday:[],
            salary:"",
            jobDetails:null,
            requerments:null,
            qualification:null,
            benefit:null,
            vacency:'',

            datemenu: false,
            lastdate: null,

            dutyStart:null,
            dutyEnd:null,

            dutyStartMenu:false,
            dutyEndMenu:false,

            category:[],
            jobType:[
                {
                    id:'1',
                    name:'Part Time'
                },
                {
                    id:'2',
                    name:'Full Time'
                }
            ],
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
            offdays:[
                'Friday', 'Saturday', 'Sunday','Monday','Tuesday','Wednesday', 'Thursday'
            ],
            extensions: [
                History,
                Blockquote,
                Link,
                Underline,
                Strike,
                Italic,
                ListItem,
                BulletList,
                OrderedList,
                [Heading, {
                    options: {
                        levels: [1, 2, 3]
                    }
                }],
                Bold,
                Code,
                HorizontalRule,
                Paragraph,
                HardBreak
            ],
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
        nameErrors(){
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.name.minLength && errors.push('Title Must Be At least 5 character')
            !this.$v.name.required && errors.push('Title required')
            return errors
        },
        companyErrors(){
            const errors = []
            if (!this.$v.company.$dirty) return errors
            !this.$v.company.minLength && errors.push('Company Name Must Be At least 5 character')
            !this.$v.company.required && errors.push('Company Name required')
            return errors
        },
        phoneErrors(){
            const errors = []
            if (!this.$v.phone.$dirty) return errors
            !this.$v.phone.minLength && errors.push('Phone Name Must Be At least 11 Digit')
            !this.$v.phone.integer && errors.push('Phone Name  Must be Integer')
            !this.$v.phone.required && errors.push('Phone Name required')
            return errors
        },
        addressErrors(){
            const errors = []
            if (!this.$v.address.$dirty) return errors
            !this.$v.address.minLength && errors.push('Address Must Be At least 5 character')
            !this.$v.address.required && errors.push('Address required')
            return errors
        },
        selectedJobTypeErrors(){
            const errors = []
            if (!this.$v.selectedJobType.$dirty) return errors
            !this.$v.selectedJobType.required && errors.push('Job Type required')
            return errors
        },
        selectedLocationErrors(){
            const errors = []
            if (!this.$v.selectedLocation.$dirty) return errors
            !this.$v.selectedLocation.required && errors.push('Location required')
            return errors
        },
        experienceErrors(){
            const errors = []
            if (!this.$v. experience.$dirty) return errors
            !this.$v. experience.required && errors.push('Experience required')
            !this.$v.experience.integer && errors.push('Experience Must be Integer ')
            !this.$v.experience.minValue && errors.push('Experience Must be At least 0')
            return errors
        },
        vacencyErrors(){
            const errors = []
            if (!this.$v.vacency.$dirty) return errors
            !this.$v.vacency.required && errors.push('Vacancy required')
            !this.$v.vacency.integer && errors.push('Vacancy Must be Integer ')
            !this.$v.vacency.minValue && errors.push('At least 1 Vacancy')
            return errors
        },
        selectedCategoryErrors(){
            const errors = []
            if (!this.$v.selectedCategory.$dirty) return errors
            !this.$v.selectedCategory.required && errors.push('Category required')
            return errors
        },
        selectedOffdayErrors(){
            const errors = []
            if (!this.$v.selectedOffday.$dirty) return errors
            !this.$v.selectedOffday.required && errors.push('Off day required')
            return errors
        },
        salaryErrors(){
            const errors = []
            if (!this.$v.salary.$dirty) return errors
            !this.$v.salary.required && errors.push('Salary required')
            !this.$v.salary.integer && errors.push('Salary Must be Integer ')
            !this.$v.salary.minValue && errors.push('Salary Must be At least 1')
            return errors
        },

        lastdateErrors(){
            const errors = []
            if (!this.$v.lastdate.$dirty) return errors
            !this.$v.lastdate.required && errors.push('Last date of Application required')
            return errors
        },
        dutyStartErrors(){
            const errors = []
            if (!this.$v.dutyStart.$dirty) return errors
            !this.$v.dutyStart.required && errors.push('Duty Start required')
            return errors
        },
        dutyEndErrors(){
            const errors = []
            if (!this.$v.dutyEnd.$dirty) return errors
            !this.$v.dutyEnd.required && errors.push('Duty End required')
            return errors
        },
    },
    methods:{
        featchUserData(){
            let id=User.id();
            axios.get('/api/admin/info/'+id)
                .then(res =>{
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
        fatchallcategory(){
            axios.get('/api/admin/category/index')
            .then(res =>{
                this.category=res.data;
            })
        },
        fatchjobpost(){
            let id= this.$route.params.id;
            axios.get('/api/admin/job/fatch/'+id)
                .then(res =>{
                    this.name=res.data[0].name;
                    this.email=res.data[0].email;
                    this.phone=res.data[0].phone;
                    this.selectedJobType=res.data[0].JobType;
                    this.selectedLocation=res.data[0].location;
                    this.company=res.data[0].company;
                    this.address=res.data[0].address;
                    this.experience=res.data[0].experience;
                    this.selectedCategory=res.data[0].category;
                    this.salary=res.data[0].salary;
                    this.selectedOffday=res.data[0].offday;
                    this.jobDetails=res.data[0].jobDetails;
                    this.requerments=res.data[0].requerments;
                    this.qualification=res.data[0].qualification;
                    this.benefit=res.data[0].benefit;
                    this.vacency=res.data[0].vacency;
                    this.lastdate=res.data[0].lastdate;
                    this.dutyStart=res.data[0].dutyStart;
                    this.dutyEnd=res.data[0].dutyEnd;

                    let jobs=new Array();
                    for(let i=0;i<res.data[1].length;i++){

                    jobs.push(res.data[1][i].day);
                    }
                    this.selectedOffday=jobs;
                    })
        },
        save(){
            this.loading=true;
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.loading=false;
                Toast.fire({
                    icon: 'error',
                    title: 'Form Not Filled Correctly'
                })
            }else{
                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('JobType', this.selectedJobType);
                formData.append('location', this.selectedLocation);
                formData.append('company', this.company);
                formData.append('address', this.address);
                formData.append('experience', this.experience);
                formData.append('category', this.selectedCategory);
                formData.append('salary', this.salary);
                formData.append('jobDetails', this.jobDetails);
                formData.append('requerments', this.requerments);
                formData.append('qualification', this.qualification);
                formData.append('benefit', this.benefit);
                formData.append('lastdate', this.lastdate);
                formData.append('dutyStart', this.dutyStart);
                formData.append('vacency', this.vacency);
                formData.append('dutyEnd', this.dutyEnd);

                for (var i = 0; i < this.selectedOffday.length; i++) {
                    formData.append('offday[]', this.selectedOffday[i]);
                }

                let id= this.$route.params.id;
                axios.post('/api/admin/job/update/'+id,formData)
                    .then(res =>{
                        this.loading = false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.$router.push({name: 'alljob'});
                    })
                    .catch(error => {
                        this.loading = false;
                        if(error.response.data.errors){
                            Toast.fire({
                                icon: 'error',
                                title: 'Something Wrong Try Again'
                            })
                        }
                        if (error.response.data.errors.phone){
                            this.phoneError=error.response.data.errors.phone[0];
                        }else{
                            this.phoneError="";
                        }
                        if (error.response.data.errors.benefit){
                            this.benefitError=error.response.data.errors.benefit[0];
                        }else{
                            this.benefitError="";
                        }
                        if (error.response.data.errors.jobDetails){
                            this.jobDetailsError=error.response.data.errors.jobDetails[0];
                        }else{
                            this.jobDetailsError="";
                        }
                        if (error.response.data.errors.requerments){
                            this.requermentsError=error.response.data.errors.requerments[0];
                        }else{
                            this.requermentsError="";
                        }
                        if (error.response.data.errors.qualification){
                            this.qualificationError=error.response.data.errors.qualification[0];
                        }else{
                            this.qualificationError="";
                        }
                        if (error.response.data.errors.name){
                            this.nameError=error.response.data.errors.name[0];
                        }else{
                            this.nameError="";
                        }
                    })
            }
        }
    },
    components:{
        TopNav,BottomFooter,TiptapVuetify
    }
}
</script>
<style scoped>

</style>
