<template>
<div>
        <div class="container">

                <div class="comment-form">

                    <input type="text" class="form-control" placeholder="comenta aqui" name="comentario" v-model="content">

                    <div  @click="newComment()">

                    <CheckButton/>

                    </div>

                </div>


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

  .comment-form{

    width: 100%;
    display:flex;

  }
</style>
