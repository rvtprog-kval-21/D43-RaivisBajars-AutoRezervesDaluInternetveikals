import Api from './Api'

export default {
  addCategory (categoryForm) {
    return Api().post('/category/add', categoryForm)
  }
}
