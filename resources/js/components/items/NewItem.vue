<template>
    <div class="card">   
    <div class="card-header">
        <h3 class="card-title">{{newItem.name}}
        </h3>
        <input 
            class="form-control" 
            type="text" 
            name="name"
            v-model="newItem.name">
        <div
            @click="closeItem()">
            
            <CloseButton />
        </div>
        <button @click="modifyItem">ok</button>
    </div>
    <div class="image">
        <div class="camIcon"><CamButton /></div>
    </div>
    <div class="card-body">
        {{newItem.description}}
        <textarea
          rows="5"
          name="description"  
          class="form-control area-input"
          v-model="newItem.description"></textarea>
    </div>
    
    </div>
</template>

<script>
import CloseButton from '../buttons/DeleteButton'
import CamButton from '../buttons/CamButton' 
import axios from 'axios'

export default {
    components: {
        CloseButton,
        CamButton
    },
    props: [
        'collection',
        'item'
        ],

    data() {
        return {
            newItem: {
                name: 'NewItem',
                image: '',
                description: 'Explain Why you collect this item'
            },
            collectionId: 1,
            isNew : true,
            editMode: false
        }
    },

    mounted() {
        console.log(item)
        if (item) {
            this.newItem = this.item
        }
    },
    methods: {
        closeItem() {
          
            this.$emit('closeItem')
        },
        saveItem(){

        },
        createItem(){
            const params = {
                name: this.newItem.name,
                description: this.newItem.description,
                collection_id: this.collectionId
            }
            axios.post('/api/item', params).then((Response) => {
                this.isNew = false
            })
        },
        modifyItem(){
            
            if (this.isNew) {
                this.createItem()
            }
            if (!this.isNew) {
                this.saveItem()
            }
        }

    }

}
</script>

<style lang="scss" scoped>

    .card {
        position: absolute;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100%;
        z-index: 100;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
    }
    .image {
        
        background-color: grey;
        height: 500px;
    }
    

</style>>

   