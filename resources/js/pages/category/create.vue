<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Tambah Data</h5>
                        <router-link :to="{name: 'category-list'}" class="btn btn-primary">Kembali Ke Menu</router-link>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 offset-3">
                                <form @submit.prevent="createCategory">
                                    <div class="form-group">
                                        <label for="">NIP</label>
                                        <input type="number" v-model="categoryForm.nip" class="form-control" name="nip" placeholder="Inputkan NIP" :class="{ 'is-invalid': categoryForm.errors.has('nip') }">
                                        <has-error :form="categoryForm" field="nip"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" v-model="categoryForm.nama" class="form-control" name="nama" placeholder="Inputkan Nama" :class="{ 'is-invalid': categoryForm.errors.has('nama') }">
                                        <has-error :form="categoryForm" field="nama"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">jabatan</label>
                                        <input type="text" v-model="categoryForm.jabatan" class="form-control" name="jabatan" placeholder="Inputkan Jabatan" :class="{ 'is-invalid': categoryForm.errors.has('jabatan') }">
                                        <has-error :form="categoryForm" field="jabatan"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Tambah Data</button>
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
        createCategory(){
            this.categoryForm.post('/api/category').then(({ data }) => {
                // console.log(categoryForm)
                this.categoryForm.nip = '';
                this.categoryForm.nama = '';
                this.categoryForm.jabatan = '';

                this.$toast.success({
                    title:'Success!',
                    message:'Category created successfully.'
                })

            })
        }
    }
}
</script>

<style>

</style>