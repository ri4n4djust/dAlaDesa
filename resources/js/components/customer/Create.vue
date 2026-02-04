<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">TAMBAH PELANGGAN</div>

                    <div class="card-body">

                        <form @submit.prevent="PostStore">

                            <div class="form-group">
                                <input type="text" class="form-control" v-model="post.kdPelanggan" disabled required>
                            </div>

                            <div class="form-group">
                                <label>Nama Pelanggan</label>
                                <input type="text" class="form-control" v-model="post.nmPelanggan"
                                       placeholder="Masukkan Nama">
                                <div v-if="validation.nmPelanggan">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.nmPelanggan[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Alamat </label>
                                <input type="text" class="form-control" v-model="post.almtPelanggan"
                                       placeholder="Alamat Pelanggan">
                                <div v-if="validation.almtPelanggan">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.almtPelanggan[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" class="form-control" v-model="post.noHpPelanggan"
                                       placeholder="No Tlp">
                                <div v-if="validation.noHpPelanggan">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.noHpPelanggan[0] }}
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">SIMPAN</button>
                                <button type="reset" class="btn btn-md btn-danger">RESET</button>
                            </div>


                        </form>


                    </div>
                </div>
      
  
  
</template>


<script>
    export default {
        data() {
            return {
                post: {},
                validation: []
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created: function(){
            this.loadKdSupplier()
        },
        methods: {
            
            PostStore() {
                let uri = '/api/pelanggan/store';
                this.axios.post(uri, this.post)
                    .then((response) => {
                        alert('berhasil ditambahkan');
                        this.$router.push({
                            name: 'pelanggan'
                            
                        });
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },

            loadKdSupplier:function(){
                let uri = '/api/kodePelanggan/';
                this.axios.get(uri).then(response => {
                this.post.kdPelanggan = response.data.kdPelanggan;
                
            });
            },
            
        }
    }
</script>
