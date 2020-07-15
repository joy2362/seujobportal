<template>

</template>

<script>
    import User from "../../helper/User";
    export default {
        name: "logout",
        created() {
            User.logout();

            Toast.fire({
                icon: 'success',
                title: 'Signed up successfully'
            })
            this.$router.push({name:'home'});
        },
    }
</script>

<style scoped>

</style>
