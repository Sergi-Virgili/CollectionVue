<template>
  <div class="card container justify-content-sm-center" id="interestsForm">
    <div class="justify-content-center row">
      <label for="category_id">Busca tu categoria preferida</label>
    </div>
    <div class="col-sm-12 d-flex flex-nowrap">
      <input type="hidden" v-model="resultdata" />
      <input
        class="form-control"
        type="text"
        value="result.name"
        v-model="search"
        @input="onChange"
        @keydown.down="onArrowDown"
        @keydown.up="onArrowUp"
        @keydown.enter="onEnter"
      />
      <button class="btn btn-outline-primary order-2" @click="onEnter">Add</button>
    </div>
    <div id="relative" class="justify-content-center">
      <ul id="absolute" class="autocomplete-results" v-show="isOpen">
        <li
          class="autocomplete-result"
          v-for="(result, index) in results"
          :key="index"
          @click="setResult(result)"
          :class="{ 'is-active': index === arrowCounter }"
        >{{ result.name }}</li>
      </ul>
    </div>
    <div id="categoriesAttached" class="justify-content d-flex flex-wrap col-sm-12">
      <div id="categoryAttached" class v-for="(userCategory, index) in userCategories" :key="index">
        <button
          class="btn btn-outline-secondary"
          :id="userCategory.id"
          @click="removeCategory()"
        >{{userCategory.name}}</button>
      </div>
    </div>
    <div id="homeButton" class="justify-content-center row">
      <router-link :to="{name:'home'}">
        <button class="btn btn-success">HOME</button>
      </router-link>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  middleware: "auth",

  data() {
    return {
      categories: [],
      userCategories: [],
      isOpen: false,
      results: [],
      search: "",
      resultdata: "",
      isLoading: false,
      arrowCounter: -1
    };
  },

  methods: {
    onChange() {
      this.isOpen = true;
      this.filterResults();
    },
    onArrowDown(evt) {
      if (this.arrowCounter < this.results.length) {
        this.arrowCounter = this.arrowCounter + 1;
      }
    },
    onArrowUp() {
      if (this.arrowCounter > 0) {
        this.arrowCounter = this.arrowCounter - 1;
      }
    },
    onEnter() {
      const selfdata = this.resultdata;
      const id = selfdata.id;
      if (id != null) {
        console.log(selfdata);
        return this.attachCategories(selfdata);
      }
      return this.empty();
    },
    empty() {
      this.search = "";
      this.resultdata = "";
    },
    attachCategories(selfdata) {
      const searchid = selfdata;
      this.isOpen = false;
      this.arrowCounter = -1;

      const parameters = {
        id: searchid.id
      };

      axios
        .post("/api/register/attach", parameters)
        .then(response => console.log(response));
      axios.get("/api/categoryUser/data").then(response => {
        this.userCategories = response.data;
      });

      this.empty();
    },
    removeCategory() {
      let selectedCategoryButton = event.target.id;
      let toDelete = document.getElementById(selectedCategoryButton);
      const parameters = {
        id: selectedCategoryButton
      };
      axios
        .delete("/api/register/detach", { data: { parameters } })
        .then(response => console.log(response));
      toDelete.remove();
    },
    filterResults() {
      const self = this;

      this.results = this.categories.filter(function(category) {
        return category.name.toLowerCase().includes(self.search.toLowerCase());
      });
    },
    setResult(result) {
      this.resultdata = result;
      this.search = result.name;
      this.isOpen = false;
      return result;
    },
    handleClickOutside(evt) {
      if (!this.$el.contains(evt.target)) {
        this.isOpen = false;
        this.arrowCounter = -1;
      }
    }
  },

  mounted() {
    axios.get("/api/register/data").then(response => {
      this.categories = response.data;
    });

    axios.get("/api/categoryUser/data").then(response => {
      this.userCategories = response.data;
    });

    console.log("Component mounted.");

    document.addEventListener("click", this.handleClickOutside);
  },
  destroyed() {
    document.removeEventListener("click", this.handleClickOutside);
  }
};
</script>

<style>

.autocomplete-result {
  list-style-type: none;
  background-color: white;
}
.autocomplete-result:hover {
  background-color: #4aae9b;
  color: white;
  z-index: 100;
}
.autocomplete-result.is-active,
.autocomplete-result:hover {
  background-color: #4aae9b;
  color: white;
}
#homeButton {
  position: fixed;
  bottom: 5%;
  left: 45%;
}
#relative {
  position: relative;
}
#absolute {
  z-index: 100;
  position: absolute;
}

</style>
