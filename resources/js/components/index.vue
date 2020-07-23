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
                                        v-model="keyword"
                                        label="Keyword"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    md="3"
                                >
                                    <v-select
                                        dark
                                        v-model="select"
                                        :items="items"
                                        label="Location"
                                        required
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
                <span  class="font-weight-light h1 red--text">Browse <span class="font-weight-black">Top Sectors</span></span>
            </v-col>
        </v-row>
        <v-row class="mt-8">
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                        class="pt-3"
                    >
                        <v-img
                            src="/asset/img/others/graphic-designer.png"
                            lazy-src="/asset/img/others/graphic-designer.png"
                            height="100"
                            width="100"
                        ></v-img>
                        <v-card-text>
                            <h1 class="h5">Web Designer</h1>
                            <p class="subtitle-1">512</p>
                        </v-card-text>
                    </v-card>
                </v-hover>
            </v-col>
            <v-col
                md="3"
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
                    class="pt-3"
                >
                    <v-img
                        src="/asset/img/others/graphic-designer.png"
                        lazy-src="/asset/img/others/graphic-designer.png"
                        height="100"
                        width="100"
                    ></v-img>
                    <v-card-text>
                        <h1 class="h5">Web Designer</h1>
                        <p class="subtitle-1">512</p>
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
                    <span  class="font-weight-light h1 red--text">RECENT  <span class="font-weight-black">JOBS</span></span>
                </v-col>
            </v-row>
            <v-row  class="mt-10">
                <v-col
                cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                src="asset/img/others/job/job-list3.png"
                                >

                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                    <v-list-item-title class=" mb-1">
                                        <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                        >
                                            Digital Marketer
                                        </v-btn>

                                    </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                       Full time
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >

                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
                                    </v-chip>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-parallax
            class="mt-15"
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
                    <span  class="font-weight-light h1 red--text">Featured  <span class="font-weight-black">Jobs</span></span>
                </v-col>
            </v-row>
            <v-row  class="mt-10">
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >

                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >

                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
                                    </v-chip>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Digital Marketer
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        Full time
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
            <v-row  class="mt-10">
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Customer Service Master Class
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        01/09/2020
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Customer Service Master Class
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        01/09/2020
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Customer Service Master Class
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-timetable</v-icon>
                                        01/09/2020
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </v-list-item>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                >
                    <v-card
                        outlined
                    >
                        <v-list-item three-line>
                            <v-list-item-avatar
                                tile
                                size="80"
                            >
                                <v-img
                                    src="asset/img/others/job/job-list3.png"
                                >
                                </v-img>
                            </v-list-item-avatar>
                            <v-list-item-content
                            >
                                <v-list-item-title class=" mb-1">
                                    <v-btn
                                        text
                                        to="/"
                                        class="headline"
                                    >
                                        Customer Service Master Class
                                    </v-btn>

                                </v-list-item-title>
                                <v-list-item-subtitle
                                >
                                    <v-chip
                                        class="ma-2"
                                    >
                                        Creative Agency
                                    </v-chip>
                                    <v-chip
                                        class="ma-2"
                                    >
                                        <v-icon left>mdi-map-marker</v-icon>
                                        Dhaka, Bangladesh
                                    </v-chip>
                                    <v-chip
                                    class="ma-2"
                                >
                                    <v-icon left>mdi-timetable</v-icon>
                                    01/09/2020
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
                    <v-btn
                        x-large
                        color="info "
                        outlined
                        dark
                    >
                        Browse All Events
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <bottom-footer></bottom-footer>
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
            this.$router.push({name:'login'});
        }

    },
    data(){
        return {
            user:{
                name:User.name(),
                email:User.email(),
                image:User.picture(),
            },
            items: [
                'Item 1',
                'Item 2',
                'Item 3',
                'Item 4',
            ],
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
