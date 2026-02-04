<template>
    <div class="mt-3">
        <status-login></status-login>
      <div class="card-header">TAMBAH BARANG</div>
        <div class="card-body">
        
        <form  @submit.prevent="PostStore" id="anyName">
        <!-- left column -->
            <div class="col-md-6">
          <!-- general form elements -->
                <div class="box box-primary">
                            
                             <div class="form-group">
                                <input type="text" class="form-control" :value="post.kdBarang" :name="kdBarang" disabled >
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
                                       placeholder="Harga Pokok" @keypress="onlyNumber">
                                <div v-if="validation.hrgPokok">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.hrgPokok[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="text" class="form-control" v-model="post.hrgJual"
                                       placeholder="Harga Jual" @keypress="onlyNumber">
                                <div v-if="validation.hrgJual">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.hrgJual[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                            <label>Select Kategori:</label>
                            <select class='form-control' v-model='post.ktgBarang' required>
                                <option v-for='data in countries' :value='data.kodeKtg' :key='data.id'>{{ data.namaKtg }}</option>
                            </select>
                            </div>

                            <div class="form-group">
                            <label>Select Kategori:</label>
                            <select class='form-control' v-model='post.stsBarang' required>
                                <option  value='1' selected>Barang Jadi</option>
                                <option value='2' >Barang Mentah</option>
                            </select>
                            </div>

                            
                            <div class="form-group">
                                <button type="submit"  class="btn btn-md btn-success">SIMPAN</button>
                                <router-link :to="{ name: 'posts' }" class="btn btn-primary btn-success">KEMBALI</router-link>
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
                                <div v-if="validation.qtyMin" @keypress="onlyNumber">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.qtyMin[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>QTY Max</label>
                                <input type="text" class="form-control" v-model="post.qtyMax">
                                <div v-if="validation.qtyMax" @keypress="onlyNumber">
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
         </form>
    
   </div>

</div>
      
  
  
</template>


<script>
    export default {
        data() {
            return {
                post: {
                    stsBarang: '1',
                },
                kodes: {},
                validation: [],
                country: 0,
                countries: {},
                total: {},
                kdBarang: '',
                stsBarang: '1',
            }
            
        },
        created: function(){
            this.loadKdBarang()
            this.getCountries()
            //this.loadData()
            
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        

        methods: {
            PostStore() {
                let uri = '/api/posts/store';
                this.axios.post(uri, this.post)
                    .then((response) => {
                        const path = '/barang/create'
                        this.$router.push(path)
                        this.loadKdBarang()
                        //this.loadData()
                        document.getElementById("anyName").reset();
                        alert('sukses Tambah Barang')
                        
                    }).catch(error => {
                    //this.validation = error.response.data.data;
                    alert('ada yang error');
                    //this.post.kdBarang;
                });
            },
            PostDelete(id, index)
            {
                this.axios.delete(`/api/posts/${id}`)
                    .then(response => {
                        this.posts.splice(index, 1);
                    }).catch(error => {
                    alert('system error!');
                });
            },
            
            resetForm() {
                // this.$refs.formTambah.reset()
                //document.getElementById('nmBarang').value = ''
                document.getElementById("anyName").reset();
                alert('reset donkkkkkkkk');
                //this.$refs.formTambah.reset()
            },
            getCountries: function(){
                axios.get('/api/kategori')
                    .then(function (response) {
                        this.countries = response.data.data;
                    }.bind(this));
            },
            onlyNumber ($event) {
                //console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }   
            },
            loadKdBarang:function(){
                let uri = `/api/kodeBarang/`;
                this.axios.get(uri).then(response => {
                this.post.kdBarang = response.data.kdBarang;
                
            });
            },
            
        },
   
        
        }
    
</script>

