<template>
  <div class="card">
    <router-link :to="{ name: 'collection', params: { collectionId: collection.id } }">
      <div class="collection-image">
        <div
          class="collection-image-in"
          :style="{ backgroundImage: 'url(' + collection.img_url + ')' }"
        ></div>
      </div>
    </router-link>
    <div class="footer">
      <div class="title">{{ collection.name }}</div>

      <div class="card-buttons">
        <div class="likes">
          <LoveComponent
            :collection="collection"
            @loveIt="loveIt()"
            @dontLove="dontLove()"
            :loved="loved"
            :likes="likes"
          ></LoveComponent>
        </div>
        <router-link
          :to="{
            name: 'collectionEdit',
            params: { collectionId: collection.id }
          }"
        >
          <div v-if="collection.author" class="edit-button">
            <EditButton :collection="collection" />
          </div>
        </router-link>
        <div v-on:click="deleteOnClick()" v-if="collection.author" class>
          <TrashButton :collection="collection" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import LoveComponent from "./buttons/LoveComponent";
import EditButton from "./buttons/EditButton";
import DeleteButton from "./buttons/DeleteButton";
import TrashButton from "./buttons/TrashButton";

export default {
  data() {
    return {
      loved: false,
      likes: 0
    };
  },
  mounted() {
    this.isLovedOrLiked();
  },
  components: {
    LoveComponent,
    EditButton,
    DeleteButton,
    TrashButton
  },
  props: ["collection"],

  methods: {
    deleteOnClick() {
      axios
        .delete(`/api/collection/${this.collection.id}`)
        .then(this.$emit("delete"));
    },
    loveIt() {
      const collectionId = this.collection.id;
      const params = {
        id: collectionId
      };
      axios
        .post(`/api/user/${this.collection.id}/attach`, params)
        .then(response => {
          this.loved = true;
          this.likes = this.likes + 1;
        });
    },
    dontLove() {
      const collectionId = this.collection.id;
      const params = {
        id: collectionId
      };
      axios
        .delete(`/api/user/${this.collection.id}/detach`, { data: { params } })
        .then(response => {
          this.loved = false;
          this.likes = this.likes - 1;
          this.$emit("deleteFavorite");
        });
    },
    isLovedOrLiked() {
      this.loved = this.collection.loved;
      this.likes = this.collection.likes;
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
  /* background-color: #f3f3f3 */
}

.card {
  box-shadow: 5px 4px 7px rgba(0, 0, 0, 0.2);
}

.title {
  width: 100%;
  padding: 0.8em;
  text-align: center;
}
.collection-image {
  /* width: 250px; */
  height: 200px;
  overflow: hidden;
}
.collection-image-in {
  /* width: 250px; */
  height: 100%;
  width: 100%;
  background-position: center;
  background-size: cover;
  transition: all 0.9s ease-out;
}
.collection-image-in:hover {
  transform: scale(1.2);
}
.footer {
  width: 100%;
  padding: 0.8em;
  border-top: 1px solid black;
}
.card-buttons {
  display: flex;
  justify-content: space-between;
  padding: 0;
}
.edit-button {
  position: absolute;
  top: -10px;
  right: -10px;
  border-radius: 50%;
  background-color: white;
  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
  border: solid 1px rgba(222, 222, 222, 0.4);
}
</style>
