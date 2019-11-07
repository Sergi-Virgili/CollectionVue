<template>
    <div id="{{category.id}}" class="card col-sm-12">
        <h3>{{category.name}}</h3>
        <img src="{{category.icon}}"/>
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
            }
        },

        methods: {

            edit(){

            },

            delete(){

            },
        },

        mounted() {
            axios.get('/api/register/data').then((response) => {this.categories = response.data;});
            console.log('Category Component mounted.')
        },

    }