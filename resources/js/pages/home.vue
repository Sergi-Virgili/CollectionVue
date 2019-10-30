<template>
  <CollectionList />
</template>

<script>
import CollectionList from '~/components/CollectionList'
export default {
  middleware: 'auth',
  components: {CollectionList}
  // metaInfo () {
  //   return { title: this.$t('home') }
  // }
}
</script>
