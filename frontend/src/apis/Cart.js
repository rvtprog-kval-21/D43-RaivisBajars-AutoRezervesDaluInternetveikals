import Api from './Api'

export default {
  addtoCart (cartForm) {
    return Api().post('/cart/add', cartForm)
  }
}
