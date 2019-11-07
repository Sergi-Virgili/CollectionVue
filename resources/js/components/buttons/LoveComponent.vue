<template>
<div class="icon">
  <i class="far fa-heart" v-on:click="iLove()"></i>
  <span class="number-likes">123</span>

  </div>
</template>

<script>
export default {

    methods: {

        iLove() {
            //emit
            //alert('I love that')
        }
    }
}
</script>

<style scoped>


    .icon {
        
        color: rgb(133, 0, 0);
        padding: 1em;
    }

    .fa-heart:hover {
        color: red;
    }
    .number-likes {
        font-size: .8em;
    }

</style>
