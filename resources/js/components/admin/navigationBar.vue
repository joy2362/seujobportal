<template>
    <div>
        <v-container >
            <v-toolbar  flat >
                <v-toolbar-items >
                    <v-app-bar-nav-icon  @click="sideMenu = !sideMenu"></v-app-bar-nav-icon>
                </v-toolbar-items>
                <v-toolbar-title class="text-uppercase red--text">
                    <span  class="font-weight-light">Admin<span class="font-weight-black">Panel</span></span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items >
                    <v-menu  offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-avatar
                                size="52"
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-img
                                    :src="'/'+user.pro_pic"
                                >
                                </v-img>
                            </v-avatar>
                        </template>
                        <v-list>
                            <v-list-item
                                to="/admin/profile"
                            >
                                <v-list-item-title>
                                    <v-icon left>
                                        mdi-account
                                    </v-icon>
                                    Profile
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                to="/admin/setting"
                            >
                                <v-list-item-title>
                                    <v-icon left>
                                        mdi-tune
                                    </v-icon>
                                    Setting</v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                to="/logout"
                            >
                                <v-list-item-title>
                                    <v-icon left>mdi-exit-to-app</v-icon>
                                    Logout
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                </v-toolbar-items>
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
                        to="/admin/home"
                    >
                        <v-list-item-icon>
                            <v-icon>mdi-view-dashboard</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Dashboard</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        to='/admin/category'
                    >
                        <v-list-item-icon>
                            <v-icon>mdi-reorder-horizontal</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Category</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-group
                        prepend-icon="mdi-briefcase"
                    >
                        <template v-slot:activator>
                            <v-list-item-title>Job Post</v-list-item-title>
                        </template>
                        <v-list-item
                            to='/admin/job/add'
                        >
                            <v-list-item-content>
                                <v-list-item-title>Add new</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-item
                            to='/admin/job/all'
                        >
                            <v-list-item-content>
                                <v-list-item-title>All Job</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                    </v-list-group>
                     <v-list-group
                        prepend-icon="mdi-calendar-plus"
                    >
                        <template v-slot:activator>
                            <v-list-item-title> Event </v-list-item-title>
                        </template>
                        <v-list-item
                            to='/admin/event/add'
                        >
                            <v-list-item-content>
                                <v-list-item-title>Add new</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-item
                            to='/admin/event/all'
                        >
                            <v-list-item-content>
                                <v-list-item-title>All Event</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                    </v-list-group>
                    <v-list-group
                        prepend-icon="mdi-account-check"
                    >
                        <template v-slot:activator>
                            <v-list-item-title> Admins </v-list-item-title>
                        </template>
                        <v-list-item
                            to='/admin/add'
                        >
                            <v-list-item-content>
                                <v-list-item-title>Add new</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-item
                            to='/admin/all'
                        >
                            <v-list-item-content>
                                <v-list-item-title>All Admin</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                    </v-list-group>
                </v-list>
            </v-navigation-drawer>
        </v-container>
    </div>
</template>

<script>
    import User from "../../helper/User";

    export default {
        name: "navigationBar",
        props:['user'],
        data(){
            return{
                sideMenu:false,
            }
        },

    }
</script>

<style scoped>
a:hover{
    text-decoration:none;
}
</style>
