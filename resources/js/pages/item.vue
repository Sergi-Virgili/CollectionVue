<template>
  <div>
    <h3>item: {{item.id}} {{item.name}} </h3>


  </div>
</template>

<script>
import axios from 'axios'
export default {

  //middleware: 'auth',

  components: {

  },

  data()  {

        return {
          item: {},
          params: {}
        }
    },


  mounted() {
    this.item.id = this.$route.params.id
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
