<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Edit Data Pegawai</h5>
                        <router-link :to="{name: 'category-list'}" class="btn btn-primary">Kembali Ke Menu</router-link>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 offset-3">
                                <form @submit.prevent="updateCategory">
                                    <div class="form-group">
                                        <label for="">NIP</label>
                                        <input type="text" v-model="categoryForm.nip" class="form-control" name="nip" placeholder="category name" :class="{ 'is-invalid': categoryForm.errors.has('nip') }">
                                        <has-error :form="categoryForm" field="nip"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" v-model="categoryForm.nama" class="form-control" name="nama" placeholder="category name" :class="{ 'is-invalid': categoryForm.errors.has('nama') }">
                                        <has-error :form="categoryForm" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jabatan</label>
                                        <input type="text" v-model="categoryForm.jabatan" class="form-control" name="jabatan" placeholder="category name" :class="{ 'is-invalid': categoryForm.errors.has('jabatan') }">
                                        <has-error :form="categoryForm" field="jabatan"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Form } from 'vform'

export default {
    data(){
        return {
            categoryForm: new Form({
                nip: '',
                nama: '',
                jabatan: '',
            }),
        }
    },
    methods: {
        updateCategory(){
            let id = this.$route.params.id;

            this.categoryForm.put(`/api/category/${id}`).then(() => {
                this.$toast.success({
                    title:'Success!',
                    message:'updated successfully.'
                });
            })
        },

        loadCategory(){
            let id = this.$route.params.id;
            
            axios.get(`/api/category/${id}/edit`).then(response => {
                this.categoryForm.nip = response.data.nip;
                this.categoryForm.nama = response.data.nama;
                this.categoryForm.jabatan = response.data.jabatan;
            });
        }
    },
    mounted(){
        this.loadCategory();
    }
}
</script>

<style>

</style>