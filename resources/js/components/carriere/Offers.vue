<template>
    <div>
        <h3>Offers page</h3>
        <div class="mb-3 text-right">
            <router-link to="/offer/add" class="btn btn-secondary pull-right">Add new offer</router-link>
        </div>
        <div v-for="(offer,index) in offers" :key="index">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">{{offer.title}}</h3>
                    <p class="card-text">{{offer.text.substr(0,200)}}</p>
                    <div class="text-muted">
                        Secteur d'activité:

                         <span class="badge badge-secondary ml-1 p-2">{{offer.activity.title}}</span>

                    </div>
                    <div class="text-muted mt-2">
                        Crée par: <span class="badge badge-secondary ml-1 p-2">{{offer.created_by.name}}</span>
                    </div>


                    <div class="d-flex justify-content-start mt-2 ">
                        <div  class="text-muted " v-if="offer.published_by != null" >
                            Publié par: <span class="badge badge-secondary ml-1 p-2 mr-2 " >{{offer.published_by.name}}</span>
                            <div :id="'publishedsuccess'+offer.id" ></div>
                        </div>
                        <div class="text-muted" v-else>
                            <p><a href="javascript:;" v-on:click="publishOffer(offer.id, index)" :id="'publish'+offer.id" class="btn btn-success mt-1 mr-2">Publish</a></p>
                        </div>
                        <div><router-link :to="{path:'/offer/edit/'+offer.id,params: { 'offerId':offer.id }}" class="btn btn-primary mt-1 mr-2">Edit</router-link></div>
                        <div><a href="javascript:;" v-on:click="deleteOffer(offer.id, index)" class="btn btn-danger mt-1 mr-2">Delete</a></div>
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
                offers:{}
            }
        },
        created(){
            this.getOffers();
        },
        methods:{
            getOffers(){
                axios.get('/offers').then(res => {
                    this.offers = res.data
                    console.log(res)
                }).catch(err => {
                    console.log(err)
                })
            },
            deleteOffer(offerid,index){
                axios.delete('/offer/delete/'+offerid)
                    .then(resp => {
                        if(resp.data == true)
                            this.offers.splice(index, 1)
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            publishOffer(offerid,index){
                axios.post('/offer/publish/'+offerid)
                    .then(resp => {
                        if(resp.data == true){
                            this.offers[index].published_by = {
                                name : 'Vous meme'
                            };
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>

