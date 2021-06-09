import Api from './Api'

export default {
  addProduct (productForm) {
    return Api().post('/products/add', productForm)
  }
}
