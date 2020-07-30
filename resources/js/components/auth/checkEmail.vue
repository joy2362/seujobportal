<template>
</template>

<script>


    export default {
        name: "checkEmail",
        created() {
            this.token = this.$route.params.token;
            axios.get('/api/email/verify/'+this.token)
                .then(res =>{
                    console.log(res);
                    Swal.fire(
                        'Success!',
                        res.data.msg,
                        'success'
                    )
                    this.$router.push({name:'login'});
                })
                .catch(error=>{
                    console.log(error);
                    Swal.fire(
                        'Sorry!',
                        error.response.data.msg,
                        'error'
                    )
                    this.$router.push({name:'login'});
                })
        },
        data(){
            return{
                token:'',
            }
        }
    }
</script>

<style scoped>

</style>
