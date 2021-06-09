import Api from './Api'

export default {
  addOrder (orderForm) {
    return Api().post('/order/add', orderForm)
  }
}
