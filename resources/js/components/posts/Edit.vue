<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">EDIT POST</div>

                    <div class="card-body">

                        <form @submit.prevent="PostUpdate">

                            <div class="col-md-6">
          <!-- general form elements -->
                <div class="box box-primary">
                            
                             <div class="form-group">
                                <input type="text" class="form-control" v-model="post.kdBarang" disabled >
                             </div>
                            <div class="form-group">
                                <label>TITLE</label>
                                <input type="text" class="form-control" v-model="post.nmBarang"
                                       placeholder="Masukkan Title">
                                <div v-if="validation.nmBarang">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.nmBarang[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Harga Pokok</label>
                                <input type="text" class="form-control" v-model="post.hrgPokok"
                                       placeholder="Harga Pokok">
                                <div v-if="validation.hrgPokok">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.hrgPokok[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="text" class="form-control" v-model="post.hrgJual"
                                       placeholder="Harga Jual">
                                <div v-if="validation.hrgJual">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.hrgJual[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                            <label>Select Kategori:</label>
                            <select class='form-control' v-model='post.ktgBarang'>
                                <option value='0' >Select Kategori</option>
                                <option v-for='data in countries' :value='data.kodeKtg' :key='data.id'>{{ data.namaKtg }}</option>
                            </select>
                            </div>

                            <div class="form-group">
                            <label>Jenis Barang: </label>
                            <select class='form-control' v-model='post.stsBarang'>
                                <option value='1' >Barang Jadi</option>
                                <option value='2' >Barang Mentah</option>
                            </select>
                            </div>

                </div>
            </div>
    

      
        <!-- left column -->
            <div class="col-md-6">
          <!-- general form elements -->
                <div class="box box-info">


                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" class="form-control" v-model="post.satuanBarang">
                                <div v-if="validation.satuanBarang">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.satuanBarang[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>QTY Min</label>
                                <input type="text" class="form-control" v-model="post.qtyMin">
                                <div v-if="validation.qtyMin">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.qtyMin[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>QTY Max</label>
                                <input type="text" class="form-control" v-model="post.qtyMax">
                                <div v-if="validation.qtyMax">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.qtyMax[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Merek</label>
                                <input type="text" class="form-control" v-model="post.merek">
                                <div v-if="validation.merek">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.merek[0] }}
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>KONTEN</label>
                                <textarea class="form-control" v-model="post.deskripsi" rows="5"
                                          placeholder="Masukkan Konten"></textarea>
                                <div v-if="validation.deskripsi">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.deskripsi[0] }}
                                    </div>
                                </div>
                            </div>
                        
                                         
                    
                </div>
            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">UPDATE </button>
                                <button @click.prevent="PostDeleteTrx(id= post.id)" class="btn btn-md btn-danger">HAPUS</button>
                                <router-link :to="{ name: 'posts' }" class="btn btn-primary btn-success">KEMBALI</router-link>
                            
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
                validation: [],
                selected : '',
                country: 0,
                countries: {},
                
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            let uri = `/api/posts/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
                this.getCountries()
            });
        },
        methods: {
            PostUpdate() {
                let uri = `/api/posts/update/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({name: 'posts'});
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },
            getCountries: function(){
                axios.get('/api/kategori')
                    .then(function (response) {
                        this.countries = response.data.data;
                    }.bind(this));
            },
            PostDeleteTrx(id)
            {
            if(confirm("Do you really want to delete?"+ this.post.nmBarang)){
               this.axios.delete(`/api/posts/${id}`)
                    .then(response => {
                        this.$router.push({name: 'posts'});
                        alert('Sukses Hapus' + this.post.nmBarang);
                    }).catch(error => {
                    alert('system error!');
                });
            }
            },
           
        },
       
    }
</script>
