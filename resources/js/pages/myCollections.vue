<template>
  <div>
    <h4>myCollections</h4>

    <div class="collection-list">
      <CollectionCard
        v-for="(collection, index) in collections"
        :key="collection.id"
        :collection="collection"
        @delete="deleteCollection(index)"
      />
    </div>
  </div>
  <!-- <CollectionCard /> -->
</template>

<script>
import axios from "axios";
import CollectionCard from "../components/CollectionCard";

export default {
  middleware: "auth",

  components: {
    CollectionCard
  },

  data() {
    return {
      collections: []
    };
  },
  beforeMount() {
    this.importCollectionsData();
  },

  methods: {
    importCollectionsData(id) {
      axios.get("/api/mycollections").then(response => {
        this.collections = response.data;
        console.log(response.data);
      });
    },
    deleteCollection(index) {
      this.collections.splice(index, 1);
    }
  }
};
</script>

<style lang="scss">
.collection-list {
  // width: 90%;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1em;
  margin-top: 1.5em;
}
</style>
