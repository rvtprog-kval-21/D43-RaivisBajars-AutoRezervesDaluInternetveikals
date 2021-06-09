<template>
  <div class="register-content">
    <h1 class="text-center">Reģistrācija</h1>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="name">Vārds:</label>
          <input
            type="text"
            v-model="form.name"
            class="form-control"
            id="name"
          />
          <span class="text-danger" v-if="errors.name">
            {{ errors.name[0] }}
          </span>
        </div>
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
        <div class="form-group">
          <label for="password_confirmation">Apstipriniet paroli:</label>
          <input
            type="password"
            v-model="form.password_confirmation"
            class="form-control"
            id="password_confirmation"
          />
          <span class="text-danger" v-if="errors.password_confirmation">
            {{ errors.password_confirmation[0] }}
          </span>
        </div>
        <button
          type="submit"
          @click.prevent="register"
          class="btn btn-primary btn-block"
        >
          Reģistrēties
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
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      errors: []
    }
  },
  methods: {
    register () {
      User.register(this.form)
        .then(() => {
          this.$router.push({
            name: 'Login'
          })
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    }
  }
}
</script>

<style lang="sass" scoped>
.register-content
  color: #dee3ea
  padding-left: 30%
  padding-right: 30%
  padding-top: 25px
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
