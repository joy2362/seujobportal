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
                md="6"
                cols="12"
            >
                <v-card
                    outlined
                >
                    <v-list-item >
                        <v-list-item-avatar
                            tile
                            size="140"
                        >
                            <v-img
                                src="/asset/img/others/404/emoji.png"
                            >
                            </v-img>
                        </v-list-item-avatar>
                        <v-list-item-content
                        >
                            <v-list-item-title class=" font-weight-black" >
                               <h1  >404</h1>
                            </v-list-item-title>
                            <v-list-item-title
                            >
                                <p> OOPS! PAGE NOT BE FOUND</p>
                                <v-btn
                                    to="/"
                                    class="primary"
                                >
                                    Back to homepage
                                </v-btn>
                            </v-list-item-title>

                        </v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</v-app>
</template>

<script>
export default {
    name: "error404"
}
</script>

<style scoped>

</style>
