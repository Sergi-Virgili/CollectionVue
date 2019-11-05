<template>
<div>
    <div class="category-list">

        <div v-for="(category, id) in categories"
            :key='category.index'
            v-on:click='onClickCategorySelect(category.id, category.name)'>
        <CategoryItem
            :category='category'
            />
        </div>
    </div>
    <h3> {{categoryName}} </h3>
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
            categoryId: 6,
            categoryName: ''
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
        onClickCategorySelect(id, categoryName) {

            this.$emit('categorySelect', id, )
            this.categoryName = categoryName
        },
    }
}


</script>

<style>

    .category-list {
        display: flex;

        justify-content: center;
    }

</style>
