<template>
  <div class="card">
    <div v-on:click="deleteOnClick()" v-if="collection.author" class>
      <DeleteButton :collection="collection" />
    </div>
    <div class="card-header title">
      {{collection.name}}
      {{collection.id}}
    </div>
    <router-link :to="{name:'collection', params:{collectionId: collection.id}}">
      <img
        class="card-img-top"
        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTb2uP4V6vxSK235Y88V8C8nQSoe13BnzWzs_VIzNLW2ppA1KeN&s"
        alt
      />
    </router-link>
    <div class="footer">
      <div class="likes">
        <LoveComponent :collection="collection"></LoveComponent>
      </div>
      <div v-if="collection.author" class="likes">
        <EditButton :collection="collection" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import LoveComponent from "./buttons/LoveComponent";
import EditButton from "./buttons/EditButton";
import DeleteButton from "./buttons/DeleteButton";

export default {
  components: {
    LoveComponent,
    EditButton,
    DeleteButton
  },
  props: ["collection"],
  methods: {
    deleteOnClick() {
      axios
        .delete(`/api/collection/${this.collection.id}`)
        .then(this.$emit("delete"));
    }
  }
};
</script>

<style scoped>
.collection-card {
  box-shadow: 3px 3px 10px grey;
  max-width: 250px;
  height: 200px;
  display: flex;
  justify-content: space-between;
  border-radius: 1em;
}

.title {
  width: 100%;
  padding: 0.8em;
  border-bottom: 1px solid black;
}
.image {
  width: 160px;
  height: 160px;
  background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTb2uP4V6vxSK235Y88V8C8nQSoe13BnzWzs_VIzNLW2ppA1KeN&s");

  background-size: cover;
  background-position: center;
}
.footer {
  width: 100%;
  padding: 0.8em;
  border-top: 1px solid black;
}
</style>
