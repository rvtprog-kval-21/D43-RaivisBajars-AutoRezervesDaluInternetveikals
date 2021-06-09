<template>
  <div class="cart-content">
    <div v-if="this.cart.length > 0" class="header">
      <div class="header-content">
          <div class="header-title">Preces</div>
          <div class="header-description"></div>
          <div class="header-price">Cena(gab.)</div>
          <div class="header-quantity">Skaits</div>
          <div class="header-price-quantity">Cena</div>
      </div>
    </div>
    <div v-if="this.cart.length == 0">
      <h1 style="font-size: 23px; color: #dee3ea">Pirkumu grozs ir tukšs</h1>
      <h2 style="font-size: 16px; color: #dee3ea">Grozs ir tukšs.</h2>
      <h2 style="font-size: 16px; color: #dee3ea">Spiediet <router-link :to="{ name: 'category' }">šeit</router-link> lai turpinātu iepirkties.</h2>
    </div>
    <div class="cart-item-list">
      <div class="cart-item" v-for="items in cart" :key="items.cart_id">
        <div class="cart-item-content">
          <div class="image"><img v-bind:src="items.product_image"></div>
          <div class="info">
            <div class="title"><h3>{{ items.product_name }}</h3></div>
            <div class="price">{{ items.product_price }}&euro;</div>
            <div class="forms">
              <form @submit.prevent="updateCartItem(items)" @input="updateCartItem(items)" id="quantityForm">
              <div class="form-group">
                <input type="number" class="form-control" v-model="items.quantity">
              </div>
            </form>
            <form @submit.prevent="deleteCartItem(items.cart_id)" id="deleteForm">
              <div class="form-group">
                <button type="submit" class="btn">
                  <i class="fa fa-minus-square"></i>
                </button>
              </div>
            </form>
            </div>
            <div class="totalPrice">{{items.product_price * items.quantity}}&euro;</div>
          </div>
        </div>
      </div>
    </div>
    <router-link
          v-if="cart.length > 0"
          class="btn btn-primary"
          :to="{ name: 'order' }"
        >
          Apmaksāt
        </router-link>
  </div>
</template>

<script>
import User from '../apis/User'

export default {
  data () {
    return {
      user: {},
      totalPrice: null,
      cart: [],
      products: [],
      currentProduct: []
    }
  },
  mounted () {
    User.auth().then((response) => {
      this.user = response.data
      this.axios
        .get(`http://localhost:8000/api/cart/show/${this.user.id}`)
        .then((response) => {
          this.cart = response.data
          console.log(this.cart)
          this.getTotalPrice()
        })
    })
  },
  methods: {
    updateCartItem (item) {
      this.axios.post(
        `http://localhost:8000/api/cart/update/${item.cart_id}`, item
      ).then((response) => {
        this.currentProduct = response.data
        this.axios.get('http://localhost:8000/api/products').then((response) => {
          this.products = response.data
          for (let i = 0; i < this.products.length; i++) {
            if (this.products[i].product_id === this.currentProduct.product_id) {
              this.products[i].quantity -= 1
              this.updateProduct(this.products[i])
            }
          }
        })
      })
    },
    deleteCartItem (id) {
      this.axios
        .delete(`http://localhost:8000/api/cart/delete/${id}`)
        .then((response) => {
          this.cart.splice(this.cart.map((item) => item.id).indexOf(id), 1)
          this.$router.go(0)
        })
    },
    getTotalPrice () {
      this.cart.forEach((item) => {
        this.totalPrice += item.product_price * item.quantity
      })
    },
    updateProduct (item) {
      this.axios.post(
        `http://localhost:8000/api/products/update/${item.product_id}`, item
      )
    }
  }
}
</script>

<style lang="sass" scoped>
@import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css)
html, body
  overflow: hidden

.cloak
  overflow: hidden

::-webkit-scrollbar
    width: 8px

::-webkit-scrollbar-track
    -webkit-box-shadow: inset 0 0 2px #424242
    border-radius: 0px

::-webkit-scrollbar-thumb
    border-radius: 0px
    -webkit-box-shadow: inset 0 0 2px #9E9E9E

.cart-content
  padding-top: 25px
  padding-left: 200px
  padding-right: 200px
  display: flex
  flex-direction: column
  height: 90%
  overflow: hidden
  min-width: 1130px

  .cart-item-list
    overflow: auto

  .header
    height: 50px
    min-width: 720px

    .header-content
      height: 100%
      padding: 5px
      display: flex
      color: #dee3ea
      text-align: center

      .header-title
        min-width: 123px

      .header-description
        width: 50vw
        min-width: 220px

      .header-price
        width: 20vw
        min-width: 100px

      .header-quantity
        width: 20vw
        min-width: 100px

      .header-price-quantity
        width: 20vw
        min-width: 100px
        padding-right: auto

  .cart-item-list
    .cart-item
      background-color: #151a21
      border: 1px solid #242c37
      border-radius: 5px
      height: 125px
      margin-bottom: 10px
      min-width: 720px
    .cart-item-content
      display: flex
      flex-direction: row
      color: #dee3ea
      height: 100%

      .image
        padding-left: 5px
        padding-right: 5px
        padding-top: 5px
        padding-bottom: 5px
        text-align: center
        width: 125px
        img
          height: 100%

      .info
        display: flex
        flex-direction: row
        align-items: center
        width: 100%
        overflow: auto
        color: #dee3ea

        .title
          display: flex
          justify-content: flex-start
          align-items: center
          padding: 5px
          text-align: center
          height: 100%
          width: 50vw
          min-width: 220px
          border-left: 1px solid #242c37
          border-right: 1px solid #242c37

        .price
          display: flex
          justify-content: center
          align-items: center
          text-align: center
          height: 100%
          width: 20vw
          min-width: 100px
          border-right: 1px solid #242c37
        .forms
          display: flex
          flex-direction: column
          align-items: center
          justify-content: center
          height: 100%
          width: 20vw
          min-width: 100px
          border-right: 1px solid #242c37

          #quantityForm
            width: 90%
            .form-group
              margin: 2px

          #deleteForm
            .form-group
              margin-bottom: 0

.totalPrice
    text-align: center
    font-size: 24px
    font-weight: bold
    min-width: 100px
    width: 20vw

.cart-content-totalPrice
  display: flex
  justify-content: flex-end
  color: #dee3ea
  font-size: 24px
  font-weight: bold
</style>
