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
    <input type="file" @change="OnFileSelected" style="display:none" ref="fileInputItem" />
    <div @click="$refs.fileInputItem.click()">
      <CamButton class="cam-button" />
    </div>
    <div class="image" :style="{ backgroundImage: 'url(' + newItem.img_url + ')' }"></div>

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
        name: "New Item",
        img_url: "",
        description: "New Description"
      },

      image: "",
      fileSelected: "",

      // collectionId: 1,
      // isNew: true,
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
    if (!this.isNew) {
      this.newItem = this.selectedItem;
    }
  },
  methods: {
    OnFileSelected(event) {
      this.fileSelected = event.target.files[0];
      this.newItem.img_url = URL.createObjectURL(this.fileSelected);
      let reader = new FileReader();
      reader.readAsDataURL(this.fileSelected);
      reader.onload = e => {
        this.image = e.target.result;
        this.modifyItem();
      };
    },
    closeItem() {
      this.$emit("closeItem");
    },
    saveItem() {
      let formData = new FormData();
      formData.append("name", this.newItem.name);
      formData.append("description", this.newItem.description);
      formData.append("id", this.newItem.id);
      formData.append("collection_id", this.collection.id);
      if (this.image) {
        formData.append("image", this.image);
        this.image = "";
      }
      formData.append("_method", "PUT");

      axios.post("/api/item", formData, config).then(response => {});
    },

    createItem() {
      let formData = new FormData();
      formData.append("name", this.newItem.name);
      formData.append("description", this.newItem.description);

      if (this.image) {
        formData.append("image", this.image);
      }

      formData.append("collection_id", this.collection.id);

      let config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };

      axios.post("/api/item", formData, config).then(response => {
        this.isNew = false;
        this.newItem.id = response.data.id;
        this.$emit("updateItems", this.newItem);
      });
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
  background-size: cover;
  background-position: center;
}
</style>>

   