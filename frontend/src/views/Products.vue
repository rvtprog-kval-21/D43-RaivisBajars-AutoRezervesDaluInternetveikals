<template>
<div class="products-content">
      <div class="products-item">
        <div class="products-item-content">
          <div class="image"><img v-bind:src="currentProduct.product_image"></div>
          <div class="info">
            <div class="title"><h3>{{currentProduct.brand_name}} {{ currentProduct.product_name }}</h3></div>
            <div class="id">Preces numurs: {{ currentProduct.product_id}}</div>
            <div class="quantity">Daudzums: {{ currentProduct.quantity }}</div>
            <div class="price">{{ currentProduct.product_price }}&euro;</div>
            <form @submit.prevent="addToCart">
            <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"> Pievienot Grozam</i></button>
          </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import Cart from '../apis/Cart'
import User from '../apis/User'

export default {
  data () {
    return {
      user: {},
      currentProduct: {},
      products: [],
      productInCart: null,
      cart: [],
      cartForm: {
        user_id: '',
        product_id: '',
        product_name: '',
        product_price: '',
        product_image: '',
        quantity: '1'
      }
    }
  },
  mounted () {
    User.auth().then(response => {
      this.user = response.data
    })
  },
  created () {
    this.axios.get('http://localhost:8000/api/products').then((response) => {
      this.products = response.data
      this.getProduct()
    })
  },
  methods: {
    getProduct () {
      this.currentProduct = this.products.find((element) => element.product_id === this.$route.params.id)
    },
    addToCart () {
      this.axios
        .get(`http://localhost:8000/api/cart/show/${this.user.id}`)
        .then((response) => {
          this.cart = response.data
          console.log('added')
          this.cartForm.user_id = this.user.id
          this.cartForm.product_id = this.currentProduct.product_id
          this.cartForm.product_name = this.currentProduct.product_name
          this.cartForm.product_price = this.currentProduct.product_price
          this.cartForm.product_image = this.currentProduct.product_image
          this.currentProduct.quantity -= 1
          this.updateProduct(this.currentProduct)
          Cart.addtoCart(this.cartForm)
        })
    },
    updateProduct (item) {
      this.axios.post(
        `http://localhost:8000/api/products/update/${item.product_id}`, item
      )
    },
    updateCartItem (item) {
      this.axios.post(
        `http://localhost:8000/api/cart/update/${item.cart_id}`, item
      )
    }
  }
}
</script>

<style lang="sass" scoped>
html, body
  overflow: hidden
  background-color: #0b0e11

.cloak
  overflow: hidden
  background-color: #0b0e11

::-webkit-scrollbar
    width: 8px

::-webkit-scrollbar-track
    -webkit-box-shadow: inset 0 0 6px #424242
    border-radius: 10px

::-webkit-scrollbar-thumb
    border-radius: 10px
    -webkit-box-shadow: inset 0 0 6px #9E9E9E

.products-content
  display: flex
  flex-direction: column
  background-color: #0b0e11
  height: 100%
  overflow: hidden
  padding-top: 25px
  padding-left: 20vw
  padding-right: 20vw
  .products-item
    background-color: #151a21
    border: 1px solid #151a21
    margin-bottom: 10px
    min-width: 720px
    transition: 0.25s ease
  .products-item-content
    display: flex
    flex-direction: row
    color: #dee3ea
    height: 100%

    .image
      padding-left: 10px
      padding-right: 10px
      padding-top: 10px
      padding-bottom: 10px
      text-align: center
      width: 600px
      img
        width: 100%

    .info
      display: flex
      flex-direction: column
      align-items: flex-start
      padding: 2rem
      width: 100%
      overflow: auto
      color: #dee3ea

      .id
        font-size: 12px
        color: grey

.cart-content-totalPrice
  color: white

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
