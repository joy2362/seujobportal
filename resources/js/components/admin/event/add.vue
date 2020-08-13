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
                <v-card>
                    <v-toolbar
                        flat
                        class="red"
                        dark
                    >
                        <v-toolbar-title class="text-uppercase ">Add New Event</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-title class="text-uppercase ">
                            <v-btn small text to="/admin/event/all">All Event</v-btn>
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
                                        label="Event name"
                                    ></v-text-field>
                                    <small class="text-danger" v-if="nameError">{{nameError}}</small>

                                </v-col>
                                <v-col
                                    cols="12"
                                    md="6"
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
                                    md="3"
                                >
                                <v-select
                                    item-text="name"
                                    item-value="id"
                                    :items="location"
                                    label="Event Location"
                                    v-model="selectedLocation"
                                    :error-messages="selectedLocationErrors"
                                    @input="$v.selectedLocation.$touch()"
                                    @blur="$v.selectedLocation.$touch()"
                                ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="9"
                                >
                                    <v-text-field
                                        :error-messages="addressErrors"
                                        @input="$v.address.$touch()"
                                        @blur="$v.address.$touch()"
                                        v-model="address"
                                        label="Address"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12"  md="6">
                                    <v-dialog
                                        ref="DateSelector"
                                        v-model="eventdateseletor"
                                        :return-value.sync="eventDate"
                                        persistent
                                        width="290px"
                                    >
                                        <template v-slot:activator="{ on, datePicker }">
                                            <v-text-field
                                                v-model="eventDate"
                                                label="Event Date"
                                                readonly
                                                v-bind="datePicker"
                                                v-on="on"
                                                :error-messages="eventDateErrors"
                                                @input="$v.eventDate.$touch()"
                                                @blur="$v.eventDate.$touch()"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker v-model="eventDate" scrollable  :min="nowDate">
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="eventdateseletor = false">Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.DateSelector.save(eventDate)">OK</v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-dialog
                                        ref="starttimeselect"
                                        v-model="eventtimeletor"
                                        :return-value.sync="eventStart"
                                        persistent
                                        width="290px"
                                    >
                                        <template v-slot:activator="{ on, startTime }">
                                            <v-text-field

                                                readonly
                                                v-bind="startTime"
                                                v-on="on"
                                                label="Event Start"
                                                v-model="eventStart"
                                                :error-messages="eventStartErrors"
                                                @input="$v.eventStart.$touch()"
                                                @blur="$v.eventStart.$touch()"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                            v-if="eventtimeletor"
                                            v-model="eventStart"
                                            full-width
                                            :max="dutyEnd"
                                            format="24hr"
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="eventtimeletor = false">Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.starttimeselect.save(eventStart)">OK</v-btn>
                                        </v-time-picker>
                                    </v-dialog>
                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <tiptap-vuetify
                                        v-model="details"
                                        :extensions="extensions"
                                        placeholder="Event Details"
                                        :error-messages="detailsErrors"
                                        @input="$v.details.$touch()"
                                        @blur="$v.details.$touch()"
                                    />
                                    <small class="text-danger" v-if="detailsError">{{detailsError}}</small>
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
    import {required, minLength} from 'vuelidate/lib/validators'
    import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'

    export default {
    name: "add",
    created() {
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.hasadminaccess()) {
            this.$router.push({name: 'adminauth'});
        }
        this.checkEmail();
    },
    validations: {
        name:{required,minLength:minLength(5)},
        selectedLocation:{required},
        eventStart:{required},
        eventDate:{required},
        details:{required},
        company:{required,minLength:minLength(5)},
        address:{required,minLength:minLength(5)},
    },
        data(){
        return {
            nowDate: new Date().toISOString().slice(0,10),
            detailsError:'',
            nameError:'',
            loading:false,
            name:'',
            company:'',
            selectedLocation:'',
            address:"",
            eventDate:null,
            eventStart:null,
            details:'',
            eventdateseletor:false,
            eventtimeletor:false,
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
                !this.$v.name.minLength && errors.push('Event name Must Be At least 5 character')
                !this.$v.name.required && errors.push('Event Name required')
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
            selectedLocationErrors(){
                const errors = []
                if (!this.$v.selectedLocation.$dirty) return errors
                !this.$v.selectedLocation.required && errors.push('Event Location required')
                return errors
            },
            eventDateErrors(){
                const errors = []
                if (!this.$v.eventDate.$dirty) return errors
                !this.$v.eventDate.required && errors.push('Event date required')
                return errors
            },
            eventStartErrors(){
                const errors = []
                if (!this.$v.eventStart.$dirty) return errors
                !this.$v.eventStart.required && errors.push('Event Start required')
                return errors
            },
            detailsErrors(){
                const errors = []
                if (!this.$v.details.$dirty) return errors
                !this.$v.details.required && errors.push('Event Details required')
                return errors
            },
        },
        methods:{
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
                    formData.append('company', this.company);
                    formData.append('location', this.selectedLocation);
                    formData.append('address', this.address);
                    formData.append('eventDate', this.eventDate);
                    formData.append('eventStart', this.eventStart);
                    formData.append('details', this.details);
                    axios.post('/api/admin/event/add',formData)
                    .then(res=>{
                        this.loading = false;
                        Swal.fire(
                            'Success!',
                            res.data.msg,
                            'success'
                        )
                        this.$router.push({name:'allevent'});
                    })
                    .catch(error=>{
                        this.loading = false;
                        console.log(error.response.data.errors)
                        if (error.response.data.errors){
                            Toast.fire({
                                icon: 'error',
                                title: 'Something Wrong Try Again'
                            })
                        }
                        if (error.response.data.errors.name){
                            this.nameError=error.response.data.errors.name[0];
                        }else{
                            this.nameError="";
                        }
                        if (error.response.data.errors.details){
                            this.detailsError=error.response.data.errors.details[0];
                        }else{
                            this.detailsError="";
                        }
                    })
                }
            }
        },
        components:{
            TopNav,BottomFooter,TiptapVuetify
        },
}
</script>

<style scoped>

</style>
