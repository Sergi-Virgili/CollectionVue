<template>
    <div class="card col-sm-12">
        <h3>{{category.name}}</h3>
        <img :src="category.icon"/>
        <p>{{category.description}}</p>
        <button>EDITAR</button>
        <button>ELIMINAR</button>
    </div>
</template>

<script>

    import axios from 'axios'

    export default {

        props: ['category'],

        data(){

            return{
                category: [],
            }
        },

        methods: {

            edit(){

            },

            delete(){

            },
        },

        mounted() {

            console.log('Category Component mounted.')
        },

    }
</script>