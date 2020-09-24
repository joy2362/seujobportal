<template>

</template>

<script>
import User from "../helper/User";

export default {
name: "allEvent",
    created() {
        if (! User.loggedIn()){
            this.$router.push({name:'logout'});
        }
        if (!User.isExpired()){
            this.$router.push({name:'logout'});
        }
        if (!User.isverifiedAccount()){
            this.$router.push({name:'emailverify'});
        }
        this.checkEmail();
        this.fatchcategory();
        this.userData();
        this.fatchAllData();
    },
}
</script>

<style scoped>

</style>
