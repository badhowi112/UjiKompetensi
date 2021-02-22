<template>
    <div class="dashboard" style="margin-top:80px">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                   <div class="card">
                        <div class="card-body">
                            MAIN MENU
                            <hr>
                            <ul class="list-group">
                                <router-link :to="{name: 'category-list'}" class="list-group-item text-dark text-decoration-none">PEGAWAI</router-link>
                                <router-link :to="{name: 'product-list'}" class="list-group-item text-dark text-decoration-none">TAMU</router-link>
                                <li @click="logout" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">LOGOUT</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        
                        <div class="card-body">
                            Halaman Pegawai
                            <hr>
                             <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List Pegawai</h5>
                        <router-link :to="{name: 'create-category'}" class="btn btn-primary">Tambah Data</router-link>
                    </div>
                            <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 100px"> Code Pegawai </th>
                                    <th> NIP </th>
                                    <th> Nama </th>
                                    <th> Jabatan </th>
                                    <th style="width: 170px"> Action </th>
                                </tr>
                            </thead>
                            <tbody v-if="categories.length">
                                <tr v-for="category in categories" :key="category.id">
                                    <td style="width: 100px"> {{ category.id }} </td>
                                    <td> {{ category.nip }} </td>
                                    <td> {{ category.nama }} </td>
                                    <td> {{ category.jabatan }} </td>
                                    <td style="width: 170px">
                                        <router-link :to="{name: 'edit-category', params: {id: category.id}}" class="btn btn-primary btn-sm">Edit</router-link>
                                        <a @click.prevent="deleteCategory(category)" href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="text-center mt-4 mb-4">Tidak Ada Data.</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import axios from 'axios'
export default {
    data(){
        return {
             //state loggedIn with localStorage
            loggedIn: localStorage.getItem('loggedIn'),
            //state token
            token: localStorage.getItem('token'),
            //state user logged In
            user: [],
            categories: [],
        }
    },
    created() {
        axios.get('http://localhost:8000/api/user', {headers: {'Authorization': 'Bearer '+this.token}})
        .then(response => {
            console.log(response)
            this.user = response.data // assign response to state user
        })
    },
    methods: {
        loadCategories(){
            axios.get('/api/category').then(response => {
                this.categories = response.data;
            });
        },

        deleteCategory(category){
            axios.delete(`/api/category/${category.id}`).then(() => {
                this.$toast.success({
                    title:'Success!',
                    message:'deleted successfully.'
                });
            });

            let index = this.categories.indexOf(category);
            this.categories.splice(index, 1);
        },
        logout() {
            axios.get('http://localhost:8000/api/logout')
            .then(() => {
                //remove localStorage
                localStorage.removeItem("loggedIn")    


                //redirect
                return this.$router.push({ name: 'home' })
            })
        }
    
    },
    mounted() {
        this.loadCategories();
        
    }
}
</script>
