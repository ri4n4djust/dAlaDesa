<template>
    <div class="mt-3">
<status-login></status-login>
        <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Stok Opname barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <p class="text-muted text-center">
                <date-picker v-model="tglStok" value-type="format" format="YYYY/MM/DD"></date-picker>
                </p>
                <p class="text-muted text-center">
                <input type="text" class="form-control" v-model="noStokOpname" placeholder="No nota">
                </p>      
                <p class="text-muted text-center">
                  {{ nilaiStok }}
                </p>          
                <p class="text-muted text-center">
                <a href="#" @click.prevent="PostOpname()" class="btn btn-primary btn-block"><b>Simpan</b></a>
                </p>
              
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          

                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Cari Barang</h3>
                    </div>
                    <div class="box-body">

                      <vue-single-select
                            v-model="post1"
                            :options="users"
                            :required="true"
                            optionLabel="nmBarang" 
                    ></vue-single-select>

                 
                  <form  @submit.prevent="PostItemOpname" >
                    <div class="row">
                       
                        
                          <input type="hidden" class="form-control" v-model="noStokOpname" >
                          <input type="hidden" class="form-control" v-model="tglStok" >
                          <input type="hidden" v-model="post1.stkBarang " class="form-control" placeholder="stok" disabled>
                          <input type="hidden" v-model="post1.stkSatuan" class="form-control" placeholder="stk Satuan" pattern="\d+">
                          <input type="hidden" :value="qtyInventori * post1.stkSatuan" :name="qtyGudang" class="form-control" placeholder="Qty" disabled>
    
                        <div class="col-xs-2">
                          <label>Satuan</label>
                          <div class="input-group">
                          <input type="text" v-model="post1.stkInventori " class="form-control" placeholder="stok" disabled>
                          <span class="input-group-addon">Pcs</span>
                          </div>
                        </div>
                          
                         
                        <div class="col-xs-2">
                          <label>Real Pcs</label>
                        <input type="text" v-model="qtyInventori" class="form-control" placeholder="Qty" pattern="\d+">
                        </div>
                        <div class="col-xs-2">
                          <input type="hidden" :value="(qtyInventori * post1.stkSatuan) - post1.stkBarang  " :name="selisihStok" class="form-control" placeholder="Selisih" disabled>
                          <label>Selisih </label>
                        <input type="text" :value=" qtyInventori - post1.stkInventori  " :name="selisihInventori" class="form-control" placeholder="Selisih" disabled>
                        </div>
                        <div class="col-xs-2">
                          <label>Keterangan</label>
                        <input type="text" v-model="keterangan" class="form-control" placeholder="Ket" required>
                        </div>
                        <div class="col-xs-2">
                          <label>Aksi</label>
                          <button type="submit" class="btn btn-xs btn-success form-control">Add</button>                        
                        </div>
                    </div>
                    {{  post1.hrgPokok * (post1.stkBarang - (qtyInventori * post1.stkSatuan))  }}
                    </form>
                    </div>
                    
                    <!-- /.box-body -->
                   </div>
                   
                <!-- /.box -->
                

                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Nama </th>
                                    <th>Qty Gudang</th>
                                    <th>Selisih</th>
                                    <th>Keterangan</th>
                                    <th>AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="pe in pemInv" :key="pe.id">
                                    <td>{{ pe.nmBarang }} </td>
                                    <td>{{ pe.stkInventori}}</td>
                                    <td>{{ pe.qtyMasukInv }}{{ pe.qtyKeluarInv }}</td>
                                    <td>{{ pe.keteranganKartuInv }}</td>
                                    <td class="text-center">
                                        <button @click.prevent="PostDeleteTrxInv(pe.id)" class="btn btn-sm btn-danger">HAPUS</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
              
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>

 
    
    </div>

      
  
  
</template>


