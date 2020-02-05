<template>
    <div>
        <div class="alert alert-success" v-if="updated">
            <h3>Data Updated succefully</h3>
        </div>
    <form class="form-group" enctype="multipart/form-data" @submit.prevent="save()">

        <h3>Edit Post Page</h3>
        <div class="form-group">
            <label class="label" for="title">Title</label>
            <input :class="['input form-control',{'is-danger':errors.title}]" id="title"   type="text" placeholder="Title" v-model="list.title" >
            <small v-if="errors.title">{{errors.title[0]}}</small>
        </div>
        <div class="form-group">
            <label class="label" for="text">Text</label>

            <textarea  id="text" :class="[{'is-danger':errors.text},'input form-control']"  placeholder="Text" v-model="list.text"></textarea>
            <small v-if="errors.text">{{errors.text[0]}}</small>
        </div>
        <div class="form-group">
            <label class="label" for="img">Image</label>
            <img :src="previewImage" class="uploading-image"  width="150px"/>

            <input @change="uploadImage($event)" type="file" id="img" :class="[{'is-danger':errors.text},'input form-control']"  placeholder="img" >
            <small v-if="errors.text">{{errors.text[0]}}</small>
        </div>
        <div class="form-group" >

            <div><h3>Categories</h3></div>
            <div v-for="(cats,index) in categories">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" :id="'cat'+cats.id" :value="cats.id" v-model="list.categories">
                    <label class="form-check-label" :for="'cat'+cats.id">{{cats.title}}</label>
                </div>
            </div>


        </div>

            <button class="btn btn-primary is-success">Save</button>
        </form>
    </div>
</template>

<script>
    export default{
        props: ['postId'],
        data(){
            return{
                list:{
                    title:'',
                    text:'',
                    categories:[],
                    img:'',
                },
                previewImage:null,
                errors:{},
                categories:'',
                post:{},
                isChecked:true,
                updated:false
            }
        },
        created(){
          this.getAllCategories();
        },
        mounted(){
            this.fetchPost();
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
                myFormData.append('id',"id");
                myFormData.append('title',this.list.title);
                myFormData.append('text',this.list.text);
                myFormData.append('categories',this.list.categories);
                myFormData.append('img', this.list.img);
                axios.put('/post/update',{
                    'id':this.post.id,
                    'title':this.list.title,
                    'text':this.list.text,
                    'categories':this.list.categories,
                })
                .then(
                    (response)=> {
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
            getAllCategories(){
                axios.get('/categories').then(
                    (response)=>{
                        this.categories = response.data
                    }
                ).catch(
                    (error)=>{
                    }
                );
            },
            fetchPost() {
                axios.get('/post/edit/'+this.postId)
                    .then(
                        response => {this.post = response.data;
                        this.list.title = this.post.title;
                        this.list.text = this.post.text;
                        this.previewImage = '/storage/'+response.data.img;
                        }
                    ).catch(error => console.log());
            },

        }
    }
</script>