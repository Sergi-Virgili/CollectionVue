<template>
<div id="coment" class="panel panel-default">
            <div id="authorName"><a href="">{{comment.authorName}}</a></div>
            <div id="fecha" class="panel-heading">{{comment.created_at}}</div>

            <div class="panel-body">

            <input v-if="editMode" type="text" class="form-control" v-model="comment.content">
            <p  v-if="!editMode">{{comment.content}}</p>

            </div>

            <button v-if="editMode && comment.isAuthor" id="save" class="btn btn-success" v-on:click="onClickUpdate()">
                Guardar Cambios
            </button>
            <i v-if="!editMode && comment.isAuthor" id="edit" class="fas fa-pen" v-on:click="onClickEdit()"/>
            <i v-if="comment.isAuthor" id="delete" class="fas fa-times-circle" v-on:click="onClickDelete()" />

    </div>
</template>

<script>
import axios from 'axios'
    export default {
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


    #delete {
        color: grey;
        grid-row: 2/3;
        grid-column: 5/6;
    }
    #delete:hover {
        color: red;
    }
    #edit {
        color: grey;
        grid-column: 2/3;
        grid-row: 4/5;   
            }
    #edit:hover {
        color: darkgreen;
        cursor: pointer;
    }
    #save{
        grid-row: 4/6;
        grid-column: 1/3;
        border-radius: 0px 9px 0px 9px;
    }
    #coment {
        width: 100%;
        display: grid;
        grid-template-columns: 23px 25%  40% 25% 3%;
        grid-template-rows: 5px 20px auto 30px 2px;
        column-gap: 5px;
        row-gap: 15px;
        border: 2px solid black;
        border-radius: 10px;
        margin-bottom: 10px;
}
#authorName{
    grid-column: 2/3;
    grid-row: 2/3;

}
a { 
    color: black;
    text-decoration: none;
    font-size: 20px;
}
a:hover{
    text-decoration: none;
}
a:visited{
    text-decoration: none;
    color:black;
}
#fecha{
    grid-column: 4/5;
    grid-row: 4/5;

}
.panel-body{
    grid-row: 3/4;
    grid-column: 2/5;
}

</style>