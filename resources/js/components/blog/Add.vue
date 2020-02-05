<template>
    <div>
        <form class="form-group" enctype="multipart/form-data" @submit.prevent="save()">
            <div>
                <h3>Add Post Page</h3>
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
                <div class="form-group">
                    <label class="label" for="img">Image</label>
                    <img :src="previewImage" class="uploading-image" width="150px" />

                    <input @change="uploadImage($event)" type="file" id="img" :class="[{'is-danger':errors.text},'input form-control']"  placeholder="img" >
                    <small v-if="errors.text">{{errors.text[0]}}</small>
                </div>
                <div class="form-group" >
                    <div><h3>Categories</h3></div>
                    <div v-for="(cats,index) in categories">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" :id="'cat'+cats.Uuid" :value="cats.Uuid" v-model="list.categories">
                            <label class="form-check-label" :for="'cat'+cats.Uuid">{{cats.title}}</label>
                        </div>
                    </div>


                </div>

                <button class="btn btn-primary is-success"  >Save</button>

            </div>
        </form>


    </div>
</template>

<script>
    export default{
        data(){
            return{
                list:{
                    title:'',
                    text:'',
                    img:'',
                    categories:[],
                },
                previewImage:null,
                errors:{},
                categories:''
            }
        },
        created(){
          this.getAllCategories();
        },
        methods:{
            uploadImage(e){
                const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.previewImage = e.target.result;
                };
                this.list.img = image;
            },
            save(){

                var myFormData = new FormData();

                myFormData.append('title',this.list.title);
                myFormData.append('text',this.list.text);
                //myFormData.append('categories',this.list.categories);
                myFormData.append('img',  this.list.img);
                for (var i = 0; i < this.list.categories.length; i++) {
                    myFormData.append('categories[]', this.list.categories[i]);
                }
                axios.post('/post/add',myFormData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(
                    (response)=> {
                        console.log(response)
                        this.list = {
                            title:'',
                            text:'',
                            img:'',
                            previewImage:'',
                            categories:[],
                        }
                        this.$router.push('/blog')
                }
                ).catch(
                (error)=>{
                    console.log(error)
                    this.errors = error.response.data.errors
                }
                );
            },
            getAllCategories(){
                axios.get('/categories').then(
                    (response)=>{
                        this.categories = response.data
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