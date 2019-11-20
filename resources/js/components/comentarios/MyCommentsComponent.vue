<template>
  <div class="component">
    <div class="comments-list">
      <comments-component
        id="comment"
        v-for="(comment, index) in comments"
        :key="comment.id"
        :comment="comment"
        @update="updateComment(index, arguments)"
        @delete="deleteComment(index)"
      />
    </div>

    <div class="barraComment">
      <form-component @new="addComment" />
    </div>
  </div>
</template>
<script>
import axios from "axios";
import commentsComponent from "./commentsComponent.vue";
import FormComponent from "./FormComponent.vue";
export default {
  components: {
    FormComponent,
    commentsComponent
  },
  data() {
    return {
      comments: [],
      collection_Id: this.$route.params.collectionId
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    addComment(comment) {
      // this.comments.isAuthor=true;
      this.comments.unshift(comment);
    },
    getData() {
      axios.get("/api/comments/" + this.collection_Id).then(response => {
        const comments = [];
        for (let comment in response.data) {
          comments.unshift(response.data[comment]);
        }
        this.comments = comments;
      });
    },
    deleteComment(index) {
      this.comments.splice(index, 1);
    },
    updateComment(index, comment) {
      console.log(index);
      this.comments[index] = comment;
    }
  }
};
</script>

<style scoped>
.barraComment {
  width: 100%;
  position: fixed;
  bottom: 0px;
  left: 0px;
  z-index: 100;
  background-color: white;
  box-shadow: 3px -1px 10px rgba(34, 34, 34, 0.16);
  padding: 0.5em;
}
.comments-list {
  margin-top: 1em;
}
</style>

