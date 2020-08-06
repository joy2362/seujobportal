<template>
<v-app>
    <TopNav></TopNav>
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
                        <v-toolbar-title class="text-uppercase ">Add New Job</v-toolbar-title>
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
                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-menu
                                        v-model="datemenu"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                label="Last date of Application"
                                                readonly
                                                v-model="lastdate"
                                                v-on="on"
                                                :error-messages="lastdateErrors"
                                                @input="$v.lastdate.$touch()"
                                                @blur="$v.lastdate.$touch()"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker

                                            locale="en-in"
                                            v-model="lastdate"
                                            no-title
                                            @input="datemenu = false"
                                        ></v-date-picker>
                                    </v-menu>

                                </v-col>

                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-menu
                                        v-model="dutyStartMenu"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                label="Duty Start"
                                                readonly
                                                v-model="dutyStart"
                                                v-on="on"
                                                :error-messages="dutyStartErrors"
                                                @input="$v.dutyStart.$touch()"
                                                @blur="$v.dutyStart.$touch()"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                            :max="dutyEnd"
                                            format="24hr"
                                            v-model="dutyStart"
                                            no-title
                                            @input="dutyStartMenu = false"
                                        >
                                        </v-time-picker>
                                    </v-menu>

                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-menu
                                        v-model="dutyEndMenu"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                label="Duty End"
                                                readonly
                                                v-model="dutyEnd"
                                                v-on="on"
                                                :error-messages="dutyEndErrors"
                                                @input="$v.dutyEnd.$touch()"
                                                @blur="$v.dutyEnd.$touch()"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                            :min="dutyStart"
                                            format="24hr"
                                            v-model="dutyEnd"
                                            no-title
                                            @input="dutyEndMenu = false"
                                        >
                                        </v-time-picker>
                                    </v-menu>

                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        v-model="experience"
                                        label="Expericence"
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
                                    md="4"
                                >
                                    <v-select
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
                                        label="Vacency"
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
                                            :error-messages="jobDetailsErrors"
                                            @input="$v.jobDetails.$touch()"
                                            @blur="$v.jobDetails.$touch()"
                                        />
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
                                            :error-messages="requermentsErrors"
                                            @input="$v.requerments.$touch()"
                                            @blur="$v.requerments.$touch()"
                                        />
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
                                            :error-messages="qualificationErrors"
                                            @input="$v.qualification.$touch()"
                                            @blur="$v.qualification.$touch()"
                                        />
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
                                            :error-messages="benefitErrors"
                                            @input="$v.benefit.$touch()"
                                            @blur="$v.benefit.$touch()"
                                        />
                                    </div>
                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <v-file-input
                                        v-model="image"
                                        accept="image/*"
                                        label="Image"
                                        prepend-icon="mdi-camera"
                                        :error-messages="jobimageErrors"
                                        @input="$v.image.$touch()"
                                        @blur="$v.image.$touch()"
                                    >
                                    </v-file-input>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" outlined  @click="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <v-footer

    >
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
    import {required, minLength,integer} from 'vuelidate/lib/validators'
    export default {
        name:'add',
        created() {
            if (!User.hasadminaccess()) {
                this.$router.push({name: 'adminauth'});
            }
            this.fatchallcategory();
        },
        validations: {
            name:{required,minLength:minLength(5)},
            selectedJobType:{required},
            selectedLocation:{required},
            experience:{required,integer},
            selectedCategory:{required},
            selectedOffday:{required},
            salary:{required,integer},
            vacency:{required,integer},
            jobDetails:{required},
            requerments:{required},
            qualification:{required},
            benefit:{required},
            image:{required},
            lastdate:{required},
            dutyStart:{required},
            dutyEnd:{required},
            company:{required,minLength:minLength(5)},
            address:{required,minLength:minLength(5)},
        },
        data(){
            return {
                loading: false,
                name:'',
                selectedJobType:'',
                selectedLocation:'',
                company:'',
                address:'',
                experience:'',
                selectedCategory:'',
                selectedOffday:"",
                salary:"",
                jobDetails:null,
                requerments:null,
                qualification:null,
                benefit:null,
                image:null,
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
                !this.$v.experience.integer && errors.push('Experience Must be Interger ')
                return errors
            },
            vacencyErrors(){
                const errors = []
                if (!this.$v.vacency.$dirty) return errors
                !this.$v.vacency.required && errors.push('Vacency required')
                !this.$v.vacency.integer && errors.push('Vacency Must be Interger ')
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
                !this.$v.salary.integer && errors.push('Salary Must be Interger ')
                return errors
            },
            jobDetailsErrors(){
                const errors = []
                if (!this.$v.jobDetails.$dirty) return errors
                !this.$v.jobDetails.required && errors.push('Details required')
                return errors
            },
            requermentsErrors(){
                const errors = []
                if (!this.$v.requerments.$dirty) return errors
                !this.$v.requerments.required && errors.push('Requerments required')
                return errors
            },
            qualificationErrors(){
                const errors = []
                if (!this.$v.qualification.$dirty) return errors
                !this.$v.qualification.required && errors.push('Qualification required')
                return errors
            },
            benefitErrors(){
                const errors = []
                if (!this.$v.benefit.$dirty) return errors
                !this.$v.benefit.required && errors.push('Other benefit required')
                return errors
            },
            jobimageErrors(){
                const errors = []
                if (!this.$v.image.$dirty) return errors
                !this.$v.image.required && errors.push('Image required')
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
            fatchallcategory(){
                axios.get('/api/admin/category/index')
                    .then(res =>{
                        this.category=res.data;
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
                     formData.append('JobType', this.selectedJobType);
                     formData.append('location', this.selectedLocation);
                     formData.append('company', this.company);
                     formData.append('address', this.address);
                     formData.append('experience', this.experience);
                     formData.append('category', this.selectedCategory);
                     formData.append('offday', this.selectedOffday);
                     formData.append('salary', this.salary);
                     formData.append('jobDetails', this.jobDetails);
                     formData.append('requerments', this.requerments);
                     formData.append('qualification', this.qualification);
                     formData.append('benefit', this.benefit);
                     formData.append('image', this.image, this.image.name);
                     formData.append('lastdate', this.lastdate);
                     formData.append('dutyStart', this.dutyStart);
                     formData.append('vacency', this.vacency);
                     formData.append('dutyEnd', this.dutyEnd);
                     axios.post('/api/admin/job/add',formData)
                     .then(res =>{
                         this.loading = false;
                         Swal.fire(
                             'Success!',
                             res.data.msg,
                             'success'
                         )
                     })
                     .catch(error => {
                         this.loading = false;
                         if (error.response.data.errors){
                             Toast.fire({
                                 icon: 'error',
                                 title: 'Somthing Wrong Try Again'
                             })
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
