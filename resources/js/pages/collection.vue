<template>
  <div>

    <h3>
      <router-link :to="{ name: 'home'}">
        all

      </router-link>
       => {{ collection.name}}
      </h3>

    <div class="view_child card" :style="{ backgroundImage: `url('${collection.img_url}')` }"

      v-touch:swipe.left="swipeHandler">
    <transition name="fade" mode="out-in">
      <router-view :key="this.$route.params.id+1"/>
    </transition>
    </div>

    <CommentsList  class="comments-list"/>
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
    // background-color:lightgrey;
    background-position: center;
    background-size: cover;
    height: 50vh;

  }
  .comments-list {
    margin-bottom: 6em;
  }
</style>
