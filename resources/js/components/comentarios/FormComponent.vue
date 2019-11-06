<template>
<div class="panel panel-default">
      <div class="panel-heading">   </div>

        <div class="panel-body">
          
            <form action="" v-on:submit.prevent="newComment()">
                <div class="form-group">
                    <label for="comentario "></label>
                    <input type="text" placeholder="comenta aqui" class="form-control" name="comentario" v-model="content">
                    <button type="submit" class="btn btn-primary">
                    Enviar Comentario
                    </button>
                </div>

            </form>
       </div>
    </div>

</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

    export default {
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
                        console.log(this.user.name)
                        this.$emit('new', comment);
            });

            }
        }
    }
</script>
