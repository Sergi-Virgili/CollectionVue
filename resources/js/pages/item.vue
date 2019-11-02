<template>
  <div>
    <h1 :key='item.id'>item: {{item.id}} {{item.name}} </h1>
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
          item: {}
        }
    },
  beforeMount() {
    this.item.id = this.$route.params.id
    //alert(this.collection.id)
  },

  mounted() {
    this.getData()
  },

  methods: {
    getData() {
      axios.get(`/api/collection/item/${this.item.id}`)
        .then((response) => {
          this.item = response.data
        })

    }
  }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>
