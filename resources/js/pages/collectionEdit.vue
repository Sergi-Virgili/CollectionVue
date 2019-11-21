<template>
  <div>
    <NewItem
      v-if="openEdit"
      @closeItem="closeItem"
      @updateItems="updateItems"
      :collection="collection"
      :isNew="isNew"
      :selectedItem="selectedItem"
    />
    <div v-if="!openEdit">
      <div class="card">
        <div class="card-header">
          <input
            v-model="collection.name"
            class="form-control"
            type="text"
            name="name"
            v-if="edit.title"
          />
          <h3 v-if="!edit.title" @click="editTitle()">{{ collection.name }}</h3>
          <div v-if="!edit.title" @click="editTitle()">
            <EditButton />
          </div>
          <div v-if="edit.title" @click="editTitle()">
            <CheckButton />
          </div>
        </div>
        <input
          type="file"
          @change="OnFileSelected"
          style="display:none"
          ref="fileInput"
        />
        <!-- TODO: CATEGORY UPLOAD AND NEW -->
        <!-- <button @click="onUpload">Upload</button> -->
        <!-- / <img class="categoryItem" :src="collection.category.icon" /> -->
        <div
          class="image-card"
          :style="{ backgroundImage: 'url(' + collection.img_url + ')' }"
        >
          <div @click="$refs.fileInput.click()">
            <CamButton class="cam-button" />
          </div>
        </div>

        <img v-if="url" :src="url" alt />

        <div class="card-body">
          <p v-if="!edit.description">{{ collection.description }}</p>

          <textarea
            rows="5"
            v-if="edit.description"
            class="form-group area-input"
            v-model="collection.description"
          ></textarea>
          <div v-if="!edit.description" @click="editDescription()">
            <EditButton />
          </div>
          <div v-if="edit.description" @click="editDescription()">
            <CheckButton />
          </div>
        </div>
      </div>

      <div class="item-list">
        <div v-for="(item, index) in collection.items" :key="index">
          <div class="card new-item">
            <div class="card-header">{{ item.name }}</div>
            <div
              class="item-image"
              :style="{ backgroundImage: 'url(' + item.img_url + ')' }"
              @click="editItem(item)"
            ></div>
            <div class="card-footer">
              <p @click="deleteItem(item.id, index)">delete</p>
            </div>
          </div>
        </div>

        <div class="card new-item" @click="openItem()">
          <div class="card-body">+</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import EditButton from "../components/buttons/EditButton";
import CheckButton from "../components/buttons/CheckButton";
import TrashButton from "../components/buttons/TrashButton";
import NewItem from "../components/items/NewItem";
import CamButton from "../components/buttons/CamButton";

export default {
  middleware: "auth",

  components: {
    CheckButton,
    EditButton,
    TrashButton,
    NewItem,
    CamButton
  },

  data() {
    return {
      collection: {
        name: "Collection Title",
        description: "Collection Description",
        img_url: "",
        items: [],
        category: {
          id: 7
        }
      },
      selectedItem: {},
      lastCollection: {},
      params: {},
      fileSelected: null,
      url: null,
      image: "",
      edit: {
        title: false,
        description: false
      },
      isNew: false,
      openEdit: false,
      newCollection: false
    };
  },

  mounted() {
    if (this.$route.params.collectionId) {
      this.collection.id = this.$route.params.collectionId;

      this.getData();
      this.params = this.$route.params;
    }
    if (!this.$route.params.collectionId) {
      this.newCollection = true;
    }
  },

  methods: {
    //TODO CANCEL EDIT FUNCTION
    editItem(item) {
      this.isNew = false;
      this.openEdit = true;
      this.selectedItem = item;
    },
    closeItem() {
      this.isNew = false;
      this.openEdit = false;
    },
    openItem() {
      this.isNew = true;
      this.openEdit = true;
    },
    updateItems(newItem) {
      this.collection.items.push(newItem);
    },

    CancelEdit() {
      this.edit.title = false;
      this.collection = this.lastCollection;
    },

    editTitle() {
      if (this.edit.title) {
        this.onUpload();
        this.edit.title = false;
        return null;
      }
      this.edit.title = true;
    },
    editDescription() {
      if (this.edit.description) {
        this.onUpload();
        this.edit.description = false;
        return null;
      }
      this.edit.description = true;
    },

    getData() {
      axios.get(`/api/collection/${this.collection.id}`).then(response => {
        this.collection = response.data.collection;
        this.collection.img_url = response.data.image;
        this.lastCollection = this.collection;
      });
    },
    deleteItem(id, index) {
      axios.delete(`/api/item/${id}`).then(response => {
        this.collection.items.splice(index, 1);
      });
    },
    OnFileSelected(event) {
      this.fileSelected = event.target.files[0];
      this.collection.img_url = URL.createObjectURL(this.fileSelected);
      console.log(this.collection);
      let reader = new FileReader();
      reader.readAsDataURL(this.fileSelected);
      reader.onload = e => {
        this.image = e.target.result;
        this.onUpload();
      };
    },
    onUpload() {
      let formData = new FormData();

      formData.append("category_id", this.collection.category.id);
      formData.append("name", this.collection.name);
      formData.append("description", this.collection.description);

      if (this.image) {
        formData.append("image", this.image);
        this.image = "";
      }

      let config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      if (this.newCollection) {
        axios.post(`/api/collection`, formData, config).then(res => {
          this.lastCollection = this.collection;
          this.newCollection = false;
          this.collection.id = res.data.id;
        });
      }

      if (!this.newCollection) {
        formData.append("category_id", this.collection.category.id);
        formData.append("collection_id", this.collection.id);
        formData.append("_method", "PUT");
        formData.append("id", this.collection.id);
        axios.post(`/api/collection`, formData, config).then(res => {
          console.log(res);
          this.lastCollection = this.collection;
        });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.area-input {
  width: 100%;
}

.item-list {
  width: 100%;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1em;
  margin-top: 1em;
}

.image-card {
  height: 40vh;
  width: 100%;
  background-size: cover;
  background-position: center;
}
.card-header {
  display: flex;
  justify-content: space-between;
}
.new-item {
  min-height: 200px;
}
.categoryItem {
  width: 2em;
}
.cam-button {
  position: absolute;
  bottom: 0;
}
.item-image {
  height: 200px;
  background-size: cover;
  background-position: center;
}
</style>
