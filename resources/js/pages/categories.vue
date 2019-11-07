<template>
    <div class="card container justify-content-sm-center" id="categories" >
        <div class="justify-content-center row">
            <h2>Categorias</h2>
        </div>
        <div class="col-sm-12 d-flex flex-wrap">
            <div v-for="category in categories" :key="category.id" :category="category">
                <h3>{{category.name}}</h3>
            </div>
        </div>
        <div class="col-sm-12 justify-content-center">
            <button class="btn btn-outline-success">CREAR</button>
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