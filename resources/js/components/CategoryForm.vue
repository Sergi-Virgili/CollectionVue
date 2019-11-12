<template>
    <div class="card container justify-content-sm-center">
        <form action="" method="" enctype="multipart/form-data" v-on:submit.prevent="create()">
            <label>Name</label>
            <input type="text" name="name" v-model="name">
            <label>Description</label>
            <textarea name="description" v-model="description"></textarea>
            <label>Image</label>
            <input class="btn btn-outline-primary" type="file" name="icon">
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

        }
    },
    methods: {

        cancel(){

            this.$emit('cancel');

        },
        create(){
            const params = {
                name: this.name,
                description: this.description,
                icon: this.icon,
            }
            axios.post('api/category', params).then((response) => {
                        const category = response.data;
                        this.$emit('create', category)
            });
        }

    }

}
</script>