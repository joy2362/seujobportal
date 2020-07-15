<template>
    <v-app class="grey lighten-4">
        <v-toolbar  short flat color="#0d2d3e" class="pr-16 pl-16 hidden-sm-and-down" >
            <v-toolbar-title class="text-uppercase white--text">
                <v-icon  small color="red darken-2">mdi-clock-time-eleven-outline</v-icon>
                <span class="body-2" >Every Day:9.0 a.m-9.0 pm</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
             <v-btn icon dark href="https://www.facebook.com/" target="_blank">
               <v-icon>mdi-facebook</v-icon>
            </v-btn>
             <v-btn icon dark href="https://www.facebook.com/" target="_blank">
               <v-icon>mdi-google-plus</v-icon>
            </v-btn>
             <v-btn icon dark href="https://www.facebook.com/" target="_blank">
               <v-icon>mdi-twitter</v-icon>
            </v-btn>
        </v-toolbar>
        <!--this start  navigration-->
        <v-container >
            <v-toolbar  flat >
                <v-toolbar-title class="text-uppercase red--text">
                    <span  class="font-weight-light">United<span class="font-weight-black">Engineering</span></span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <v-btn depressed small text to='/'>
                        <span>Home</span>
                    </v-btn>
                    <v-btn  small text to='/home'>
                        <span>About</span>
                    </v-btn>
                    <v-menu open-on-hover down offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                            text
                            small
                            v-bind="attrs"
                            v-on="on"
                            >
                            Our Product
                            </v-btn>
                        </template>
                        <v-list color="blue-grey lighten-4">
                            <v-list-item
                            v-for="(item, index) in items"
                            :key="index"
                        to='/'
                            >
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <v-btn  small text to='/'>
                        <span>Services</span>
                    </v-btn>
                    <v-btn  small text to='/'>
                        <span>Contact</span>
                    </v-btn>
                </v-toolbar-items>
                <v-toolbar-items class="hidden-md-and-up">
                    <v-app-bar-nav-icon color="red" @click="nmobienav = !nmobienav"></v-app-bar-nav-icon>
                </v-toolbar-items>
            </v-toolbar>
            <v-navigation-drawer v-model="nmobienav" app class=" hidden-md-and-up" right>
               <v-list nav>
                   <v-list-item to='/'>
                      <v-list-item-content>
                        <v-list-item-title dark>Home</v-list-item-title>
                      </v-list-item-content>
                   </v-list-item>
                    <v-list-item to='/'>
                      <v-list-item-content >
                        <v-list-item-title dark>About</v-list-item-title>
                      </v-list-item-content>
                   </v-list-item>
                    <v-list-item>
                        <v-list-group
                        no-action
                        sub-group
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title>Our Product</v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item to='/'>
                            <v-list-item-content>
                                <v-list-item-title color="red--text">Fire</v-list-item-title>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item to='/'>
                            <v-list-item-content>
                                <v-list-item-title color="red--text">Door</v-list-item-title>
                            </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                    </v-list-item>
                     <v-list-item to='/'>
                      <v-list-item-content>
                        <v-list-item-title dark>Contact</v-list-item-title>
                      </v-list-item-content>
                   </v-list-item>
                </v-list>
                <template v-slot:append>
                    <div class="pa-2 "  >
                        <v-btn icon>
                            <v-icon>mdi-facebook</v-icon>
                        </v-btn>
                        <v-btn icon  >
                            <v-icon>mdi-google-plus</v-icon>
                        </v-btn>
                        <v-btn icon  >
                            <v-icon>mdi-twitter</v-icon>
                        </v-btn>
                    </div>
                </template>
            </v-navigation-drawer>
        </v-container>
        <!--this end  navigration-->

        <!--this is top carousel start-->
        <v-carousel hide-delimiters
         cycle
         show-arrows-on-hover
         >
            <v-carousel-item
            v-for="(item,i) in images"
            :key="i"
            :src="item.src"
            >
                <v-row
                class="fill-height"
                align="center"
                justify="center"
                >
                    <div class="">
                        <h1 class="text-center black--text h2">This is title</h1>
                        <p  class=" body-1 black--text">
                            <typewriter
                                :speed="200"
                                :full-erase="true"
                                :interval="300"
                                :words='["this is description"]'>
                            </typewriter>
                        </p>
                    </div>
                </v-row>
            </v-carousel-item>
        </v-carousel>
         <!--this is top carousel end-->
         <!--main contant start-->
        <v-container>
            <v-row class="mt-15">
                <v-col
                md="3"
                >
                <h1 class="h3 red--text">WHO WE ARE</h1>
                </v-col>
            </v-row>
            <v-row class="mt-8">
                <v-col
                md="7"
                >
                <p dark class="body-1 whoarewe">United Engineering Provided all types of FIRE & ELECTRICAL Safety solutions. We are specialized in Designing, Supply, Installation & Commissioning. Maintenance of Various Fire Protection & Alarm systems. Our highly qualified & well-experienced engineers are able to Design & Commission the system to meet the requirements of NFPA or Others International & Local Authorities.</p>
                </v-col>
                <v-col
                md="5"
                class="hidden-sm-and-down"
                >
                <v-img src="/asset/img/whoarewe/fire.jpg" height="125" ></v-img>
                </v-col>
            </v-row>
            <v-row class="mt-15">
                <v-col>
                    <h1 class="h3 red--text">OUR SERVICES</h1>
                </v-col>
            </v-row>
            <v-row class="mt-8">
                <v-col
                md="4"
                cols="12"
                class="fill-height"
                align="center"
                >
                 <v-card
                flat
                >
                    <v-img
                  src="/asset/img/services/Design-Drawing-min.jpg"
                  lazy-src="/asset/img/services/Design-Drawing-min.jpg"
                   height="250"
                    width="250"
                    ></v-img>
                <v-card-text>
                    <h1 class="h5">Design & Drawing</h1>
                </v-card-text>
                </v-card>
                </v-col>
                 <v-col
                md="4"
                cols="12"
                class="fill-height"
                align="center"
                >
                <v-card
                flat
                >
                    <v-img
                 src="/asset/img/services/FabricationInstallationTesting-Commissioning-min.jpg"
                 lazy-src="/asset/img/services/FabricationInstallationTesting-Commissioning-min.jpg"
                  height="250"
                    width="250"

                   ></v-img>
                <v-card-text>
                    <h1 class="h5">Fabrication, Installation, Testing & Commissioning</h1>
                </v-card-text>
                </v-card>

                </v-col>
                 <v-col
                md="4"
                cols="12"
                class="fill-height"
                align="center"
                >
                <v-card
                flat
                >
                    <v-img
                src="/asset/img/services/Annual-Maintenance-Services.jpg"
                lazy-src="/asset/img/services/Annual-Maintenance-Services.jpg"
                height="250"
                width="250"
                >
                </v-img>
                <v-card-text>
                    <h1 class="h5">Annual Maintenance Services</h1>
                </v-card-text>
                </v-card>
                </v-col>
            </v-row>
            <v-row class="mt-15">
                <v-col>
                    <h1 class="h3 red--text">OUR CLIENTS</h1>
                </v-col>
            </v-row>
            <div style="width:100%;margin:20px auto;height:400px" >
                <!-- Using the slider component -->
                <slider ref="slider" :options="client_options" @slide='slide' @tap='onTap' @init='onInit'>
                    <!-- slideritem wrapped package with the components you need -->
                    <slideritem v-for="(item,index) in clients" :key="index" style=" width: 23.5%;,
                        margin-right: 2%">
                        <v-img :src="item.img"></v-img>
                    </slideritem>
                    <!-- Customizable loading -->
                    <div slot="loading">loading...</div>
                </slider>
            </div>
         <v-row class="mt-15">
                <v-col>
                    <h1 class="h3 red--text">OUR BANDS</h1>
                </v-col>
            </v-row>
             <div style="width:100%;margin:20px auto;height:400px" >
                <!-- Using the slider component -->
                <slider ref="slider" :options="brand_options" @slide='slide' @tap='onTap' @init='onInit'>
                    <!-- slideritem wrapped package with the components you need -->
                    <slideritem v-for="(item,index) in brands" :key="index" style=" width: 23.5%;,
                        margin-right: 2%">
                        <v-img
                        :src="item.img"
                        >
                        </v-img>
                    </slideritem>
                    <!-- Customizable loading -->
                    <div slot="loading">loading...</div>
                </slider>
            </div>


        </v-container>
            <Footer></Footer>
         <!--main contant end-->
    </v-app>
