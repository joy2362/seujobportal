<template>
    <v-container >
    <v-toolbar
        flat
    >
        <v-toolbar-items class="hidden-md-and-up">
            <v-app-bar-nav-icon  @click="sideMenu = !sideMenu"></v-app-bar-nav-icon>
        </v-toolbar-items>
        <v-toolbar-title >
            <v-img src="/asset/img/logo/seu_logo.png" width="70" height="70" ></v-img>
        </v-toolbar-title>
        <v-spacer></v-spacer>

        <v-toolbar-items class="hidden-sm-and-down">
            <v-btn depressed small text to='/home'>
                <span>Home</span>
            </v-btn>
            <v-btn  small text to='/all/job'>
                <span>Find a Job</span>
            </v-btn>
            <v-btn  small text to='/add/job' v-if=" user.user_type === '3' || user.user_type === '2' ">
                <span>Add Job</span>
            </v-btn>
            <v-btn  small text to='/add/event'v-if=" user.user_type === '3' || user.user_type === '2' ">
                <span>Add Event</span>
            </v-btn>
            <v-btn  small text to='/all/event'>
                <span>Event</span>
            </v-btn>
            <v-btn  small text to='/forum'>
                <span>Forum</span>
            </v-btn>
            <v-btn  small text to='/contact'>
                <span>Contact Us</span>
            </v-btn>
        </v-toolbar-items>

        <v-menu  offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-avatar
                    size="48"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-img
                        :src="'/'+user.pro_pic"
                    >
                    </v-img>
                </v-avatar>
            </template>
            <v-list
                color="blue-grey lighten-3"
                class="align-center"
            >

                <v-list-item
                   @click="profileSelect"
                >
                    <v-list-item-title>Profile</v-list-item-title>
                </v-list-item>
                <v-list-item
                    to="/user/favourite"
                >
                    <v-list-item-title>Favourit List</v-list-item-title>
                </v-list-item>
                <v-list-item
                    to="/user/setting"
                >
                    <v-list-item-title>Setting</v-list-item-title>
                </v-list-item>

                <v-list-item
                    to="/logout"
                >
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-menu>
    </v-toolbar>
        <v-navigation-drawer
            v-model="sideMenu"
            app
            temporary
        >
            <v-list nav>
                <v-list-item two-line :class=" 'px-0'">
                    <v-list-item-avatar>
                        <v-img
                            :src="'/'+user.pro_pic"
                        >
                        </v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>{{user.name}}</v-list-item-title>
                        <v-list-item-subtitle >Logged In</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>

                <v-list-item
                   to='/home'
                >
                    <v-list-item-content>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                    to='/add/job' v-if=" user.user_type === '3' || user.user_type === '2' "
                >
                    <v-list-item-content>
                        <v-list-item-title>Add Job</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                    to='/add/event'v-if=" user.user_type === '3' || user.user_type === '2' "
                >
                    <v-list-item-content>
                        <v-list-item-title>Add Event</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                    to='/all/event'
                >
                    <v-list-item-content>
                        <v-list-item-title>Event</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                     to='/forum'
                >
                    <v-list-item-content>
                        <v-list-item-title>Forum</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                    to='/contact'
                >
                    <v-list-item-content>
                        <v-list-item-title>Contact Us</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </v-container>
</template>

<script>
    export default {
        name: "topNavBar",
        props: ['user'],
        data(){
            return {
                sideMenu:false,
            }
        },
        methods:{
            profileSelect(){
                if (this.user.user_type){
                    this.$router.push({name:'userProfile'});
                }else{
                    this.$router.push({name:'adminauth'});
                }
            }
        }

    }
</script>

<style scoped>
a:hover{
    text-decoration:none;
}
</style>
