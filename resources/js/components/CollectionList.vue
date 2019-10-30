<template>
    <div class="collection-list">
        <CollectionCard v-for='collection in collections'
            :key="collection.index"
            :collection='collection' />
    </div>
    <!-- <CollectionCard /> -->

</template>

<script>
import axios from 'axios'
import CollectionCard from './CollectionCard'
export default {

    components: {
      CollectionCard,
    },
    props: [],
    data()  {
        return {
            collections: []
        }
    },
    mounted() {
        this.importCategoryData();
    },
    methods: {
        importCategoryData(){
            axios.get(
            `api/category/collections/1}`)
                .then( (response) =>
                {
                    console.log(response)
                    this.collections = response.data}
                )
        }
    }

}
</script>

<style>

    .collection-list {
        width: 90%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap:1em;
    }

</style>
