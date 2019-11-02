<template>
  <div>
  <CategoryList
        @categorySelect = 'selectCategory'
        />
  <CollectionList
    :categoryId = this.categoryId
   />
  </div>
</template>

<script>
import CollectionList from '~/components/CollectionList'
import CategoryList from '~/components/CategoryList'

export default {

  middleware: 'auth',
  components: {
    CollectionList,
    CategoryList
  },

  data()  {
        return {
            categoryId: 3
        }
    },
  methods: {

        selectCategory(category) {

            this.categoryId = category

        }
    }

  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>
