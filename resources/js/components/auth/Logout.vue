<template>
    <div>{{message}}</div>
</template>
<script>
    export default{
        data(){
          return{
              message:''
            }
        },
        mounted(){
            this.logOut();
        },
        methods:{
            logOut(){
                axios.get('/users/logout').then(
                    (response)=>{
                        if(response.data == 'logout')
                        window.location.href = "/";
//                        this.message = "You are Log Out !!"
                    }
                ).catch(
                    (error)=>{
                        console.log(error)
                        this.message = "Error"
                    }
                )
            }
        }
    }
</script>