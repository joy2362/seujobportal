<template>
    <v-container >
    <v-toolbar
        flat
    >
        <v-toolbar-title >
            <v-img src="/asset/img/logo/seu_logo.png" width="70" height="70" ></v-img>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
            <v-btn depressed small text to='/home'>
                <span>Home</span>
            </v-btn>
            <v-btn  small text to='/'>
                <span>Find a Job</span>
            </v-btn>
            <v-btn  small text to='/'>
                <span>Event</span>
            </v-btn>
            <v-btn  small text to='/forum'>
                <span>Forum</span>
            </v-btn>
            <v-btn  small text to='/'>
                <span>Contact</span>
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
                        :src="user.image"
                    >
                    </v-img>
                </v-avatar>
            </template>
            <v-list>
                <v-list-item
                    to="/"
                >
                    <v-list-item-title>Profile</v-list-item-title>
                </v-list-item>
                <v-list-item
                    to="/"
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
    </v-container>
</template>

<script>
    export default {
        name: "topNavBar",
        props: ['user'],
    }
</script>

<style scoped>

</style>
