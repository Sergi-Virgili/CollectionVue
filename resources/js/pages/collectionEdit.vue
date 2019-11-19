<template>
  <div>
    <NewItem v-if="openEdit" @closeItem="closeItem" :isNew="isNew" :selectedItem="selectedItem" />
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
          <h3 v-if="!edit.title" @click="editTitle()">{{collection.name}}</h3>
          <div v-if="!edit.title" @click="editTitle()">
            <EditButton />
          </div>
          <div v-if="edit.title" @click="editTitle()">
            <CheckButton />
          </div>
          <!-- <div
            v-if="edit.title"
            @click="CancelEdit()">
            <TrashButton />
          </div>-->
        </div>
        <input type="file" @change="OnFileSelected" style="display:none" ref="fileInput" />

        <button @click="$refs.fileInput.click()">Pick Image</button>
        <button @click="onUpload">Upload</button>
        <img class="categoryItem" :src="collection.category.icon" />
        <div class="image-card" :style="{ backgroundImage: 'url(' + collection.img_url + ')' }"></div>

        <img v-if="url" :src="url" alt />

        <div class="card-body">
          <p v-if="!edit.description">{{collection.description}}</p>

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
        <div v-for="item in collection.items" :key="item.id">
          <!-- <router-link :to="'/collection/'+collection.id+'/item/'+item.id" class="card new-item" > -->
          <div class="card new-item" @click="editItem(item)">
            <div class="card-header">{{item.name}}</div>
            <img
              class="card-img-top"
              src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Amiga500_system.jpg"
              alt
            />
            <div class="card-footer"></div>
          </div>
          <!-- <div class="card-body">{{collection.description}}</div> -->

          <!-- </router-link> -->
        </div>

        <div class="card new-item" @click="openItem()">
          <div class="card-body">+</div>
        </div>
      </div>
      <!-- <div class="view_child"

      v-touch:swipe.left="swipeHandler">

      <router-view :key="this.$route.params.id+1"/>

      </div>-->

      <!-- <div class="card-body">{{collection.description}}</div> -->
    </div>
  </div>
</template>

<script>
import axios from "axios";
//import LoveComponent from './LoveComponent'
import EditButton from "../components/buttons/EditButton";
import CheckButton from "../components/buttons/CheckButton";
import TrashButton from "../components/buttons/TrashButton";
import NewItem from "../components/items/NewItem";

export default {
  middleware: "auth",

  components: {
    CheckButton,
    EditButton,
    TrashButton,
    NewItem
  },

  data() {
    return {
      collection: {},
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
  beforeMount() {
    //alert(this.collection.id)
  },

  mounted() {
    this.collection.id = this.$route.params.collectionId;

    this.getData();
    this.params = this.$route.params;
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
    swipeHandler(direction) {},
    OnFileSelected(event) {
      this.fileSelected = event.target.files[0];
      this.collection.img_url = URL.createObjectURL(this.fileSelected);
      let reader = new FileReader();
      reader.readAsDataURL(this.fileSelected);
      reader.onload = e => {
        this.image = e.target.result;
        this.onUpload();
      };
    },
    onUpload() {
      let formData = new FormData();

      formData.append("name", this.collection.name);
      formData.append("description", this.collection.description);

      if (this.image) {
        formData.append("image", this.image);
        this.image = "";
      }

      formData.append("category_id", this.collection.category.id);
      formData.append("collection_id", this.collection.id);

      let config = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      if (this.newCollection) {
        axios
          .post(`/api/collection`, formData, config)
          //axios.put(`/api/collection/${this.collection.id}`, {'image' : this.image})
          //axios.put(`/api/collection/${this.collection.id}`, params)

          .then(res => {
            this.lastCollection = this.collection;
          });
      }

      if (!this.newCollection) {
        
        formData.append("_method", "PUT");
        formData.append("id", this.collection.id);
        axios
          .post(`/api/collection`, formData, config)
          //axios.put(`/api/collection/${this.collection.id}`, {'image' : this.image})
          //axios.put(`/api/collection/${this.collection.id}`, params)

          .then(res => {
            console.log(res);
            this.lastCollection = this.collection;
          });
      }
    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
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
</style>
