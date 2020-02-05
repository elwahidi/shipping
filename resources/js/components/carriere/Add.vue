<template>
    <div>
        <h3>Add Offer Page</h3>
        <div class="form-group">
            <label class="label" for="title">Title</label>
            <input :class="['input form-control',{'is-danger':errors.title}]" id="title"   type="text" placeholder="Title" v-model="list.title">
            <small v-if="errors.title">{{errors.title[0]}}</small>
        </div>
        <div class="form-group">
            <label class="label" for="text">Text</label>

            <textarea  id="text" :class="[{'is-danger':errors.text},'input form-control']"  placeholder="Text" v-model="list.text"></textarea>
            <small v-if="errors.text">{{errors.text[0]}}</small>
        </div>

        <div class="form-group" >
            <div><h3>Activities</h3></div>
            <div v-for="(act,index) in activities">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" :id="'act'+act.id" :value="act.id" v-model="list.activity">
                    <label class="form-check-label" :for="'act'+act.id">{{act.title}}</label>
                </div>
            </div>



        </div>

            <button class="btn btn-primary is-success" @click="save">Save</button>

    </div>
</template>

<script>
    export default{
        data(){
            return{
                list:{
                    title:'',
                    text:'',
                    activity:'',
                },
                errors:{},
                activities:''
            }
        },
        created(){
          this.getAllActivities();
        },
        methods:{
            save(){
                axios.post('/offer/add',this.list)
                .then(
                    (response)=> {
                        console.log(response)
                        this.list = {
                            title:'',
                            text:'',
                            activity:'',
                        }
                        this.$router.push('/offers')
                }
                ).catch(
                (error)=>{
                    console.log(error)
                    this.errors = error.response.data.errors
                }
                );
            },
            getAllActivities(){
                axios.get('/activities').then(
                    (response)=>{
                        this.activities = response.data
                    }
                ).catch(
                    (error)=>{
                        console.log(error)
                    }
                );
            }

        }
    }
</script>