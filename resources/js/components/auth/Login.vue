<template>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Login
            </div>
            <div class="card-body">
                {{message}}
                <div class="form-group">
                    <input type="email" placeholder="Email" v-model="email" class="form-control" >
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input type="password" placeholder="Password" v-model="password" class="form-control" >
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <button @click="login()" class="btn btn-primary" >Login</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default{
        data(){
            return{
                email:'',
                password:'',
                message : ''
            }
        },
        methods:{
            login(){
                axios.post('/users/login',{email:this.email,password:this.password})
                    .then(
                        (response)=>{
                            if(response.data.logged == true)
                                window.location.href = "/#/blog";
                            else this.message = 'data mismatch';
                        }
                    )
                    .catch(
                        (error)=>{
                            this.errors = error.response.data
                        }
                    )
            }
        }
    }
</script>