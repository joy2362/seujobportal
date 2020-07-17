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
                <v-card-title>
                    Wellcome {{user.name}}
                </v-card-title>
                <v-card-text>
                    <v-img
                        :src="user.image"
                        height="150px"
                        width="150px"
                    >
                    </v-img>
                </v-card-text>
                <v-card-text>
                    <p >
                        {{user.email}}
                    </p>
                </v-card-text>
                <v-card-action>
                    <v-btn depressed small text to='/logout'>
                        <span>logout </span>
                    </v-btn>
                </v-card-action>
            </v-card>
                </v-col>
            </v-row>

        </v-container>
    </v-app>
</template>
<script>
    import User from "../helper/User";
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
            }


        }
    },
}
</script>
<style scoped>

</style>
