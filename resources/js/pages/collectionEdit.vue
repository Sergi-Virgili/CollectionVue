<template>
  <div>
    <div class="card"
      >
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
      
      <div class="image-card"></div>
      
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

      <router-link :to="'/collection/'+collection.id+'/item/'+item.id" class="card" >

        <div class="card-header">{{item.name}}</div>
        <img 
          class="card-img-top" 
          src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Amiga500_system.jpg"
          alt="">
        <div class="card-footer">

        </div>
        <!-- <div class="card-body">{{collection.description}}</div> -->

      </router-link>


    </div>
    </div>
    <!-- <div class="view_child"

      v-touch:swipe.left="swipeHandler">

      <router-view :key="this.$route.params.id+1"/>

    </div> -->

  </div>
</template>

<script>
import axios from 'axios'
//import LoveComponent from './LoveComponent'
import EditButton from '../components/buttons/EditButton'
import CheckButton from '../components/buttons/CheckButton'
import TrashButton from '../components/buttons/TrashButton'


export default {

  middleware: 'auth',

  components: {
    CheckButton,
    EditButton,
    TrashButton
  },

  data()  {
        
        return {
          collection: {},
          lastCollection: {},
          params: {},
          fileSelected : null,
          url: null,
          edit: {
            title: false,
            description: false
          }
        }
  },
  beforeMount() {

    //alert(this.collection.id)
  },

  mounted() {
    this.collection.id = this.$route.params.collectionId
     
    this.getData()
    this.params = this.$route.params
  },

  methods: {
    //TODO CANCEL EDIT FUNCTION
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

      console.log(event)
      this.fileSelected = event.target.files[0]
      this.url = URL.createObjectURL(this.fileSelected);
      console.log(event.target.files[0])
    },
    onUpload() {

      let params = new FormData();
      params = {
        name: this.collection.name,
        description: this.collection.description

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
  }

  .image-card {
    background-image: url("https://upload.wikimedia.org/wikipedia/commons/c/c3/Amiga500_system.jpg");
    height: 40vh;
    width: 100%;
    background-size: cover;
    background-position: center;
  }
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>
