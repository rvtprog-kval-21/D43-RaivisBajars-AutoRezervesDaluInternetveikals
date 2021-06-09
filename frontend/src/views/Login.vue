<template>
  <div class="login-content">
    <h1 class="text-center">Pievienoties</h1>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="email">E-pasta adrese:</label>
          <input
            type="email"
            v-model="form.email"
            class="form-control"
            id="email"
          />
          <span class="text-danger" v-if="errors.email">
            {{ errors.email[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="password">Parole:</label>
          <input
            type="password"
            v-model="form.password"
            class="form-control"
            id="password"
          />
          <span class="text-danger" v-if="errors.password">
            {{ errors.password[0] }}
          </span>
        </div>
        <button @click.prevent="login" class="btn btn-primary btn-block">
          Pievienoties
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import User from '../apis/User'
export default {
  data () {
    return {
      form: {
        email: '',
        password: '',
        device_name: 'browser'
      },
      errors: []
    }
  },
  methods: {
    login () {
      User.login(this.form)
        .then(response => {
          this.$root.$emit('login', true)
          localStorage.setItem('token', response.data)
          this.$router.push({ name: 'Dashboard' })
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    }
  }
}
</script>

<style lang="sass" scoped>
.login-content
  color: #dee3ea
  padding-top: 25px
  padding-left: 30%
  padding-right: 30%
.card
  border-radius: 5px
  border: 1px solid #242c37
.card-body
  border: none
  background-color: #151a21
input
  background-color: #242c37
  border: none
  color: #506f84
input:focus
  background-color: #242c37
  border: none
  color: #506f84
</style>
