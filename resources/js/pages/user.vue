<template>
  <div>
    <div>
      <div class="profileImage"></div>
      <div>
        <div id="userName">
          <h3>{{user.name}}</h3>
        </div>
        <div id="email">
          <h5>{{user.email}}</h5>
        </div>
        <div id="numberCollectionsUpload"></div>
      </div>
      <div class="collection-list">
        <CollectionCard
          v-for="(collection) in collections"
          :key="collection.id"
          :collection="collection"
          class
        />
      </div>
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
  props: {},
  data() {
    return {
      user: [],
      authorId: Number,
      collections: []
    };
  },
  mounted() {
    this.authorId = this.$route.params.id;

    this.importUserData(this.authorId);
    console.log(this.authorId);
  },
  methods: {
    importUserData(id) {
      axios.get(`/api/user/${id}`).then(response => {
        this.user = response.data.user;
        this.collections = response.data.collections;
        console.log(response.data);
      });
    }
  }
};
</script>

<style>
</style>
