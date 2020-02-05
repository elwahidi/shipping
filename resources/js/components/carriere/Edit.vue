<template>
    <div>
        <div class="alert alert-success" v-if="updated">
            <h3>Data Updated succefully</h3>
        </div>
        <h3>Edit Post Page</h3>
        <div class="form-group">
            <label class="label" for="title">Title</label>
            <input :class="['input form-control',{'is-danger':errors.title}]" id="title"   type="text" placeholder="Title" v-model="offer.title" >
            <small v-if="errors.title">{{errors.title[0]}}</small>
        </div>
        <div class="form-group">
            <label class="label" for="text">Text</label>

            <textarea  id="text" :class="[{'is-danger':errors.text},'input form-control']"  placeholder="Text" v-model="offer.text"></textarea>
            <small v-if="errors.text">{{errors.text[0]}}</small>
        </div>
        <div class="form-group" >

            <div><h3>Activities</h3></div>
            <div v-for="(act,index) in activities">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" :id="'act'+act.id" v-model="offer.activity_id" :value="act.id"  >
                    <label class="form-check-label" :for="'act'+act.id">{{act.title}}</label>
                </div>
            </div>
            <small v-if="errors.text">{{errors.activity_id[0]}}</small>


        </div>

            <button class="btn btn-primary is-success" @click="save">Save</button>

    </div>
</template>

<script>
    export default{
        props: ['offerId'],
        data(){
            return{
                list:{
                    title:'',
                    text:'',
                    activity_id:'',
                },
                errors:{},
                activities:'',
                offer:{},
                isChecked:true,
                updated:false
            }
        },
        created(){
          this.getAllActivities();
        },
        mounted(){
            this.fetchOffer();
        },
        methods:{
            save(){

                axios.put('/offer/update',{
                    'id':this.offer.id,
                    'title':this.offer.title,
                    'text':this.offer.text,
                    'activity_id':this.offer.activity_id
                })
                    .then(
                        (response)=> {
                            console.log(response.data)
                            if(response.data == 'update-success'){
                                this.updated = true;
                            }
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
            },
            fetchOffer() {
                axios.get('/offer/edit/'+this.offerId)
                    .then(
                        response => {this.offer = response.data;}
                    ).catch(error => console.log('Has error'));
            },

        }
    }
</script>