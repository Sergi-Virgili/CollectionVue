<template>
  <div>
    <NewItem 
      v-if="newItem"
      @closeItem ="closeItem" />
    <div v-if="!newItem">
    <div class="card">

      <div class="card-header">
        <input
            v-model="collection.name"
            class = "form-control"
            type="text"
            name = 'name'

            v-if='edit.title'
            >
        <h3
          v-if="!edit.title"
         @click="editTitle()"
          >


          {{collection.name}}

        </h3>
          <div
            v-if="!edit.title"
            @click="editTitle()">
            <EditButton
              />

          </div>
          <div
            v-if="edit.title"
            @click="editTitle()">
            <CheckButton />
          </div>
          <!-- <div
            v-if="edit.title"
            @click="CancelEdit()">
            <TrashButton />
          </div> -->

        </div>
      <input
        type="file"
        @change="OnFileSelected"
        style = "display:none"
        ref ="fileInput">

      <button @click="$refs.fileInput.click()">Pick Image</button>
      <button @click="onUpload">Upload</button>

      <div class="image-card" :style= "{ backgroundImage: 'url(' + collection.img_url + ')' }"> </div>

      <img v-if="url" :src="url" alt="">

      <div class="card-body">

        <p
          v-if="!edit.description">
        {{collection.description}}
        </p>

        <textarea
          rows="5"
          v-if="edit.description"
          class="form-group area-input"
          v-model="collection.description"></textarea>
        <div
            v-if="!edit.description"
            @click="editDescription()">
            <EditButton
              />

          </div>
          <div
            v-if="edit.description"
            @click="editDescription()">
            <CheckButton />

          </div>
        </div>

    </div>

    <div class="item-list">
      <div v-for="item in collection.items" :key="item.id" >

          <div 
            class="card new-item" 
            @click="openItem()"
            :item="item"
            >
          
          <div class="card-header">{{item.name}}</div>
          <img
            class="card-img-top"
            src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Amiga500_system.jpg"
            alt="">
          <div class="card-footer">

          </div>
          </div>

      </div>



    <div 
      class="card new-item" 
      @click="openItem()"
      >
      <div class="card-body">
          +
        </div>
    </div>


    </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios'
//import LoveComponent from './LoveComponent'
import EditButton from '../components/buttons/EditButton'
import CheckButton from '../components/buttons/CheckButton'
import TrashButton from '../components/buttons/TrashButton'
import NewItem from '../components/items/NewItem'


export default {

  middleware: 'auth',

  components: {
    CheckButton,
    EditButton,
    TrashButton,
    NewItem
  },

  data()  {

        return {
          collection: {},
          item: '',
          lastCollection: {},
          params: {},
          fileSelected : null,
          url: null,
          image: '',
          edit: {
            title: false,
            description: false
          },
          newItem : false
        }
  },

  mounted() {
    this.collection.id = this.$route.params.collectionId

    this.getData()
    this.params = this.$route.params
  },

  methods: {
    //TODO CANCEL EDIT FUNCTION
    closeItem() {
      
      this.newItem = false
    },
    openItem() {
      this.newItem = true
    },

    CancelEdit() {
      this.edit.title = false
      this.collection = this.lastCollection
      console.log(this.lastCollection.name)
      console.log(this.collection.name)
    },

    editTitle() {
      if (this.edit.title ) {
        this.onUpload()
        this.edit.title = false
        return null
      }
      this.edit.title = true

    },
    editDescription(){
      if (this.edit.description ) {
        this.onUpload()
        this.edit.description = false
        return null
      }
      this.edit.description = true

    },

    getData() {
      axios.get(`/api/collection/${this.collection.id }`)
        .then((response) => {
          this.collection = response.data
          this.lastCollection = this.collection
        })
    },
    swipeHandler(direction) {
       console.log(direction, this.$route)

    },
    OnFileSelected(evente) {

      this.fileSelected = event.target.files[0]
      let reader = new FileReader
      reader.readAsDataURL(this.fileSelected)
      reader.onload = e => {
        console.log(e.target.result)
        this.image = e.target.result
      }

    },
    onUpload() {

      let params = new FormData();
      params = {
        name: this.collection.name,
        description: this.collection.description,
        image: this.image
        }

      axios.put(`/api/collection/${this.collection.id}`, params)

      .then((res)=>{
        this.lastCollection = this.collection
      })
    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>

<style lang="scss" scoped>
  .area-input {

    width: 100%;
  }

  .item-list {
    width: 100%;

      margin: 0 auto;
      display: grid;
      grid-template-columns:  1fr 1fr;
      gap:1em;
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
</style>
