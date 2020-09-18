<template>
        <v-row>
            <v-col
                class="grey darken-4 py-4 text-center white--text"
                cols="12"
            >
                Copyright &copy;{{ new Date().getFullYear() }} | Southeast University | All rights reserved | Developed with
                <v-icon color="red">mdi-heart</v-icon> by <v-btn text dark small href="#" target="_blank">
                Joy2362
            </v-btn>
            </v-col>
        </v-row>
</template>

<script>
    export default {
        name: "BottomFooter"
    }
</script>

<style scoped>
a:hover{
    text-decoration:none;
}
</style>
