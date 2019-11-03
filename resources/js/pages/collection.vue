<template>
  <div>

    <h1>collection: {{collection.id}} {{collection.name}}</h1>

    <div v-for="item in collection.items" :key="item.id">

      <router-link :to="'/collection/'+collection.id+'/item/'+item.id" >link</router-link>


    </div>
    <div>

      <router-view :key="this.$route.params.id+1"/>

    </div>

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
    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>
