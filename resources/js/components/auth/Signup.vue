<template>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Signup
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" placeholder="Fullname" v-model="name" :class="['form-control',{'is-danger':errors.title}]" >
                        <small v-if="errors.name">{{errors.name[0]}}</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="email" placeholder="Email" v-model="email" :class="['form-control',{'is-danger':errors.email}]" >
                        <small v-if="errors.email">{{errors.email[0]}}</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="password" placeholder="Password" v-model="password" :class="['form-control',{'is-danger':errors.password}]" >
                        <small v-if="errors.password">{{errors.password[0]}}</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <button @click="register()" class="btn btn-primary" >Register</button>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
    export default{
        data(){
            return{
                name:'',
                email:'',
                password:'',
                errors:{},
            }
        },
        methods:{
            register(){
                axios.post('/users/register',{name:this.name,email:this.email,password:this.password})
                    .then(
                        (response)=>{
                            if(response.data.logged == true){
                                //this.$router.push('/blog');
                                window.location.href = "/#/blog";
                            }
                        }
                    )
                    .catch(
                        (error)=>{
                            this.errors = error.response.data.errors
                        }
                    )
            }
        }
    }
</script>