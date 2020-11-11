<template>
    <div class="responsive-container">
        <div class="grid">
            <div class="grid-column" v-for="categories in sortedCategories" :key="categories.id">
                <router-link class="product" :to="{ name: 'category', params: { url: categories.url }}">
                <div class="product-image">
                    <img v-bind:src="categories.image">
                </div>
                <div class="product-content">
                <div class="product-info">
                <h2 class="product-title">{{categories.category_name}}</h2>
                </div>
                </div>
                </router-link>
            </div>
        </div>
    </div>  
</template>
 
<script>
export default {
  data() {
    return {
      category: [],
      sortedCategories:[],
      currentCategory: null,
    };
  },
  created() {
    this.axios.get("http://localhost:8000/api/category").then((response) => {
      this.category = response.data;
      this.sortCategories();
    });
  },
  watch: {
        '$route' (to, from){
           this.sortCategories();
        }
  },
  methods: {
    deleteCategory(id) {
      this.axios
        .delete(`http://localhost:8000/api/category/delete/${id}`)
        .then((response) => {
          let i = this.category.map((item) => item.id).indexOf(id); // find index of your object
          this.category.splice(i, 1);
        });
    },
    getCategoryIdByUrl(url){
        return this.category.find(element => element.url == url).id;
    },
    sortCategories(){
        this.sortedCategories = [];
        if(this.$route.params.url != undefined){
          this.currentCategory = this.getCategoryIdByUrl(this.$route.params.url);
          this.category.forEach(element => {
              if(element.parent_category == this.currentCategory){
                  this.sortedCategories.push(element);
              }
          });
      }
      else{
          this.category.forEach(element => {
              if(element.parent_category == null){
                  this.sortedCategories.push(element);
              }
          });
      }
    }
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
@import url('https://fonts.googleapis.com/icon?family=Material+Icons');



*,
*:before,
*:after {
	box-sizing: border-box;
}

body,
h1,
h2,
h3,
h4,
p,
ul,
ol,
li,
figure,
figcaption,
blockquote,
dl,
dd {
	margin: 0;
}

body {
	scroll-behavior: smooth;
	line-height: 1.5;
	background-color: #FFF;
}

img {
	max-width: 100%;
	display: block;
}

a {
	color: inherit;
	font-weight: bold;
}

input,
button,
textarea,
select {
	font: inherit;
}

button {
	border: 1px solid;
	background-color: transparent;
}

body {
	font-family: "DM Sans", sans-serif;
}

.container{
	width: 100%;
	margin: 0 0 0 0;
}

.responsive-container {
	margin-left: 5%;
	margin-right: 5%;
}

.header {
	border-bottom: 1px solid #d0d0d0;
	min-height: 60px;
	padding-top: 0.5rem;
	padding-bottom: 0.5rem;
	display: flex;
	justify-content: center;
}

.header-content {
	display: flex;
	width: 100%;
	max-width: 2000px;
	padding-left: 1.25rem; 
	padding-right: 1.25rem;
	align-items: center;
	justify-content: space-between;
}

.header-navigation {
	display: flex;
	align-items: center;
}

.header-navigation a{
    margin-left: 1.5rem;
	text-decoration: none;
	font-size: 1rem;    
}

.link-button {
	display: flex;
	align-items: center;
	background-color: #000;
	border-radius: 0.375rem;
	padding: 0.5em 1.25em;
	color: #fff;
}

.link-button i{
    font-size: 1.25rem;
	margin-left: 0.5rem;
}

.logo {
	font-size: 1.25rem;
	font-weight: 700;
}

main {
	padding-top: 2rem;
	padding-bottom: 6rem;
}

.grid {
	display: grid;
	grid-template-columns: repeat(5, 1fr);
	gap: 2rem;
	margin: 20px 20px 20px 20px;
}

.grid-column {
	display: flex;
	flex-direction: column;
	min-width: 155px;
	max-width: 402px;
}

.product {
    border-left: 1px solid #dedede;
	border-right: 1px solid #dedede;
    border-top: 1px solid #dedede;
	border-bottom: 1px solid #dedede;
	border-radius: 0.25rem 0.25rem 0.25rem 0.25rem;
	text-decoration: none;
	font-weight: 400;	
	transition: .15s ease;
	overflow: hidden;
}

.product:hover, .product:focus{
    outline: none;
	box-shadow: 0 0 0 0.25rem grey;
}

.product-image {
	overflow: hidden;
}

.product-content {
	padding: 1rem;
	display: flex;
	align-items: center;
	justify-content: space-between;
	transition: .15s ease;
	background-color: #FFF;
}

.product-action {
	color: #000;
	width: 2.5rem;
	height: 2.5rem;
	border-radius: .25rem;
	font-size: 1.25rem;
	border: none;
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	transition: .15s ease;
}

.product-action:hover{
    background-color: #ebebeb;
}

.product-info {
	display: flex;
	flex-direction: column;
}

.product-title {
	font-size: 1.125rem;
	line-height: 1.25;
}

.product-price {
	margin-top: .25rem;
}

@media all and (max-width: 980px) {
	.grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 1.5rem;
	}
}

@media all and (max-width: 600px) {
	.grid {
		display: grid;
		grid-template-columns: repeat(1, 1fr);
		gap: 1.5rem;
	}
}

</style>