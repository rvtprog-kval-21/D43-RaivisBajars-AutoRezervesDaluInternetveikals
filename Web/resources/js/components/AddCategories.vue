<template>
    <div>
        <h3 class="text-center">Add Category</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCategory" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" v-model="category.category_name">
                    </div>
                    <div class="form-group">
                        <label>Parent Category</label>
                        <input type="text" class="form-control" v-model="category.parent_category">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                category: {},
            }
        },
        methods: {
            addCategory() {
                let formData = new FormData();
                formData.append('image', this.image)
                this.axios
                    .post('http://localhost:8000/api/category/add', this.category, formData)
                    .then(response => (
                        this.$router.push({name: 'add'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>