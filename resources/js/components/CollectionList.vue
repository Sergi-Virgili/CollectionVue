<template>
  <div class>
    <transition name="fade" mode="out-in">
      <div class="row">
        <CollectionCard
          class="col-md-4 col-xl-3"
          v-for="(collection, index) in collections"
          :key="collection.id"
          :collection="collection"
          @delete="deleteCollection(index)"
        />
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";
import CollectionCard from "./CollectionCard";

export default {
  props: {
    categoryId: Number,
  },
  components: {
    CollectionCard,
  },

  data() {
    return {
      collections: [],
    };
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
    importCategoryData(id) {
      axios.get(`/api/category/collections/${id}`).then((response) => {
        this.collections = response.data;
      });
    },
    deleteCollection(index) {
      this.collections.splice(index, 1);
    },
  },
};
</script>

<style lang='scss'>
</style>
