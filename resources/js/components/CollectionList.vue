<template>

      <transition name="fade" mode="out-in" >
<div>

    <div class="collection-list">
        <CollectionCard
            v-for='(collection, index) in collections'
            :key="collection.id"
            :collection='collection'
            class=""
            @delete = "deleteCollection(index)" />

    </div>
</div>
    </transition>
    <!-- <CollectionCard /> -->

</template>

<script>
import axios from 'axios'
import CollectionCard from './CollectionCard'

export default {
    props: {
        categoryId: Number,
    },
    components: {
      CollectionCard,
    },

    data()  {
        return {
            collections: [],
        }
    },
    mounted() {

        this.importCategoryData(this.categoryId);


    },


    watch: {
        categoryId: function () {
            this.importCategoryData(this.categoryId);
        },
    },
    methods: {

        importCategoryData(id){
            axios.get(
            `/api/category/collections/${id}`)
                .then( (response) =>
                {

                    this.collections = response.data
                })
        },
        deleteCollection(index){
            this.collections.splice(index,1)
        },
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
    }
    fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
         opacity: 0;
    }

</style>
