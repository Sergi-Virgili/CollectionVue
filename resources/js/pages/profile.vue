<template>
    <div class="container">
        <div class="card">
            <figure>
                <img :src="user.photo_url"/>
            </figure>
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
            user: {},
            edit: {
                name: false,
                email: false
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
        onUpload() {
            let params = new FormData();
            params = {
                name: this.user.name,
                email: this.user.email,
                }

            axios.put(`/api/user/${this.user.id}/update`, params)
            .then((response)=>{
            })
        },
    }
}
        
    
    

</script>

<style scoped>

</style>