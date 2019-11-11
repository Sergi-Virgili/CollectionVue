<template>
    <div class="card">   
    <div class="card-header">
        <h3 class="card-title">{{newItem.name}}</h3>
        <div
            @click="closeItem()">
            <CloseButton />
        </div>
    </div>
    <div class="card-body">
        {{newItem.description}}
    </div>
    
    </div>
</template>

<script>
import CloseButton from '../buttons/DeleteButton'

export default {
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
        }
    },

    components: {
        CloseButton
    },
    mounted: {
        if (item) {
            this.newItem = item
        }
    },
    methods: {
        closeItem() {
          
            this.$emit('closeItem')
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

</style>>

   