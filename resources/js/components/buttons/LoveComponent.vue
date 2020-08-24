<template>
  <div class="icon">
    <i v-if="!checked" class="far fa-heart" v-on:click="loveIt()"></i>
    <i v-if="checked" id="red" class="far fa-heart" v-on:click="dontLove()"></i>
    <span class="number-likes">{{this.likes}}</span>
  </div>
</template>

<script>
export default {
  data() {
    return {
      checked: false,
    };
  },
  props: ["loved", "likes"],

  methods: {
    loveIt() {
      this.$emit("loveIt");
    },
    dontLove() {
      this.$emit("dontLove");
    },
  },
  watch: {
    loved: function () {
      if (this.checked !== true) {
        return (this.checked = true);
      }
      if (this.checked !== false) {
        return (this.checked = false);
      }
    },
    likes: function () {},
  },
};
</script>

<style scoped>
.icon {
  padding: 1em;
}

.icon:hover {
  cursor: pointer;
}

.fa-heart {
  color: rgb(130, 130, 130);
}
#red {
  color: red;
}
.number-likes {
  font-size: 0.8em;
}
</style>