<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';
  import VueSingleSelect from "vue-single-select";
  
    export default {
        components: { DatePicker, VueSingleSelect },         
        data() {
            return {
                post: {},
                posts: {},
                post1: {},
                users: {},
                pem: {},
                pemInv: {},
                qtyGudang: '',
                qtyInventori: '',
                selisihStok: '',
                selisihInventori: '',
                nilaiStok: '',
                //selisih1: Math.abs(this.selisih),
                keterangan: '',
                ntp:'',
                noStokOpname: '',
                tglStok: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
                validation: [],
            }
        },

       watch: {
          post: function() {
            this.$emit('input', this.post);
          }
        },
        //props: ['value'],
        props: ['value'],

        methods: {
            loadTotal:function(){
                let uri = '/api/totalTrxOpname';
                this.axios.post(uri, {
                    ntp: this.noStokOpname,
                }).then(response => {
                  //alert('mount' + this.noNotaPembelian)
                this.nilaiStok = response.data.nilaiStok;
                
            });
            },
            loadNoStokOpname:function(){
                let uri = `/api/kodeStokOpname/`;
                this.axios.get(uri).then(response => {
                this.noStokOpname = response.data.noStokOpname;
                
            });
            },
            loadBarang:function(){
                let uri = '/api/posts';
                this.axios.get(uri).then(response => {
                this.users = response.data.data;
                
            });
            },
            loadTransaksiOpname:function(){
                let uri = '/api/dataStokOpname/'+ this.noStokOpname;
                this.axios.post(uri).then(response => {
                    this.pem = response.data.data;
                   // alert('no nota '+ this.data.noNota);
            });
            },
            loadTransaksiInventori:function(){
                let uri = '/api/dataStokInventori/'+ this.noStokOpname;
                this.axios.post(uri).then(response => {
                    this.pemInv = response.data.data;
                   // alert('no nota '+ this.data.noNota);
            });
            },
            PostDeleteTrx(id)
            {
              if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/opnameDelete/${id}`)
                    .then(response => {
                        alert('Berhasil Di Hapus');
                        //this.loadTotal()
                        this.loadTransaksiOpname()
                        this.loadTransaksiInventori()
                    }).catch(error => {
                    
                });
              }
            },

            PostDeleteTrxInv(id)
            {
              if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/opnameInvDelete/${id}`)
                    .then(response => {
                        alert('Berhasil Di Hapus');
                        //this.loadTotal()
                        this.loadTransaksiOpname()
                        this.loadTransaksiInventori()
                    }).catch(error => {
                    
                });
              }
            },
            PostItemOpname() {
                let uri = '/api/addItemOpname/store';
                this.axios.post(uri, 
                {
                    noStokOpname: this.noStokOpname,
                    kdBarang: this.post1.kdBarang,
                    qtyGudang: this.qtyInventori * this.post1.stkSatuan,
                    selisihStok: (this.qtyInventori * this.post1.stkSatuan) - this.post1.stkBarang,
                    selisihStokInv: this.qtyInventori - this.post1.stkInventori,
                    keteranganStok: this.keterangan,
                    tglStok: this.tglStok,
                    satuanStok: this.post1.satuanBarang,
                    nilaiStok: (this.qtyGudang - this.post1.stkBarang) * this.post1.hrgPokok,
                })
                    .then((response) => {
                        //this.loadTotal()
                        this.loadTransaksiOpname()
                        this.loadTransaksiInventori()
                        alert('sukses');
                        //this.loadTransaksiPenjualan()
                        this.loadTotal()
                    }).catch(error => {
                        alert('ada yg error')
                        this.loadTransaksiOpname()
                        this.loadTransaksiInventori()
                });
                
            },
            PostOpname() {
                let uri = '/api/addOpname/store';
                this.axios.post(uri, 
                {
                    noStokOpname: this.noStokOpname,
                    tglStok: this.tglStok,
                    nilaiStok: (this.qtyGudang - this.post1.stkBarang) * this.post1.hrgPokok,
                    
                })
                    .then((response) => {
                        alert('Transaksi Selesai');
                        this.$router.go(0);
                        //this.$router.push({name: 'pembelian'});
                    });
                
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            this.loadNoStokOpname()
            this.loadBarang()
            //this.LoadSupplier()
            this.loadTransaksiOpname()
            this.loadTotal()
            
            
        },
    }
</script>
