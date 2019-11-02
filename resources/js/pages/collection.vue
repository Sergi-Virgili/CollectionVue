<template>
  <div>
    <h1 :key='collection.id'>collection: {{collection.id}} {{collection.name}}</h1>
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
          collection: {}
        }
    },
  beforeMount() {
    this.collection.id = this.$route.params.id
    //alert(this.collection.id)
  },

  mounted() {
    this.getData()
  },

  methods: {
    getData() {
      axios.get(`/api/collection/${this.collection.id}`)
        .then((response) => {
          this.collection = response.data
        })
    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>
