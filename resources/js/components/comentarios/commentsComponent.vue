<template>
<div id="coment" class="card">
        <div class="card-header">
            <div>
                <div id="authorName"><a href="">{{comment.authorName}}</a></div>
                <div id="fecha" class="panel-heading">{{comment.created_at}}</div>
            </div>
            
            <div v-if="comment.isAuthor" v-on:click="onClickDelete()">
                <TrashButton />
            </div>
        </div>
        <div class="card-body">
            <input v-if="editMode" type="text" class="form-control" v-model="comment.content">
            <p  v-if="!editMode">{{comment.content}}</p>
        </div>
        <div class="card-footer" v-if="comment.isAuthor">
            <div v-if="editMode" v-on:click="onClickUpdate">
                <CheckButton/>
            </div>
            <div id="editButton" v-if="!editMode" v-on:click="onClickEdit()">
                <EditButton/>
            </div>
        </div>
    </div>
</template>

<script>
import EditButton from '../buttons/EditButton'
import CheckButton from '../buttons/CheckButton'
import TrashButton from '../buttons/TrashButton'
import axios from 'axios'
    export default {
        components:{
            TrashButton,
            CheckButton,
            EditButton
        },
        props: ['comment'],
        data(){
            return{
                editMode: false
            };
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            onClickDelete() {
                axios.delete(`/api/comments/${this.comment.id}`).then(() => {
                    this.$emit('delete');
                });
            },
            onClickEdit() {
                this.editMode = true;
            },
            onClickUpdate() {

                if (!this.comment.content) {
                    return 
                }

                const params = {
                    content: this.comment.content
                };

                axios.put(`/api/comments/${this.comment.id}`,params).then((response) => {
                this.editMode = false;
                const comment = response.data;
                
                this.$emit('update', comment);
                });
            }
        }
    }
</script>
<style>
.card{
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.26);
    margin-bottom: 1em;
}
.card-header{
    display: flex;
    justify-content: space-between;
}
.card-body{
    display: flex;
    justify-content: space-between;
}
.card-footer{
    display: flex;
    height: 40px;
}

#fecha{
    font-size: 12px;
}
#authorName a{
    text-decoration: none;
    color: rgb(66, 66, 66);
    font-weight: 700;
}
#editButton{
    margin-top: -13px;
    margin-left: -15px;
}
</style>
