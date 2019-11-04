<template>
  <div>

    <h2>collection: {{collection.name}}</h2>
    <img :src="collection.image" :alt="collection.name">
    <div v-for="item in collection.items" :key="item.id">

      <router-link :to="'/collection/'+collection.id+'/item/'+item.id" >link</router-link>


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
          params: {}
        }
  },
  beforeMount() {

    //alert(this.collection.id)
  },

  mounted() {
    this.collection.id = this.$route.params.collectionId
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
