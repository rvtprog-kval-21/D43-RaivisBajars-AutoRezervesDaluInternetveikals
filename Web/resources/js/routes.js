import AddCategories from './components/AddCategories.vue';
import Categories from './components/AllCategories.vue';
import EditCategories from './components/EditCategories.vue';
 
export const routes = [
    {
        name: 'add',
        path: '/add',
        component: AddCategories
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditCategories
    },
    {
        name: 'category',
        path: '/category/:url?',
        component: Categories
    }
];