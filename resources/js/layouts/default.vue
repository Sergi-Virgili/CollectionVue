<template>
  <div class="main-layout">
    <navbar class="menu" />

    <div class="container mt-4">
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from "~/components/Navbar";

export default {
  name: "MainLayout",

  components: {
    Navbar
  }
};
</script>

<style lang="scss" scoped>
</style>