<template>
    <div class="card container justify-content-sm-center" id="category.id" >
            <div class="justify-content-center row">
                <label for="category_id">Editando categoria {{category.name}}</label>
            </div>
            <div class="col-sm-12 d-flex flex-nowrap">
                <form enctype="multipart/form-data" v-on:submit.prevent="update()">
                    <input id="{{category.name}}" class="form-control" type="text" value="category.name" v-model="category.name">
                    <textarea id="description" class="form-control" type="text" value="{{category.description}}" v-model="description"></textarea>
                    <input id="file" class="form-control" type="file" accept="image/*" name="image">
                    <button class="btn btn-outline-success" type="submit">GUARDAR</button>
                    <button class="btn btn-outline-danger">CANCELAR</button>
                </form>
            </div>
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

            update(){

            }
        },

        mounted(){

            console.log('Edit Component mounted')
        }
        
    }
</script>