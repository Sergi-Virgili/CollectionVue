<template>
    <div class="card container justify-content-sm-center">
        <form enctype="multipart/form-data" v-on:submit.prevent="create()">
            <label>Name</label>
            <input type="text" name="name" v-model="category.name">
            <label>Description</label>
            <textarea name="description" v-model="category.description"></textarea>
            <label>Image</label>
            <figure>
                <img id="image" :src="imagen">
            </figure>
            <input class="btn btn-outline-primary" type="file" name="icon" @change="getImage">
            <div class="d-flex flex-nowrap">
                <button class="btn btn-outline-danger" @click="cancel()">CANCELAR</button>
                <button type="submit" class = "btn btn-outline-success">GUARDAR</button>
            </div>
        </form>
    </div>
</template>

<script>

import axios from 'axios'

export default {
    
    name: 'CategoryForm',

    data() {
        return{
            preImage: '',
            category: {
                name: '',
                description: '',
                icon: '',
            }
        }
    },
    methods: {

        cancel(){

            this.$emit('cancel');

        },
        create(){
            let formData = new FormData();
            formData.append('name', this.category.name);
            formData.append('description', this.category.description);
            formData.append('icon', this.category.icon);
            axios.post('api/category', formData).then((response) => {
                        const category = response.data;
                        this.$emit('create', category)
            });
        },
        getImage(event){
            let file = event.target.files[0];
            this.category.icon = file;
            this.preUploadImage(file);
        },
        preUploadImage(file){
            let reader = new FileReader();
            reader.onload = (event) => {
                this.preImage = event.target.result;
            }
            reader.readAsDataURL(file);
        },

    },
    computed:{
        imagen(){
            return this.preImage;
        }
    },

}
</script>

<style scoped>
    #image{
        max-width: 80px;
    }
</style>