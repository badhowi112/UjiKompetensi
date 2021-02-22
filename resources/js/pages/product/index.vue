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
                            Halaman Tamu
                            <hr>
                           <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List Tamu</h5>
                        <router-link :to="{name: 'create-product'}" class="btn btn-primary">Tambah Data</router-link>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 100px"> Id </th>
                                    
                                    <th> nama pegawai id </th>
                                    <th> nik </th>
                                    <th> nama </th>
                                    <th> pekerjaan </th>
                                    <th> alamat </th>
                                    <th> nohp </th>
                                    <th> keperluan </th>
                                    <th> image </th>
                                    <th style="width: 170px"> Action </th>
                                </tr>
                            </thead>
                            <tbody v-if="products.length">
                                <tr v-for="product in products" :key="product.id">
                                    <td style="width: 100px"> {{ product.id }} </td>
                                   
                                    <td> {{ product.pegawai.nama }} </td>
                                    <td> {{ product.nik }} </td>
                                    <td> {{ product.nama }} </td>
                                    <td> {{ product.pekerjaan }} </td>
                                    <td> {{ product.alamat }} </td>
                                    <td> {{ product.nohp }} </td>
                                    <td> {{ product.keperluan }} </td>
                                    <td> 
                                        <div style="max-width: 150px; max-height: 150px; overflow:hidden">
                                            <img :src="product.image" alt="" class="img-fluid">
                                        </div>    
                                    </td>
                                    <td style="width: 170px">
                                        <router-link :to="{name: 'edit-product', params: {id: product.id}}" class="btn btn-primary btn-sm">Edit</router-link>
                                        <a @click.prevent="deleteProduct(product)" href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="text-center mt-4 mb-4">Tidak ada Data</h5>
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            products: [],
            //state loggedIn with localStorage
            loggedIn: localStorage.getItem('loggedIn'),
            //state token
            token: localStorage.getItem('token'),
            //state user logged In
            user: []
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
        
        loadProducts(){
            axios.get('/api/product').then(response => {
                this.products = response.data;
            });
        },
        
        async deleteProduct(product){
            await axios.delete(`/api/product/${product.id}`).then(() => {
                this.$toast.success({
                    title:'Success!',
                    message:'deleted successfully.'
                });
            });

            let index = this.products.indexOf(product);
            this.products.splice(index, 1);
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
        this.loadProducts();
        
    }
}
</script>
