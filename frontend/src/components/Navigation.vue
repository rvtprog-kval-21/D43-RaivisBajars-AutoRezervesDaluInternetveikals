<template>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color: #0b0e11">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <router-link
          v-if="!isLoggedIn"
          class="nav-item nav-link"
          :to="{ name: 'Login' }"
        >
          <i class="fa fa-user"><span class="nav-text"> Pievienoties</span></i>
        </router-link>
        <a
          class="nav-item nav-link"
          :href="$router.resolve({name: 'category'}).href"
        >
          <i class="fa fa-list-ul"><span class="nav-text"> Kategorijas</span></i>
        </a>
        <router-link
          v-if="isLoggedIn"
          class="nav-item nav-link"
          :to="{ name: 'cart' }"
        >
          <i class="fa fa-shopping-cart"><span class="nav-text"> Grozs</span></i>
        </router-link>
        <router-link
          v-if="!isLoggedIn"
          class="nav-item nav-link"
          :to="{ name: 'Register' }"
        >
          Reģistrēties
        </router-link>
        <router-link
          v-if="isLoggedIn"
          class="nav-item nav-link"
          :to="{ name: 'Dashboard' }"
        >
          <i class="fa fa-cog"><span class="nav-text"> Panelis</span></i>
        </router-link>
        <router-link
          v-if="isLoggedIn"
          class="nav-item nav-link"
          :to="{ name: 'orders' }"
        >
          <i class="fa fa-archive"><span class="nav-text"> Pasūtījumi</span></i>
        </router-link>
        <a
          class="nav-item nav-link"
          v-if="isLoggedIn"
          @click.prevent="logout"
          href="#"
          ><i class="fa fa-user"><span class="nav-text"> Iziet</span></i></a
        >
        <div class="search">
        <input type="text" v-model="keyword" placeholder="Meklēt preci, kategoriju" class="search_input" :class="{ 'active' : Search.length > 0 && keyword}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Meklēt preci, kategoriju'">
        <ul v-if="Search.length > 0 && keyword" class="search-ul" >
          <li class="search-item" v-for="srch in Search.slice(0,10)" :key="srch.id">
            <router-link class="search-link" :to=" {name: 'category', params: { url: srch.category_name.normalize('NFKD').replace(/[\u0300-\u036F]/g, '').replace(/\s+/g, '-').toLowerCase() }}">
              <div v-text="srch.category_name" class="search-text"></div>
            </router-link>
          </li>
          <li class="search-item" v-for="prod in productSearch.slice(0,10)" :key="prod.product_id">
            <router-link class="search-link" :to=" {name: 'products', params: { id: prod.product_id }}">
              <div v-text="prod.brand_name + ' ' +  prod.product_name" class="search-text"></div>
            </router-link>
          </li>
        </ul>
    </div>
    </ul>
  </div>
</nav>
</template>

<script>
import User from '../apis/User'
export default {
  data () {
    return {
      isLoggedIn: false,
      Search: [],
      productSearch: [],
      keyword: null
    }
  },
  mounted () {
    this.$root.$on('login', () => {
      this.isLoggedIn = true
    })
    this.isLoggedIn = !!localStorage.getItem('token')
  },
  watch: {
    keyword (after, before) {
      this.getResults()
    }
  },
  methods: {
    logout () {
      User.logout().then(() => {
        localStorage.removeItem('token')
        this.isLoggedIn = false
        this.$router.push({ name: 'Home' })
      })
    },
    getResults () {
      this.axios.get('http://localhost:8000/api/category/search', { params: { keyword: this.keyword } }).then((res) => { this.Search = res.data })
      this.axios.get('http://localhost:8000/api/products/search', { params: { keyword: this.keyword } }).then((res) => { this.productSearch = res.data })
    }
  }
}
</script>

<style lang="sass" scoped>
.router-link-exact-active
  color: #ffffff !important
  transition: all 0.25s

.nav-text
  font-family: 'Roboto', sans-serif;
  color: #dee3ea

.navbar-nav
  width: 100%
  align-items: center

.search_input
  width: 300px
  height: 40px
  border-radius: 5px
  background-color: #242c37
  border: 1px solid #E0E0E0
  color: #506f84
  padding-left: 5px
  padding-right: 5px

.search_input::placeholder
  color: #506f84

.search_input.active
  border-bottom-left-radius: 0
  border-bottom-right-radius: 0

.search
  float: right
  input
    outline: none
    border: none
  input:focus, textarea:focus, select:focus
    outline: none
  .search-ul
    position: absolute
    background-color: #242c37
    list-style-type: none
    padding: 0
    border-bottom-left-radius: 5px
    border-bottom-right-radius: 5px
    .search-item:hover
      background-color: #151a21
    .search-link:hover
      text-decoration: none
    .search-text
      padding: 5px
      width: 300px
      color: #dee3ea
      text-decoration: none

@media all and (max-width: 991px)
  .nav-text
    display: inline
  .fa
    font-size: 16px
</style>
