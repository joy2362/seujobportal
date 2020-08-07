<template>

</template>

<script>
    import User from "../../helper/User";
    export default {
        name: "logout",
        created() {
            User.logout();
            this.$router.push({name:'login'});
        },
    }
</script>

<style scoped>

</style>
