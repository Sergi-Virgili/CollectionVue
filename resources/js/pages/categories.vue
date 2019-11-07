<template>
    <div class="card container justify-content-sm-center" id="categories" >
        <div class="justify-content-center row">
            <h2>Categorias</h2>
        </div>
        <div class="col-sm-12 d-flex flex-wrap">
            <category v-for="category in categories" :key="category.id" :category='category'/>
        </div>
        <div class="col-sm-12 justify-content-center">
            <form id="crear" action="/admin/category/store" method="POST" class="hidden" accept-charset="UTF-8" enctype="multipart/form-data">
                <label>Name</label>
                <input type="text" name="name">
                <label>Description</label>
                <textarea name="description"></textarea>
                <label>Image</label>
                <input type="file" name="image">
                <input type="submit" value="CREAR" class = "btn btn-outline-success">
            </form>
            <button id="" @click="toggleHide(['crear'])">CREAR</button>
        </div>
    </div>
</template>

<script>

    import Category from '../components/Category'
    import EditCategory from '../components/EditCategory'
    import axios from 'axios'

    export default {
        
    middleware: 'auth',

        data() {
            return {
                categories: [],
            };
        },

        components: {

            EditCategory,
            Category

        },

        methods: {
            
            create(){

            },
        },

        mounted() {

            console.log('component mounted');

            axios.get('/api/register/data').then((response) => {this.categories = response.data;});

        },

    }
</script>