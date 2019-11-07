<template>
  <div>
    <!-- <h3> {{categoryName}} </h3> -->
  <CategoryList class="category-list"
        @categorySelect = 'selectCategory'
        />
  <transition name="fade" mode="out-in" >
  <CollectionList
    :categoryId = this.categoryId
   />
  </transition>
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
            categoryId: 1
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
<style>
  
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
    }
  .fade-enter, .fade-leave-to .fade-leave-active {
         opacity: 0;
    }
  .category-list {
    
    margin-bottom: 1em;

  }

</style>
