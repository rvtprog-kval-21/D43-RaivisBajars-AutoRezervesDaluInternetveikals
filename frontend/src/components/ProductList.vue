<template>
  <div class="products-content">
    <div class="grid">
      <div class="grid-column" v-for="product in products" :key="product.product_id">
        <router-link class="product" :to="{ name: 'products', params: { id: product.product_id } }">
          <div class="product-image">
              <img v-bind:src="product.product_image" />
            </div>
          <div class="product-content">
            <div class="product-info">
              <h2 class="product-price">{{ product.product_price }}&euro;<span class="amount"> /gab.</span></h2>
              <h2 class="product-title">{{product.brand_name}} {{ product.product_name }}</h2>
            </div>
          </div>
        </router-link>
      </div>
    </div>
    </div>
</template>

<script>
export default {
  props: ['products']
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

img
  max-width: 100%
  display: block

.products-content
  padding-left: 5px
  padding-right: 5px
  background-color: #0b0e11
  overflow: hidden

.grid
  display: grid
  width: 100%
  grid-template-columns: repeat(5, 1fr)
  margin-top: 10px
  margin-bottom: 10px
  gap: 1px

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
  font-size: 18px

  .amount
    font-size: 12px

@media all and (max-width: 980px)
  .grid
    display: grid
    grid-template-columns: repeat(3, 1fr)
    gap: 1.5rem

@media all and (max-width: 600px)
  .grid
    display: grid
    grid-template-columns: repeat(1, 1fr)
    gap: 1.5rem
</style>
