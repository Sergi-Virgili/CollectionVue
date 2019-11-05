<template>
  <div>

    <h1>collection: {{collection.id}} {{collection.name}}</h1>

    <div v-for="item in collection.items" :key="item.id">

      <router-link :to="'/collection/'+collection.id+'/item/'+item.id" >link</router-link>


    </div>

    <div class="view_child"

      v-touch:swipe.left="swipeHandler">
    <transition name="fade" mode="out-in">
      <router-view :key="this.$route.params.id+1"/>
    </transition>
    </div>
    <CommentsList  />
  </div>
</template>

<script>
import axios from 'axios'
import CommentsList from '../components/comentarios/MyCommentsComponent.vue' 
export default {

  middleware: 'auth',

  components: {
    CommentsList,
  },

  data()  {
        return {
         
          collection: {},
          params: {}
        }
  },
  beforeMount() {

    //alert(this.collection.id)
  },

  mounted() {
    this.collection.id = this.$route.params.collectionId
    this.collectionIdprop = this.collection.id
   
     this.getData()
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

    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>

<style lang="scss" scoped>
  .view_child {
    background-color: red;
    height: 200px;
  }
</style>
