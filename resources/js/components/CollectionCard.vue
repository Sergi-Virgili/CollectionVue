<template>


    <div class="card ">


        <router-link :to="{name:'collection', params:{collectionId: collection.id}}">
          <!-- <img    class = "card-img-top"

                  :src="collection.img_url"> -->
          <div class = "image-card"

                  :style="{ backgroundImage: 'url(' + collection.image + ')' }">
          </div>
          </router-link>
            <div class="footer">
                <div class="title">

                {{collection.name}}



                </div>

                <div class="card-buttons">
                    <div class="likes">
                        <LoveComponent :collection = 'collection'></LoveComponent>
                    </div>
                    <router-link :to="{name:'collectionEdit', params:{collectionId: collection.id}}">


                        <div
                            v-if= "collection.author"
                            class="edit-button">
                            <EditButton :collection = 'collection' />


                        </div>
                    </router-link>
                    <div v-on:click="deleteOnClick()"
                        v-if= "collection.author"
                        class="">
                        <TrashButton
                            :collection = 'collection'
                            />
                    </div>
                </div>
        </div>
    </div>
    <!-- <div class="card collection-card">
        <div class="title">{{collection.name}}</div>
        <div class = "image"
        v-on:click="goToCollection()"
        src="" alt=""></div>
        <div class="footer">

            <div class="likes"><love-button :collection = 'collection'></love-button></div>

        </div>
    </div> -->
</template>

<script>
import axios from 'axios'
import LoveComponent from './buttons/LoveComponent'
import EditButton from './buttons/EditButton'
import DeleteButton from './buttons/DeleteButton'
import TrashButton from './buttons/TrashButton'



export default {

    components: {
      LoveComponent,
      EditButton,
      DeleteButton,
      TrashButton

    },
    props: ['collection'],
    mounted(){
        console.log(this.collection)
    },
    methods: {



        deleteOnClick() {

            axios.delete(`/api/collection/${this.collection.id}`)
                    .then(this.$emit('delete'));
        }

    }
}

</script>

<style scoped>

    .collection-card {
        box-shadow: 3px 3px 10px grey;
        max-width: 250px;
        height  : 200px;
        display: flex;
        justify-content: space-between;
        border-radius: 1em;
        /* background-color: #f3f3f3 */


    }

    .card {
        box-shadow: 5px 4px 7px rgba(0, 0, 0, 0.2);
    }

    .title {
        width: 100%;
        padding: .8em;
        text-align: center;

    }
    .image-card {

        /* width: 250px; */
        height: 200px;
        background-position: center;
        background-size: cover;

        



    }
    .footer {
        width: 100%;
        padding: .8em;
         border-top: 1px solid black;

    }
    .card-buttons {
        display: flex;
        justify-content: space-between;
        padding: 0;
    }
    .edit-button {
        position: absolute;
        top: -10px;
        right: -10px;
        border-radius: 50%;
        background-color: white;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
        border: solid 1px rgba(222, 222, 222, 0.4
        );
    }


</style>
