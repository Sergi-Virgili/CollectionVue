<template>
  <div class="card container justify-content-sm-center" id="categories">
    <div class="justify-content-center row">
      <h2>Categorias</h2>
    </div>
    <div class="col-sm-12 d-flex flex-wrap">
      <category
        v-for="(categoryItem, index) in categories"
        :key="categoryItem.id"
        :categoryItem="categoryItem"
        @deleteCategory="deleteCategory(index)"
        @updateCategory="updateCategory(index, arguments)"
      />
    </div>
    <div class="col-sm-12 d-flex flex-wrap">
      <div class="card col-sm-12">
        <CategoryForm
          v-if="isActive"
          @cancel="cancel"
          @create="getCategories"
        />
        <button
          id="createCategoryButton"
          class="btn btn-outline-success"
          @click="createCategoryForm()"
        >
          CREAR
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Category from "../components/Category";
import EditCategory from "../components/EditCategory";
import CategoryForm from "../components/CategoryForm";
import axios from "axios";

export default {
  middleware: "auth",

  data() {
    return {
      categories: [],
      isActive: false
    };
  },

  components: {
    EditCategory,
    Category,
    CategoryForm
  },

  methods: {
    createCategoryForm() {
      this.isActive = true;
    },
    cancel() {
      this.isActive = false;
    },
    deleteCategory(index) {
      this.categories.splice(index, 1);
    },
    getCategories() {
      axios.get("/api/register/data").then(response => {
        this.categories = response.data;
      });
      this.isActive = false;
    },
    updateCategory(index, category) {
      this.category[index] = category;
    }
  },

  mounted() {
    console.log("component mounted");

    this.getCategories();
  }
};
</script>

<style scoped>
/* #createCategoryButton{
        position: fixed;
        bottom: 5%;
        left: 60%;
    } */
</style>
