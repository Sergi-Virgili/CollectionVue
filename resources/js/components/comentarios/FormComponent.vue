<template>
<div class="panel panel-default">
        <div class="panel-body">
            <form action="" v-on:submit.prevent="newComment()">
                <div class="form-group">
                    <label for="comentario "></label>
                    <input type="text" placeholder="comenta aqui" class="form-control" name="comentario" v-model="content">
                    <button type="submit" id="buttonSubmit">
                    <div><CheckButton/></div>
                    </button>
                </div>

            </form>
       </div>
    </div>

</template>

<script>
import CheckButton from '../buttons/CheckButton'
import axios from 'axios'
import { mapGetters } from 'vuex'

    export default {
        components:{
            CheckButton
        },
        data(){
            return {
                content:'',

            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        computed: mapGetters({
    user: 'auth/user'
  }),
        methods: {
            newComment(){
                const params ={
                    content:this.content,
                    collection_id: this.$route.params.collectionId
                };
                this.content = '';

                axios.post('/api/comments', params)
                    .then((response) => {
                        const comment = response.data;
                        comment.isAuthor = true;
                        comment.authorName = this.user.name
                        console.log(response)
                        this.$emit('new', comment);
            });

            }
        }
    }
</script>
<style scoped>
.form-group{
    display:flex;
}
#buttonSubmit{
    background-color: rgb(92, 92, 219);
    border: 0px;
    height: 40px;
}
#buttonSubmit div{
    margin-top: -3px;
}
</style>