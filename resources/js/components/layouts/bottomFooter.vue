<template>
    <!--footer-->
    <div class="sitefooter">
        <v-footer
        >
            <v-row class="blue-grey darken-2 ">
                <v-container>
                    <v-row class="grey--text text--lighten-4 font-weight-thin">
                        <v-col

                            md="3"
                            cols="12"
                        >

                            <h1 class="h4">ABOUT US</h1>
                            <div
                                align="center"
                                justify="center"
                            >
                            <v-toolbar-title class=" mt-5 mb-5 " >
                                <v-img src="/asset/img/logo/seu_logo.png" width="70" height="70" ></v-img>
                            </v-toolbar-title>
                            </div>
                            <h1 class="body-2 ">
                                The Vision of Southeast University is:
                                To Obtain Global Recognition as a World Class University.
                            </h1>
                        </v-col>
                        <v-col
                            md="2"
                            cols="12"
                            class="grey--text text--lighten-4 "
                        >
                            <h1 class="h4">QUICK ACCESS</h1>
                            <v-btn text  dark to='/all/job' >Find job</v-btn>

                            <v-btn  text dark to='/all/event' >Event </v-btn>

                            <v-btn  text dark to='/contact' >Contact us</v-btn>
                        </v-col>
                        <v-col
                            md="4"
                            cols="12"
                        >
                            <h1 class="h4">CONTACT US</h1>
                            <h1 class="body-2"><v-icon class="cyan--text">mdi-map-marker-outline</v-icon> Permanent Campus:
                                251/A and 252
                                Tejgaon Industrial Area
                                Dhaka-1208</h1>
                            <h1 class="body-2"><v-icon class="cyan--text">mdi-phone</v-icon> For Inquiry: 55034125</h1>
                            <h1 class="body-2"><v-icon class="cyan--text">mdi-email-outline</v-icon> Email: admission@seu.ac.bd</h1>

                        </v-col>
                        <v-col
                            md="2"
                            cols="12"
                        >
                            <h1 class="h4">FOLLOW US</h1>
                            <v-btn icon dark href="https://www.facebook.com/" target="_blank">
                                <v-icon>mdi-facebook</v-icon>
                            </v-btn>
                            <v-btn icon dark href="https://www.facebook.com/" target="_blank">
                                <v-icon>mdi-google-plus</v-icon>
                            </v-btn>
                            <v-btn icon dark href="https://www.facebook.com/" target="_blank">
                                <v-icon>mdi-twitter</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-row>
            <v-row>
                <v-col
                    class="grey darken-4 py-4 text-center white--text"
                    cols="12"
                >
                    Copyright &copy;{{ new Date().getFullYear() }} | Southeast University | All rights reserved | Developed with
                    <v-icon color="red">mdi-heart</v-icon> by <v-btn text dark href="#" target="_blank">
                    Joy2362
                </v-btn>
                </v-col>
            </v-row>
        </v-footer>
        <!--footer end-->
    </div>
</template>
<script>
    export default {
        name: "bottomFooter"
    }
</script>
<style scoped>
a:hover{
    text-decoration:none;
}
</style>
