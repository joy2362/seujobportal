<template>
    <!--footer-->
    <div class="sitefooter">
        <v-footer
        >
            <v-row class="blue-grey darken-2 ">
                <v-container>
                    <v-row class="grey--text text--lighten-4 ">
                        <v-col
                            md="4"
                            cols="12"
                        >
                            <h1 class="h4">ABOUT US</h1>
                            <h1 class="body-2 footerabout">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.                            </h1>
                        </v-col>
                        <v-col
                            md="2"
                            cols="12"
                            class="grey--text text--lighten-4 "
                        >
                            <h1 class="h4">QUICK ACCESS</h1>
                            <v-btn text  dark href="https://www.facebook.com/" target="_blank">About Us</v-btn>

                            <v-btn  text dark href="https://www.facebook.com/" target="_blank">Faq</v-btn>

                            <v-btn  text dark href="https://www.facebook.com/" target="_blank">Services</v-btn>

                            <v-btn  text dark href="https://www.facebook.com/" target="_blank">Contact</v-btn>
                        </v-col>
                        <v-col
                            md="4"
                            cols="12"
                        >
                            <h1 class="h4">CONTACT US</h1>
                            <h1 class="body-2"><v-icon dark>mdi-map-marker</v-icon> Address: 144/1A Matikata, Dhaka Cantonment Dhaka, Bangladesh 1206.</h1>
                            <h1 class="body-2"><v-icon dark>mdi-headset</v-icon> Phone: 01751-464765</h1>
                            <h1 class="body-2"><v-icon dark>mdi-gmail</v-icon> Email: unitedengineering201@gmail.com</h1>

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
    .footerabout {
        text-align: justify;
    }
</style>
