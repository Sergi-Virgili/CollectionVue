<template>
<div>
  <h4>{{user.name}}'s Collections</h4>
    <div class="collection-list">
        <CollectionCard
            v-for='(collection, index) in collections'
            :key="collection.id"
            :collection='collection'
            class=""
            @delete = "deleteCollection(index)" />


    </div>

</div>

</template>

<script>
import axios from 'axios'
import CollectionCard from '../components/CollectionCard'

export default {
    middleware: 'auth',

    components: {
      CollectionCard,
    },

    data()  {
        return {
            collections: [],
            user: {},
        }
    },
    mounted() {
        this.userCollections();
        this.getUser();
    },




    methods: {

        userCollections(){
            axios.get(
            `/api/userCollections/${this.$route.params.user.id}`)
                .then( (response) =>
                {

                    this.collections = response.data;}
                )
        },
        deleteCollection(index){
            this.collections.splice(index,1)
        },
        getUser(){
            this.user = this.$route.params.user;
        }
    }

}
</script>

<style lang='scss'>

    .collection-list {
       // width: 90%;
        margin: 0 auto;
        display: grid;
        grid-template-columns:  1fr 1fr;
        gap:1em;
        margin-top: 1.5em;
    }

</style>