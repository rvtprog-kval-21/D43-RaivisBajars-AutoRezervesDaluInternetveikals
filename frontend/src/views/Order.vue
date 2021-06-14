<template>
<div class="products-content">
      <div class="products-item">
        <div class="products-item-content">
          <div class="info">
            <form @submit.prevent="updateUser(user)" id="userForm">
          <div class="name" style="width: 50%; float: left">
            <div class="form-group">
            <label for="name">Vārds:</label>
            <input
              type="text"
              v-model="user.name"
              class="form-control"
              id="name"
            />
            </div>
          </div>
          <div class="surename" style="width: 50%; float: right">
            <div class="form-group">
            <label for="surename">Uzvārds:</label>
            <input
              type="text"
              v-model="user.surename"
              class="form-control"
              id="surename"
            />
            </div>
          </div>
          <div class="phone" style="width: 50%; float: left">
            <div class="form-group">
              <label for="phone">Tālrunis:</label>
            <input
              type="text"
              v-model="user.phone"
              class="form-control"
              id="phone"
            />
            </div>
          </div>
          <div class="email" style="width: 50%; float: right">
            <div class="form-group">
              <label for="email">E-pasta adrese:</label>
            <input
              type="text"
              v-model="user.email"
              class="form-control"
              id="email"
            />
            </div>
          </div>
          <div class="country" style="width: 50%; float: left">
            <div class="form-group">
              <label>Valsts:</label>
             <select v-model="user.country" class="form-control">
              <option disabled value="">Izvēlaties valsti</option>
              <option>Latvija</option>
              <option>Igaunija</option>
              <option>Lietuva</option>
            </select>
            </div>
          </div>
          <div class="city" style="width: 50%; float: right">
            <div class="form-group">
              <label for="city">Pilsēta:</label>
            <input
              type="text"
              v-model="user.city"
              class="form-control"
              id="city"
            />
            </div>
          </div>
          <div class="street" style="width: 50%; float: left">
            <div class="form-group">
              <label for="street">Adrese:</label>
            <input
              type="text"
              v-model="user.street"
              class="form-control"
              id="street"
            />
            </div>
          </div>
          <div class="zip-code" style="width: 50%; float: right">
            <div class="form-group">
              <label for="zip-code">Pasta indeks:</label>
            <input
              type="text"
              v-model="user.zip"
              class="form-control"
              id="zip-code"
            />
            </div>
          </div>
          <div class="contact">
            <div class="form-group">
              <label>Izvēlaties saziņas veidu:</label>
            <br>
            <input type="radio" id="contact-email" value="E-pasts" v-model="user.contact">
            <label for="contact-email"> E-pasts</label>
            <br>
            <input type="radio" id="contact-phone" value="Telefons" v-model="user.contact">
            <label for="contact-phone">Telefons</label>
            <br>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Atjaunot informāciju</button>
          <br>
          <br>
        </form>
        <form @submit.prevent="addOrder">
            <div class="delivery">
            <div class="form-group">
              <label>Izvēlaties piegādes veidu:</label>
            <br>
            <input type="radio" id="delivery-client-center" value="Veikala" v-model="order.delivery">
            <label for="delivery-client-center">Preces saņemšana klientu centrā</label>
            </div>
          </div>
          <div class="price">Summa apmaksai: {{this.totalPrice}}&euro;</div>
          <button type="submit" class="btn btn-primary">Apmaksāt</button>
        </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import User from '../apis/User'
import Order from '../apis/Order'

export default {
  data () {
    return {
      user: [],
      cart: [],
      order: [],
      totalPrice: null,
      orderForm: {
        user_id: '',
        status: 'Nepabeigts',
        delivery: '',
        products: '',
        price: ''
      }
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
          console.log(this.totalPrice)
        })
      this.axios
        .get(`http://localhost:8000/api/order/show/${this.user.id}`)
        .then((response) => {
          this.order = response.data
          this.order.products = JSON.parse(this.order[0].products)
        })
    })
  },
  methods: {
    getTotalPrice () {
      this.cart.forEach((item) => {
        this.totalPrice += item.product_price * item.quantity
      })
    },
    addOrder () {
      this.orderForm.user_id = this.user.id
      this.orderForm.delivery = this.order.delivery
      this.orderForm.products = JSON.stringify(this.cart)
      this.orderForm.price = this.totalPrice
      console.log(this.orderForm)
      Order.addOrder(this.orderForm)
      this.deleteCartItem(this.user.id)
      this.$router.push('orders')
    },
    deleteCartItem (id) {
      this.axios.delete(`http://localhost:8000/api/cart/deleteall/${id}`)
    }
  }
}
</script>

<style lang="sass" scoped>
html, body
  overflow: hidden

.cloak
  overflow: hidden

::-webkit-scrollbar
    width: 8px

::-webkit-scrollbar-track
    -webkit-box-shadow: inset 0 0 6px #424242
    border-radius: 10px

::-webkit-scrollbar-thumb
    border-radius: 10px
    -webkit-box-shadow: inset 0 0 6px #9E9E9E

.products-content
  color: #dee3ea
  display: flex
  flex-direction: column
  background-color: #0b0e11
  height: 100%
  overflow: hidden
  padding-top: 25px
  padding-left: 20vw
  padding-right: 20vw
  .products-item
    color: #dee3ea
    background-color: #151a21
    border: 1px solid #242c37
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

    input
      background-color: #242c37
      border-radius: 5px
      color: #506f84
      border: none
    input:focus
      background-color: #242c37
      border-radius: 5px
      color: #506f84
      border: none
    select
      background-color: #242c37
      border-radius: 5px
      color: #506f84
      border: none
    select:focus
      background-color: #242c37
      border-radius: 5px
      color: #506f84
      border: none
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

.form-group
  margin: 2px

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
