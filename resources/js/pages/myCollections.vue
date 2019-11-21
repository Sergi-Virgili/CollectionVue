<template>
  <div>
    <h4>myCollections</h4>

    <div class="collection-list mb-5">
      <CollectionCard
        v-for="(collection, index) in collections"
        :key="collection.id"
        :collection="collection"
        @delete="deleteCollection(index)"
      />
    </div>
    <div class="newCollection">
      <router-link :to="{ name: 'collectionNew' }">+</router-link>
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
.newCollection {
  position: fixed;
  bottom: 0px;
  left: 0px;
  padding: 0.2em;
  width: 100%;
  display: flex;
  justify-content: center;
  background-color: white;
  box-shadow: -5px -5px 5px rgba(162, 162, 162, 0.243);
  font-size: 1.5em;
}
</style>
