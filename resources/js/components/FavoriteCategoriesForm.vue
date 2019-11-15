<template>
    <div class="card container justify-content-sm-center" id="interestsForm" >
            <div class="autocomplete justify-content-sm-center">
                <label for="category_id">Busca tu categoria preferida</label>
                <input class="form-control" type="text" value="result.name" v-model="search" @input="onChange" @keydown.down="onArrowDown" @keydown.up="onArrowUp" @keydown.enter="onEnter">
                <ul class="autocomplete-results" v-show="isOpen">
                    <li class="autocomplete-result" v-for="(result, index) in results" :key="index" @click="setResult(result)" :class="{ 'is-active': index === arrowCounter }">
                              {{ result.name }}
                    </li>
                </ul>
            </div>
            <div id="categoriesAttached" class="justify-content-sm-center flex-sm-wrap">
                <div id="categoryAttached" class="" v-for="(userCategory, index) in userCategories" :key="index">
                    <button class="btn btn-outline-secondary" :id="userCategory.id" @click="removeCategory()">{{userCategory.name}}</button>
                </div>
            </div>
    </div>
</template>

<script>

    export default {
        name: 'autocomplete',
        
        data() {
            return {
                categories: [],
                userCategories: [],
                isOpen: false,
                results: [],
                search: '',
                isLoading: false,
                arrowCounter: -1,
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
                    this.arrowCounter = this.arrowCounter -1;
                }
            },
            onEnter() {
                const searchid = this.search
                this.isOpen = false;
                this.arrowCounter = -1;

                const parameters = {
                    id: searchid.id
                };

                axios.post('/register/attach', parameters).then((response) => console.log(response));
            },
            removeCategory() {
                let selectedCategoryButton = event.target.id
                let toDelete = document.getElementById(selectedCategoryButton);
                const parameters = {
                    id: selectedCategoryButton
                };
                axios.delete('/register/detach', {data:{parameters}}).then((response) => console.log(response));
                toDelete.remove();
            },
            filterResults() {
                const self = this
                
                this.results = this.categories.filter(function (category){
                   return category.name.toLowerCase().includes(self.search.toLowerCase());
                });
            },
            setResult(result) {
                this.search = result;
                this.isOpen = false;
                return result;
            },
            handleClickOutside(evt) {
                if (!this.$el.contains(evt.target)) {
                    this.isOpen = false;
                    this.arrowCounter = -1;
                }
            },
        },

        mounted() {
            axios
                .get('/register/data')
                .then((response) => {
                    this.categories = response.data;
                });
            console.log('Component mounted.')
            axios
                .get('/categoryUser/data')
                .then((response) => {
                    this.userCategories = response.data;
                });
            console.log('Component mounted.')
            document.addEventListener('click', this.handleClickOutside);
        },
        destroyed() {
            document.removeEventListener('click', this.handleClickOutside);
        }
    }
</script>

<style>
  .autocomplete {
    position: relative;
    width: 130px;
  }

  .autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    height: 120px;
    overflow: auto;
  }

  .autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    cursor: pointer;
  }

  .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
  }
  .autocomplete-result.is-active,
  .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
  }
</style>
