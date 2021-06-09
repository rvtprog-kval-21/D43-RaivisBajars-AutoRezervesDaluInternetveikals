<template>
<div class="content">
  <div class="category-content">
    <div class="grid" v-if="getVisibility() == 'categories' || getVisibility() == 'categories_and_products'">
      <div class="grid-column" v-for="categories in sortedCategories" :key="categories.id">
        <router-link class="product" :to="{ name: 'category', params: { url: categories.url } }">
          <div class="product-image">
              <img v-bind:src="categories.image" />
            </div>
          <div class="product-content">
            <div class="product-info">
              <h2 class="product-title">{{ categories.category_name }}</h2>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
  <ProductList :products="products" v-if="getVisibility() == 'products' || getVisibility() == 'categories_and_products'"></ProductList>
</div>
</template>

<script>

import ProductList from '../components/ProductList'

export default {
  components: {
    ProductList
  },
  data () {
    return {
      category: [],
      sortedCategories: [],
      currentCategory: null,
      products: []
    }
  },
  created () {
    this.axios.get('http://localhost:8000/api/category').then((response) => {
      this.category = response.data
      this.sortCategories()
      this.getProducts()
    })
  },
  watch: {
    $route (to, from) {
      this.sortCategories()
      this.getProducts()
    }
  },
  methods: {
    deleteCategory (id) {
      this.axios
        .delete(`http://localhost:8000/api/category/delete/${id}`)
        .then((response) => {
          const i = this.category.map((item) => item.id).indexOf(id)
          this.category.splice(i, 1)
        })
    },
    getCategoryByUrl (url) {
      return this.category.find((element) => element.url === url)
    },
    sortCategories () {
      this.sortedCategories = []
      if (this.$route.params.url !== undefined) {
        this.currentCategory = this.getCategoryByUrl(this.$route.params.url)
        this.category.forEach((element) => {
          if (element.parent_category === this.currentCategory.id) {
            element.image = 'https://dummyimage.com/600x600/f5f5f5/000000.png&text=Placeholder'
            this.sortedCategories.push(element)
          }
        })
      } else {
        this.category.forEach((element) => {
          if (element.parent_category == null) {
            if (element.image == null) {
              element.image = 'https://dummyimage.com/600x600/f5f5f5/000000.png&text=Placeholder'
            }
            this.sortedCategories.push(element)
          }
        })
      }
    },
    getProducts () {
      this.axios.get(`http://localhost:8000/api/products/show/${this.currentCategory.id}`).then((response) => {
        this.products = response.data
      })
    },
    getVisibility () {
      if (this.currentCategory) {
        return this.currentCategory.visibility
      }
      return 'categories'
    }
  }
}
</script>

<style lang="sass" scoped>
@import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css)
body
  overflow: hidden

::-webkit-scrollbar
    width: 8px

::-webkit-scrollbar-track
    -webkit-box-shadow: inset 0 0 6px #424242
    border-radius: 10px

::-webkit-scrollbar-thumb
    border-radius: 10px
    -webkit-box-shadow: inset 0 0 6px #9E9E9E

@import url("https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap")
@import url("https://fonts.googleapis.com/icon?family=Material+Icons")
img
  max-width: 100%
  display: block

.content
  padding-top: 25px
  padding-left: 200px
  padding-right: 200px
  min-width: 650px
  background-color: #0b0e11

.category-content
  background-color: #0b0e11
  overflow: hidden

.grid
  display: grid
  width: 100%
  grid-template-columns: repeat(6, 1fr)
  padding-left: 5px
  padding-right: 5px
  margin-top: 10px
  margin-bottom: 10px
  gap: 0.5rem

.grid-column
  display: flex
  flex-direction: column
  min-width: 155px
  max-width: 402px
  background-color: #151a21
  border-radius: 0.25rem

  img
    margin-left: 0
    margin-right: 0
    text-align-center
    width: 90%
    background-color: #151a21

.product
  display: flex
  flex-direction: column
  justify-content: space-between
  text-decoration: none
  font-weight: 400
  transition: 0.25s ease
  overflow: hidden
  min-height: 200px
  height: 100%
  color: #dee3ea
  border: 1px solid #151a21
  border-radius: 5px

.product:hover,
.product:focus
  outline: none
  color: #dee3ea
  box-shadow: 0 0 0 0.1rem #242c37
  border-radius: 5px

.product-image
  display: flex
  justify-content: center
  overflow: hidden

.product-content
  padding: 0.25rem
  transition: 0.15s ease
  background-color: #151a21!important

.product-info
  display: flex
  flex-direction: column

.product-title
  font-size: 1.125rem
  line-height: 1.25
  margin-bottom: 10px

.product-price
  margin-top: 0.25rem

@media all and (max-width: 1500px)
  .grid
    display: grid
    grid-template-columns: repeat(9, 1fr)

@media all and (max-width: 1180px)
  .grid
    display: grid
    grid-template-columns: repeat(3, 1fr)

@media all and (max-width: 935px)
  .grid
    display: grid
    grid-template-columns: repeat(2, 1fr)

@media all and (max-width: 755px)
  .grid
    display: grid
    grid-template-columns: repeat(1, 1fr)
</style>
