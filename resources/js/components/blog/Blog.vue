<template>
    <div>
        <h3>Posts page</h3>
        <div class="mb-3 text-right">
            <router-link to="/post/add" class="btn btn-secondary pull-right">Add new post</router-link>
        </div>
        <div v-for="(post,index) in posts" :key="index">
            <div class="card mb-3">
                <div class="card-body">
                    <img v-if="post.img != null" :src="'/storage/'+ post.img" class="card-img-top" alt="" style="width: 150px">
                    <h3 class="card-title">{{post.title}}</h3>
                    <p class="card-text">{{post.text.substr(0,200)}}</p>
                        <div class="text-muted">
                            Categorie:
                            <span v-for="(category,index) in post.categories">
                            <span class="badge badge-secondary ml-1 p-2">{{category.title.substr(0,10)}}</span>
                        </span>
                        </div>
                        <div class="text-muted mt-2">
                            Crée par: <span class="badge badge-secondary ml-1 p-2">{{post.created_by.name}}</span>
                        </div>
                    <div class="d-flex justify-content-start mt-2">
                        <div class="text-muted mt-1 mr-2" v-if="post.published_by != null" ref="tt" >
                            Publié par: <span class="badge badge-secondary ml-1 p-2 " >{{post.published_by.name}}</span>
                            <div :id="'publishedsuccess'+post.Uuid" ></div>
                        </div>

                        <div class="text-muted mr-2" v-else>
                            <a href="javascript:;" v-on:click="publishPost(post.Uuid, index)" :id="'publish'+post.Uuid" class="btn btn-success mt-1">Publish</a>
                        </div>
                        <div class="mr-2 float-right"><router-link :to="{path:'/post/edit/'+post.Uuid,params: { 'postId':post.Uuid }}" class="btn btn-primary mt-1">Edit</router-link></div>
                        <div class="mr-2 float-right"><a href="javascript:;" v-on:click="deletePost(post.Uuid, index)" class="btn btn-danger mt-1">Delete</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                posts:{}
            }
        },
            created(){
                this.getPosts();
            },
            methods:{
                getPosts(){
                    axios.get('/posts').then(res => {
                        this.posts = res.data
                    }).catch(err => {
                    })
                },
                deletePost(postid,index){
                    axios.delete('/post/delete/'+postid)
                        .then(resp => {
                            if(resp.data == true)
                                this.posts.splice(index, 1)
                        })
                        .catch(error => {
                        })
                },
                publishPost(postid,index){
                    axios.post('/post/publish/'+postid)
                        .then(resp => {
                            if(resp.data == true){
                                this.posts[index].published_by = {
                                    name : 'Vous meme'
                                };
                            }
                        })
                        .catch(error => {
                        })
                }
            }
    }
</script>

