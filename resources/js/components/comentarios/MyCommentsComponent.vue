<template>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form-component @new="addComment" />
                <comments-component  v-for="(comment, index) in comments" 
                :key="comment.id"
                :comment="comment"
                @update="updateComment(index, arguments)"
                @delete="deleteComment(index)" />
            </div>
        </div>
 

</template>
<script>
import axios from 'axios'
import commentsComponent from './commentsComponent.vue'
import FormComponent from './FormComponent.vue'
    export default {
       
        components:{
            FormComponent,
            commentsComponent
        },
        data(){
            return {
                comments:[],
                collection_Id : this.$route.params.collectionId
            }
        },
        mounted() {
            this.getData();
        },
        methods:{
            addComment(comment){
                
               // this.comments.isAuthor=true;
                this.comments.unshift(comment);
            },
            getData(){
                 axios.get('/api/comments/'+this.collection_Id).then((response) =>  {
                const comments = []
                for(let comment in response.data ){
                comments.push(response.data[comment])
                }
                this.comments = comments;
                
            });
            },
            deleteComment(index) {
               
                this.comments.splice(index, 1);
                console.log(this.comments)
                console.log(index)
            },
            updateComment(index, comment) {
                this.comment[index] = comment; 
            },
           
            
        }
    }
</script>

<style scoped>
    
</style>

