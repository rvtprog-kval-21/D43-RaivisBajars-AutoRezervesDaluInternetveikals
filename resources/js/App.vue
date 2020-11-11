<template>
    <div class="custom-container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Home</router-link>
                    <router-link to="/category" class="nav-item nav-link">Kategorijas</router-link>
                    <router-link to="/add" class="nav-item nav-link">Pievienot Kategoriju</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                category: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/category')
                .then(response => {
                    this.category = response.data;
                });
        }
    }
</script>

<style>

</style>