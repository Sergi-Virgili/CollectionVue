<template>
  <div>
    <h2>my favorites</h2>
    <div class="collection-list">
      <CollectionCard
        v-for="(collection, index) in collections"
        :key="collection.id"
        :collection="collection"
        class
        @delete="deleteCollection(index)"
        @deleteFavorite="deleteFavorites(index)"
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
    });
  },
  methods: {
    deleteFavorites(index) {
      console.log(index);
      this.collections.splice(index, 1);
    }
  }
};
</script>
<style>
.collection-list {
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1em;
}
</style>
