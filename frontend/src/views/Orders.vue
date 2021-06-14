<template>
<div class="orders-content">
  <div v-if="this.order.length == 0">
      <h1 style="font-size: 23px; color: #dee3ea">Jūs neesat veicis nevienu pasūtījumu</h1>
      <h2 style="font-size: 16px; color: #dee3ea">Spiediet <router-link :to="{ name: 'category' }">šeit</router-link> lai turpinātu iepirkties.</h2>
    </div>
    <div class="orders-item-list">
      <div class="orders-item" v-for="(items, index) in order" :key="items.order_id">
        <div class="orders-item-content">
          <div class="info">
            <div class="title">Pasūtījuma numurs: {{ items.order_id }}</div>
            <div class="title">Piegādes veids:<span v-if="items.delivery === 'Veikala'">Preces saņemšana klientu centrā</span></div>
            <div class="price">Status: {{ items.status }}</div>
          </div>
          <div class="products">
        <div class="products-content">
            <div class="products-item-list">
                <div class="products-item" v-for="products in JSON.parse(order[index].products)" :key="products.cart_id">
                <div class="products-item-content" style="display: flex; color: black">
                <div class="image"><img v-bind:src="products.product_image" style="width: 100px"></div>
                <div class="product-info">
                  <div class="title"><h3>{{ products.product_name }}</h3></div>
                  <div class="quantity">Daudzums: {{ products.quantity}}</div>
                  <div class="price">{{ products.product_price}}&euro;/gab.</div>
            </div>
        </div>
    </div>
    </div>
        </div>
      </div>
      <div class="totalPrice">Kopā: {{ items.price}}&euro;</div>
          </div>
        </div>
    </div>
</div>
</template>

<script>
import User from '../apis/User'

export default {
  data () {
    return {
      user: {},
      order: []
    }
  },
  mounted () {
    User.auth().then((response) => {
      this.user = response.data
      this.axios
        .get(`http://localhost:8000/api/order/show/${this.user.id}`)
        .then((response) => {
          this.order = response.data
          for (let i = 0; i < this.order.length; i++) {
            console.log(JSON.parse(this.order[i].products))
          }
        })
    })
  }
}
</script>

<style lang="sass" scoped>
@import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css)
html, body
  overflow: hidden
  background-color: #0b0e11

.cloak
  overflow: hidden
  background-color: #0b0e11

::-webkit-scrollbar
    width: 8px

::-webkit-scrollbar-track
    -webkit-box-shadow: inset 0 0 2px #424242
    border-radius: 0px

::-webkit-scrollbar-thumb
    border-radius: 0px
    -webkit-box-shadow: inset 0 0 2px #9E9E9E

.orders-content
  padding-top: 25px
  padding-left: 200px
  padding-right: 200px
  display: flex
  flex-direction: column
  height: 90%
  background-color: #0b0e11
  min-width: 1130px
  overflow: hidden
  .orders-item-list
    overflow: auto
    .orders-item
      background-color: #151a21
      border: 1px solid #242c37
      border-radius: 5px
      margin-bottom: 10px
      min-width: 720px
    .orders-item-content
      display: flex
      flex-direction: column
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
        color: #dee3ea

        .title
          display: flex
          justify-content: center
          align-items: center
          padding: 5px
          text-align: center
          height: 100%
          width: 70vw
          min-width: 220px
          border-right: 1px solid #242c37

        .price
          display: flex
          justify-content: center
          align-items: center
          padding: 5px
          text-align: center
          height: 100%
          width: 30vw
          min-width: 220px
        .forms
          display: flex
          flex-direction: column
          align-items: center
          justify-content: center
          height: 100%
          width: 20vw
          min-width: 100px

          #quantityForm
            width: 90%
            .form-group
              margin: 2px

          #deleteForm
            .form-group
              margin-bottom: 0

.products
  .products-item-content
    border: 1px solid #242c37
    .image
      border-right: 1px solid #242c37
    .product-info
      padding: 0.25rem
      color: #dee3ea

.totalPrice
  color: #dee3ea
  display: flex
  justify-content: flex-end
  padding-right: 5px
</style>
