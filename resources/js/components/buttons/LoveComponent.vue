<template>
    <div class="icon">
        <i v-if="!checked" class="far fa-heart" v-on:click="loveIt()"></i>
        <i v-if="checked" id="red" class="far fa-heart" v-on:click="dontLove()"></i>
        <span class="number-likes">123</span>

    </div>
</template>

<script>
export default {

    data(){
        return {
            checked: false,
        }
    },
    props: ['loved'],

    methods: {

        loveIt() {
            this.$emit('loveIt');
        },
        dontLove(){
            this.$emit('dontLove');
        }
    },
    watch:{
        loved: function(){
        if(this.checked !== true){
            return this.checked = true;
        }
        if(this.checked !==false){
            return this.checked = false;
        }
        },
    }
}
</script>

<style scoped>


    .icon {
        padding: 1em;
    }

    .fa-heart {
        color: rgb(130, 130, 130);;
    }
    #red{
        color: red;
    }
    .number-likes {
        font-size: .8em;
    }

</style>
