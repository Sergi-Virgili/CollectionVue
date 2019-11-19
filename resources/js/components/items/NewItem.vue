<template>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{newItem.name}}</h3>
      <input class="form-control" type="text" name="name" v-model="newItem.name" />
      <div @click="closeItem()">
        <CloseButton />
      </div>
      <button @click="modifyItem">ok</button>
    </div>
    <div class="image">
      <div class="camIcon">
        <CamButton />
      </div>
    </div>
    <div class="card-body">
      {{newItem.description}}
      <textarea
        rows="5"
        name="description"
        class="form-control area-input"
        v-model="newItem.description"
      ></textarea>
    </div>
  </div>
</template>

<script>
import CloseButton from "../buttons/DeleteButton";
import CamButton from "../buttons/CamButton";
import axios from "axios";

export default {
  components: {
    CloseButton,
    CamButton
  },
  props: ["collection", "selectedItem", "isNew"],

  data() {
    return {
      newItem: {
        name: "NewItem",
        image: "",
        description: "Explain Why you collect this item"
      },
      // collectionId: 1,
      //isNew: true,
      editMode: false
    };
  },

  //   watch: {
  //     selectedItem: function() {
  //       this.newItem = this.selectedItem;
  //       console.log("hoal");
  //     }
  //   },
  mounted() {
    this.newItem = this.selectedItem;
  },
  methods: {
    closeItem() {
      this.$emit("closeItem");
    },
    saveItem() {},
    createItem() {
      let formData = new FormData();

      formData.append("name", this.newItem.name);
      formData.append("description", this.newItem.description);

      //   if (this.image) {
      //     formData.append("image", this.image);
      //   }

      //   formData.append("category_id", this.newItem.category.id);
      formData.append("collection_id", this.collection.id);

      let config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      if (this.isNew) {
        axios.post("/api/item", formData, config).then(Response => {});
      }
      if (!this.isNew) {
        formData.append("type", "PUT");

        axios.post("/api/item", formData, config).then(Response => {});
      }
    },
    modifyItem() {
      if (this.isNew) {
        this.createItem();
      }
      if (!this.isNew) {
        this.saveItem();
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.card {
  position: absolute;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100%;
  z-index: 100;
}
.card-header {
  display: flex;
  justify-content: space-between;
}
.image {
  background-color: grey;
  height: 500px;
}
</style>>

   