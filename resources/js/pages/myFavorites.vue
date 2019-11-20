<template>
  <div>
    <h1>Mis colecciones favoritas</h1>
    <div class="collection-list">
      <CollectionCard
        v-for="(collection, index) in collections"
        :key="collection.id"
        :collection="collection"
        class
        @delete="deleteCollection(index)"
        @deleteFavorite="deleteFavorite(index)"
      />
    </div>
  </div>
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
  mounted() {
    axios.get("/api/myFavorites").then(response => {
      this.collections = response.data;
      console.log(this.collections);
    });
  },
  methods: {
    deleteFavorites(index) {
      this.collections.splice(index, 1);
    }
  }
};
</script>
<style>
</style>