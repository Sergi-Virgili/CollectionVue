<template>
  <div>

    <h2>collection: {{collection.name}}</h2>
    <input
      type="file"
      @change="OnFileSelected"
      style = "display:none"
      ref ="fileInput">

    <button @click="$refs.fileInput.click()">Pick Image</button>
    <button @click="onUpload">Upload</button>
    
    <img v-if="url" :src="url" alt="">
    <img v-if="url" :src="url" alt="">
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


export default {

  middleware: 'auth',

  components: {

  },

  data()  {

        return {
          collection: {},
          params: {},
          fileSelected : null,
          url: null,
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
    getData() {
      axios.get(`/api/collection/${this.collection.id }`)
        .then((response) => {
          this.collection = response.data

          console.log(this.collection)
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

        image: this.fileSelected
        }

      axios.put(`/api/collection/${this.collection.id}`, params, { headers: {
        'Content-Type': 'multipart/form-data'
    }}
    ).then((res)=>{})
    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>

<style lang="scss" scoped>
  .view_child {

    // height: 200px;
  }

  .item-list {
    width: 100%;

      margin: 0 auto;
      display: grid;
      grid-template-columns:  1fr 1fr;
      gap:1em;

  }
</style>
