<template>
    <div class="container">
        <div class="card">
            <figure v-if="!edit.image">
                <img :src="image"/>
            </figure>
            <figure v-if="edit.image">
                <img id="image" :src="imagen">
            </figure>
            <input v-if="edit.image" class="btn btn-outline-primary" type="file" name="image" @change="getImage">
            <div v-if="!edit.image" @click="editImage()">
                <EditButton/>
            </div>
            <div v-if="edit.image" @click="editImage()">
                <CheckButton />
            </div>
        </div>
        <div class="card">
          <div class="d-flex flex-nowrap align-items-center justify-content-between">
            <h5 v-if="!edit.name">{{user.name}}</h5>
            <input v-if="edit.name" type="text" v-model="user.name" class="form-control" name="name">
            <div v-if="!edit.name" @click="editName()">
                <EditButton/>
            </div>
            <div v-if="edit.name" @click="editName()">
                <CheckButton />
            </div>
          </div>
          <div class="d-flex flex-nowrap align-items-center justify-content-between">
            <h6>{{user.email}}</h6>
            <input v-if="edit.email" type="email" v-model="user.email" class="form-control" name="email">
            <div v-if="!edit.email" @click="editEmail()">
                <EditButton/>
            </div>
            <div v-if="edit.email" @click="editEmail()">
                <CheckButton />
            </div>
            <!-- <p>{{this.user.address}}</p> -->
          </div>
        </div>
        <div class="card">
            <router-link v-if="!user.isUserProfile" :to="{name:'userCollections', params:{user: user}}">
                Collections
            </router-link>
            <router-link v-if="user.isUserProfile" :to="{name:'myCollections'}">
                My Collections
            </router-link>
            <router-link v-if="user.isUserProfile" :to="{name:'favoriteCategories'}">
                My Categories
            </router-link>
            <!-- <router-link :to="" id="favorites">
            </router-link> -->
        </div>
    </div>
</template>

<script>

import axios from 'axios'
import EditButton from '../components/buttons/EditButton'
import CheckButton from '../components/buttons/CheckButton'

export default {
    middleware: 'auth',

    components: {
        CheckButton,
        EditButton,
    },

    data() {
        return {
            user: {
                name: '',
                email: '',
                image: ''
            },
            image: {},
            preImage: "",
            edit: {
                name: false,
                email: false,
                image: false,
            },
        };
    },

    mounted(){
        this.getUser();
    },

    methods: {
        getUser(){
            axios.get(`/api/user/profile/${this.$route.params.id}`)
            .then((response) => {this.user = response.data;
            this.image = response.data.usrimage;
            console.log(response.data);
            })
        },
        editName() {
            if (this.edit.name ) {
                this.onUpload()
                this.edit.name = false
                return null
            }
            this.edit.name = true
        },
        editEmail(){
            if (this.edit.email ) {
                this.onUpload()
                this.edit.email = false
                return null
            }
            this.edit.email = true
        },
        editImage(){
            if (this.edit.image){
                this.onUpload()
                this.edit.image = false
                return null
            }
            this.edit.image = true
        },
        onUpload() {
            let params = new FormData();
            params.append("_method", "PUT");
            params.append("name", this.user.name);
            params.append("email", this.user.email);
            if (this.preImage) {
                params.append("image", this.preImage);
                this.preImage = "";
            }
            console.log(params);

            axios.post(`/api/user/${this.user.id}/update`, params)
            .then((response)=>{
            })
        },
        getImage(event){
            let file = event.target.files[0];
            this.user.photo_url = file;
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