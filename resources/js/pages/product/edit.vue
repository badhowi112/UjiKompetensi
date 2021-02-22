<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Edit Data </h5>
                        <router-link :to="{name: 'product-list'}" class="btn btn-primary">Kembali Ke Menu</router-link>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 offset-3">
                                <form @submit.prevent="saveProduct">
                                    <div class="form-group">
                                        <label for="">Code Pegawai</label>
                                        <input type="number" v-model="productForm.id_pegawai" class="form-control" name="id_pegawai" placeholder="Inputkan Code Pegawai " :class="{ 'is-invalid': productForm.errors.has('id_pegawai') }">
                                        <has-error :form="productForm" field="id_pegawai"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">NIK</label>
                                        <input type="number" v-model="productForm.nik" class="form-control" name="nik" placeholder="Inputkan NIK " :class="{ 'is-invalid': productForm.errors.has('nik') }">
                                        <has-error :form="productForm" field="nik"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" v-model="productForm.nama" class="form-control" name="nama" placeholder="Inputkan Nama" :class="{ 'is-invalid': productForm.errors.has('nama') }">
                                        <has-error :form="productForm" field="nama"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pekerjaan</label>
                                        <input type="text" v-model="productForm.pekerjaan" class="form-control" name="pekerjaan" placeholder="Inputkan Pekerjaan" :class="{ 'is-invalid': productForm.errors.has('pekerjaan') }">
                                        <has-error :form="productForm" field="pekerjaan"></has-error>
                                    </div>
                                     <div class="form-group">
                                        <label for="">Alamat</label>
                                        <input type="text" v-model="productForm.alamat" class="form-control" name="alamat" placeholder="Inputkan Alamat" :class="{ 'is-invalid': productForm.errors.has('alamat') }">
                                        <has-error :form="productForm" field="alamat"></has-error>
                                    </div>
                                     <div class="form-group">
                                        <label for="">No.Hp</label>
                                        <input type="number" v-model="productForm.nohp" class="form-control" name="nohp" placeholder="Inputkan No HP" :class="{ 'is-invalid': productForm.errors.has('nohp') }">
                                        <has-error :form="productForm" field="nohp"></has-error>
                                    </div>
                                     <div class="form-group">
                                        <label for="">Keperluan</label>
                                        <input type="text" v-model="productForm.keperluan" class="form-control" name="keperluan" placeholder="Inputkan Keperluan" :class="{ 'is-invalid': productForm.errors.has('keperluan') }">
                                        <has-error :form="productForm" field="keperluan"></has-error>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="">Foto</label>
                                                <input type="file" class="form-control-file"  @change="onImageChange" :class="{ 'is-invalid': productForm.errors.has('image') }">
                                                <has-error :form="productForm" field="image"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div style="width: 100%; max-height: 150px; overflow:hidden">
                                                <img :src="image" alt="" class="img-fluid">
                                            </div>
                                        </div>
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
import { objectToFormData } from 'object-to-formdata'

export default {
    data(){
        return {
            productForm: new Form({
                id_pegawai: '',
                nik: '',
                nama: '',
                pekerjaan: '',
                alamat: '',
                nohp: '',
                keperluan: '',              
                _method: 'put',
            }),
            image: '',
        }
    },
    methods: {
        loadProductData(){
            let id = this.$route.params.id;            
            axios.get(`/api/product/${id}/edit`).then(response => {
                let product = response.data;
                // console.log(product)
                this.productForm.id_pegawai = product.id_pegawai;
                this.productForm.nik = product.nik;
                this.productForm.nama = product.nama;
                this.productForm.pekerjaan = product.pekerjaan;
                this.productForm.alamat = product.alamat;
                this.productForm.nohp = product.nohp;
                this.productForm.keperluan = product.keperluan;
                this.image = product.image;
            });
        },
        saveProduct(){
            let id = this.$route.params.id;

            this.productForm.post('/api/product/'+id, {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }],
                onUploadProgress: e => {
                    // Do whatever you want with the progress event
                    console.log(e)
                }
            }).then(({ data }) => {
                this.image = data.image;

                this.$toast.success({
                    title:'Success!',
                    message:'saved successfully.'
                });
            })
        },
        onImageChange(e){
            const file = e.target.files[0]
            // Do some client side validation...
            this.productForm.image = file
        }
    },
    mounted(){
        this.loadProductData();
    }
}
</script>

<style>

</style>
