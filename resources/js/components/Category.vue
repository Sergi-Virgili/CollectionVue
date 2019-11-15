<template>
    <div class="card col-sm-12">
        <form v-if="editMode" v-on:submit.prevent="updateCategory()" action="" method="" enctype="multipart/form-data">
            <div class="card">
                <input type="text" v-model="categoryItem.name">
                <textarea v-model="categoryItem.description"></textarea>
            </div>
            <figure>
                <img id="image" :src="categoryItem.icon">
            </figure>
            <input class="btn btn-outline-primary" type="file" name="icon" @change="getImage">
            <div class="d-flex flex-nowrap">
                <button type="submit" class="btn btn-outline-success">GUARDAR</button>
                <button class="btn btn-outline-danger" @click="cancelEdit()">CANCELAR</button>
            </div>
        </form>
        <div v-if="!editMode">
            <h3>{{categoryItem.name}}</h3>
            <img id="categoryIcon" :src="categoryItem.icon"/>
            <p>{{categoryItem.description}}</p>
            <button class="btn btn-outline-primary" @click="editCategory()">EDITAR</button>
            <button class="btn btn-outline-danger" @click="deleteCategory()">ELIMINAR</button>
        </div>
    </div>
</template>

<script>

    import axios from 'axios'

    export default {

        props: ['categoryItem'],

        data(){

            return{
                preImage: '',
                editMode: false,
            }
        },

        methods: {

            updateCategory(){
                const self = this;
                const id = this.categoryItem.id;
                const params = {
                    name: this.categoryItem.name,
                    cription: this.categoryItem.description,
                    icon: this.categoryItem.icon,
                }
                axios.put(`api/category/${id}/update`, params).then((response) => {
                this.editMode = false;
                const categoryItem = response.data;
                this.$emit('updateCategory', categoryItem)});
            },
            editCategory(){
                this.editMode = true;
            },
            cancelEdit(){
                this.editMode = false;
            },

            deleteCategory(){
                const id = this.categoryItem.id;
                axios.delete(`/api/category/${id}/destroy`).then(this.$emit('deleteCategory'));
            },
            getImage(event){
            let file = event.target.files[0];
            this.categoryItem.icon = file;
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

        mounted() {
            console.log('Category Component mounted.')
        },

    }
</script>

<style scoped>

    #categoryIcon{
        max-width: 50px;
    }
    #image{
        max-width: 80px;
    }

</style>