</template>

<script>
import { slider, slideritem } from 'vue-concise-slider'
import Footer from "./sitefooter";
    export default {
       name:'home',
       data(){
           return{
            clients:[
                {
                        img:'/asset/img/client/SMC.jpg',
                },
                {
                        img:'/asset/img/client/BAT.jpg',
                },
                {
                        img:'/asset/img/client/Yunusco.jpg',
                },
                {
                        img:'/asset/img/client/SMC.jpg',
                },
                {
                        img:'/asset/img/client/BAT.jpg',
                },
                {
                        img:'/asset/img/client/Yunusco.jpg',
                },
                    {
                        img:'/asset/img/client/SMC.jpg',
                },
                    {
                        img:'/asset/img/client/BAT.jpg',
                }
            ],
     client_options: {
        currentPage: 0,
        tracking: false,
        thresholdDistance: 100,
        thresholdTime: 300,
        loop:true,
        loopedSlides:4,
        slidesToScroll: 1,
        autoplay:5000,
     },
       brands:[
                {
                        img:'/asset/img/client/SMC.jpg',
                },
                {
                        img:'/asset/img/client/BAT.jpg',
                },
                {
                        img:'/asset/img/client/Yunusco.jpg',
                },
                {
                        img:'/asset/img/client/SMC.jpg',
                },
                {
                        img:'/asset/img/client/BAT.jpg',
                },
                {
                        img:'/asset/img/client/Yunusco.jpg',
                },
                    {
                        img:'/asset/img/client/SMC.jpg',
                },
                    {
                        img:'/asset/img/client/BAT.jpg',
                }
            ],
     brand_options: {
        currentPage: 0,
        tracking: false,
        thresholdDistance: 100,
        thresholdTime: 300,
        loop:true,
        loopedSlides:4,
        slidesToScroll: 1,
        autoplay:5000,
     },
               nmobienav:false,
            items: [
                { title: 'Click Me' },
                { title: 'Click Me' },
                { title: 'Click Me' },
                { title: 'Click Me 2' },
            ],
            images:[
                {
            src: '/asset/img/slider/Slide-1.png',
          },
          {
            src: '/asset/img/slider/Slide-1.png',
          },
          {
            src: '/asset/img/slider/Slide-1.png',
          },
          {
            src: '/asset/img/slider/Slide-1.png',
          },
            ]
           }
       },
       methods:{

       },
       components: {
        slider,
        slideritem,
        Footer
    }
}
</script>
<style scoped>
.footerabout ,.whoarewe{
    text-align: justify;
}
</style>
