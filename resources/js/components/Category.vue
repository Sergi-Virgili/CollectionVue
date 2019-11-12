<template>
    <div class="card col-sm-12">
        <form v-if="editMode" v-on:submit.prevent="updateCategory()" action="" method="" enctype="multipart/form-data">
            <div class="card">
                <input type="text" v-model="categoryItem.name">
                <textarea v-model="categoryItem.description"></textarea>
            </div>
            <input class="btn btn-outline-primary" type="file" name="icon">
            <div class="d-flex flex-nowrap">
                <button type="submit" class="btn btn-outline-success">GUARDAR</button>
                <button class="btn btn-outline-danger" @click="cancelEdit()">CANCELAR</button>
            </div>
        </form>
        <div v-else>
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
                category: [],
                editMode: false,
            }
        },

        methods: {

            updateCategory(){
                const params = {
                    name: this.name,
                    description: this.description,
                    icon: this.icon,
                }
                const id = this.categoryItem.id;
                axios.put(`/api/category/${id}/update`, params).then((response) => {
                this.editMode = false;
                const category = response.data;
                this.$emit('updateCategory', category)});
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

</style>