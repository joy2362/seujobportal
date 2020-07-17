<template>
    <v-app>
        <v-container
            class="fill-height"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    md="4"
                    cols="12"
                >
                    <v-card>
                        <v-toolbar
                            flat
                            dark
                            class="blue lighten-1"
                        >
                            <v-toolbar-title class="text-uppercase ">You are</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text class="text-center">
                            <v-btn
                                small
                                text
                                to="/faculty/registion"
                            >Facuty</v-btn>
                            <v-btn
                                small
                                text
                                to="/alumni/registion"
                            >Alumni</v-btn>
                            <v-btn
                                small
                                text
                                to="/student/registion"
                            >Student</v-btn>
                        </v-card-text>
                        <v-card-text class="text-center">
                            <p >Already have account?
                            <v-btn small text to="/">Login</v-btn>
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        name: "registation",
    }
</script>

<style scoped>

</style>
