<template>
    <div class="category-list">

        <div v-for="(category, id) in categories"
            :key='category.index'
            v-on:click='onClickCategorySelect(category.id, id)'>
        <CategoryItem
            :category='category'
            />


        </div>

    </div>
</template>

<script>
import axios from 'axios'
import CategoryItem from './CategoryItem'

export default {
    components: {
      CategoryItem
    },
    data() {
        return {
            categories: [],
            categoryId: 6
        }
    },

    mounted() {
        this.getCategories();
    },

    methods: {

        getCategories() {
            axios.get('/api')
                .then(
                    (res) => this.categories = res.data
                )
        },
        onClickCategorySelect(id) {

            this.$emit('categorySelect', id)
        }
    }

}
</script>

<style>

    .category-list {
        display: flex;

        justify-content: center;
    }

</style>
