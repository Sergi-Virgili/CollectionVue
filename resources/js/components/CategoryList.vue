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
            categoryId: '',
            categoryName: ''
        }
    },

    mounted() {
        this.getCategories();
    },

    methods: {

        getCategories() {
            axios.get('/api/categoryUser/data')
            .then((response) => {
                this.categories = response.data;
                this.categoryId = this.categories[0].id;
                this.$emit('categorySelect', this.categoryId);
                });
        },
        onClickCategorySelect(id, categoryName) {

            this.$emit('categorySelect', id, )
            this.categoryName = categoryName
        },
    }
    
}


</script>

<style scoped>

    .category-list {
        display: flex;
        /* flex-direction: column; */
        /* max-width: 100%; */
        
        overflow-y: scroll;
        overflow-x: scroll;
        justify-content: center;
    }
    h3 {
       
        
    }

</style>
