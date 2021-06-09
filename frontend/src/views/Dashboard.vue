<template>
  <div class="dashboard-content">
    <h1 v-if="user.is_admin">Administratora Panelis</h1>
    <h1 v-else>Lietotāja Panelis</h1>
    <div class="card" id="welcomeCard">
      <div class="card-body" v-if="user">
        <h3>Sveiki, {{ user.name + ' ' + user.surename}}</h3>
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
          <button type="submit" class="btn btn-primary">
            Atjaunot informāciju
          </button>
        </form>
    </div>
    <div class="forms" v-if="user.is_admin">
<div class="card" id="add">
      <div class="card-body">
        <h3>Pievienot kategoriju</h3>
    <form @submit.prevent="addCategory">
        <div class="form-group">
            <label>Kategorijas nosaukums</label>
            <input
              type="text"
              class="form-control"
              v-model="categoryForm.category_name"
            />
        </div>
        <div class="form-group">
          <label>Apakškategorija</label><br>
          <select class="form-control" v-model="categoryForm.parent_category">
            <option v-for="child in categories" :key="child.id" v-bind:value="child.id">
              {{child.category_name}}
            </option>
          </select>
          <span></span>
        </div>
          <div class="form-group">
            <label>Attēls</label><br>
            <input id="file" type="file" class="form-control-file" v-on:change="categoryImage">
            <div class="imageUpload">
              <img v-bind:src="categoryForm.image" width="100" height="100"><br>
              <label for="file" id="filelabel">Izvēlēties</label>
            </div>
          </div>
        <button type="submit" class="btn btn-primary">Pievienot</button>
      </form>
    </div>
    </div>
    <div class="card" id="add">
      <div class="card-body">
        <h3>Pievienot preci</h3>
    <form @submit.prevent="addProduct">
        <div class="form-group">
            <label>Preces nosaukums</label>
            <input
              type="text"
              class="form-control"
              v-model="productForm.product_name"
            />
        </div>
        <div class="form-group">
          <label>Ražotājs</label><br>
          <select class="form-control" v-model="productForm.brand_id">
            <option v-for="brand in brands" :key="brand.brand_id" v-bind:value="brand.brand_id">
              {{brand.brand_name}}
            </option>
          </select>
          <span></span>
        </div>
        <div class="form-group">
          <label>Kategorija</label><br>
          <select class="form-control" v-model="productForm.category_id">
            <option v-for="category in categories" :key="category.id" v-bind:value="category.id">
              {{category.category_name}}
            </option>
          </select>
          <span></span>
        </div>
        <div class="form-group">
            <label>Preces cena</label>
            <input
              type="number"
              class="form-control"
              v-model="productForm.product_price"
            />
        </div>
        <div class="form-group">
            <label>Attēls</label><br>
            <input id="productFile" type="file" class="form-control-file" v-on:change="productImage">
            <div class="imageUpload">
              <img v-bind:src="productForm.product_image" width="100" height="100"><br>
              <label for="productFile" id="filelabel">Izvēlēties</label>
            </div>
          </div>
        <button type="submit" class="btn btn-primary">Pievienot</button>
      </form>
    </div>
    </div>
    </div>
  </div>
  </div>
</template>

<script>

import User from '../apis/User'
import Category from '../apis/Category'
import Product from '../apis/Product'
export default {
  data () {
    return {
      user: null,
      category: {},
      categoryForm: {
        category_name: '',
        parent_category: '',
        image: 'https://dummyimage.com/600x600/f5f5f5/000000.png&text=Placeholder'
      },
      product: {},
      productForm: {
        product_name: '',
        product_image: 'https://dummyimage.com/600x600/f5f5f5/000000.png&text=Placeholder',
        brand_id: '',
        category_id: '',
        product_price: '',
        quantity: '1'
      },
      categories: [],
      brands: []
    }
  },
  mounted () {
    User.auth().then(response => {
      this.user = response.data
      this.axios.get('http://localhost:8000/api/category').then((response) => {
        this.categories = response.data
      })
      this.axios.get('http://localhost:8000/api/brand').then((response) => {
        this.brands = response.data
      })
    })
  },
  methods: {
    addCategory () {
      Category.addCategory(this.categoryForm)
    },
    addProduct () {
      Product.addProduct(this.productForm)
    },
    categoryImage (event) {
      const reader = new FileReader()
      const temp = event.target.files[0]
      reader.readAsDataURL(temp)
      reader.onload = () => {
        this.iconBase64 = reader.result
        this.categoryForm.image = reader.result
      }
    },
    productImage (event) {
      const reader = new FileReader()
      const temp = event.target.files[0]
      reader.readAsDataURL(temp)
      reader.onload = () => {
        this.iconBase64 = reader.result
        this.productForm.product_image = reader.result
      }
    },
    updateUser (item) {
      this.axios.post(
        `http://localhost:8000/api/update/${item.id}`, item
      )
    }
  }
}
</script>

<style lang="sass" scoped>
.dashboard-content
  color: #dee3ea
  background-color: #0b0e11
  padding-left: 20%
  padding-right: 20%
  padding-bottom: 5%
#welcomeCard
  min-width: 600px
  background-color: #151a21
  border: 1px solid #242c37
  border-radius: 5px
.forms
  min-width: 600px
  height: 700px
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
.form-group
  margin: 2px
#add
  width: 50%
  height: 100%
  margin-right: 0
  margin-left: 0
  display: inline-flex
  justify-content: center
  min-height: 470px
  background-color: #151a21
  border: 1px solid #242c37
  border-radius: 0
#add h3
  text-align: center
.form-control
  border-radius: 5px
.form-control-file
  width: 0.1px
  height: 0.1px
  opacity: 0
  overflow: hidden
  position: absolute
  z-index: -1
#filelabel:hover
  cursor: pointer
  color: #fff
  background-color: #0069d9
  border-color: #0062cc
#filelabel
  text-align: center
  width: 100%
  height: 100%
  margin-bottom: 0
  color: #fff
  background-color: #007bff
  border-color: #007bff
  border-top: 1px solid #dedede
.imageUpload
  border: 1px solid #242c37
  width: 102px
form button
  width: 90%
  margin: 0 auto
  display: block
  border-radius: 5px
</style>
