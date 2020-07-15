<template>
<!--footer-->
<div class="sitefooter">
            <v-footer
            padless
            >
            <v-row class="grey darken-3 ">
            <v-container>
            <v-row class=" white--text">
                <v-col
                md="4"
                cols="12"
                >
                <h1 class="h4">ABOUT US</h1>
                <h1 class="body-2 footerabout">
                    United Engineering Provided all types of FIRE & ELECTRICAL Safety solutions. We are specialized in Designing, Supply, Installation & Commissioning. Maintenance of Various Fire Protection & Alarm systems. Our highly qualified & well-experienced engineers are able to Design & Commission the system to meet the requirements of NFPA or Others International & Local Authorities.
                </h1>
                </v-col>
                <v-col
                md="2"
                cols="12"
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
            Copyright &copy;{{ new Date().getFullYear() }} | United Engineering | All rights reserved | Developed with
            <v-icon color="red">mdi-heart</v-icon> by <v-btn text dark href="https://www.facebook.com/" target="_blank">
            Abdullah Zahid
            </v-btn>
      </v-col>
                </v-row>
            </v-footer>
            <!--footer end-->
            </div>
</template>
<script>
export default {
  name:'sitefooter',
}
</script>
<style scoped>
.footerabout {
    text-align: justify;
}
</style>
