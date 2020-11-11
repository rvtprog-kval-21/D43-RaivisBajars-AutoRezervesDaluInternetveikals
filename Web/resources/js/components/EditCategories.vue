<template>
    <div>
        <h3 class="text-center">Edit Category</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateCategory">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" v-model="category.category_name">
                    </div>
                    <div class="form-group">
                        <label>Parent Category</label>
                        <input type="text" class="form-control" v-model="category.parent_category">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                category: {}
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/category/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.category = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            updateCategory() {
                this.axios
                    .post(`http://localhost:8000/api/category/update/${this.$route.params.id}`, this.category)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        }
    }
</script>