<template>
    <div >
        <button  @click="loadDetailPenjualan()">
            <i class="fa fa-eye"></i>
        </button>
        
            
        
       

                        <div v-if="showModalPenjualan">

                            <div id="printMe">
                                    <!-- info row -->
                                    <p class="text-muted text-center">
                                    <img :src="'/image/logoNota.png'" >
                                    </p>
                                <p class="text-bold text-center">
                                
                                        Phone / Wa: 081 239 099 998<br>
                                        Email: warungdaladesa@gmail.com<br>
                                        FB : warungdaladesa<br>
                                        IG : warung.daladesa.sangeh
                                    
                                    </p>
                                <div class="row invoice-info">
                                    <!-- accepted payments column -->
                                        
                                        <!-- /.col -->
                                        <div class="col-xs-12 table-responsive">
                                            <table width="100%" style="font-size:12px">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        
                                                            <strong>Customer :</strong> {{data.pelangganNota}}<br>
                                                            <b> Tgl : </b>{{data.tglNota}} <br>
                                                            <b> Meja No : </b>{{data.noMeja}}<br>
                                                            <b>Waiter : </b>{{data.waiterNota}}<br>
                                                    
                                                    </th>
                                                    <th>
                                                        
                                                            <b>Inv: </b>{{data.noNota}}<br>
                                                            <b>Kasir : </b>{{ data.name }}<br>
                                                            <b>Pax: </b>{{data.pax}}<br>
                                                            <b>Type : </b>
                                                            <span v-if="data.typePembayaran === '1'">
                                                                Cash
                                                            </span>
                                                            <span v-else-if="data.typePembayaran === '2'">
                                                                Debit
                                                            </span>
                                                            <span v-else-if="data.typePembayaran === '3'">
                                                                E-Money
                                                            </span>
                                                        
                                                    </th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped" width="100%" style="font-size:12px">
                                                <thead>
                                                <tr>
                                                    <th>Nama </th>
                                                    <th>Qty</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="trx in pem" :key="trx.noN">
                                                    <td>{{ trx.nmBarang }} </td>
                                                    <td>{{ trx.qty}}</td>
                                                    <td>{{ trx.hrgJual | currency }}</td>
                                                    <td>{{ trx.qty * trx.hrgJual | currency }}</td>
                                                </tr>
                                                </tbody>
                                                
                                                    <tr>
                                                        <th colspan="3">subTotal :</th>
                                                        <th>{{ totalJ | currency}}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Tax & Service : {{ data.pajakPembayaran }} %</th>
                                                        <th>{{ data.taxNota | currency}}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Discount {{ data.diskonPembayaran }} %</th>
                                                        <th>{{ data.diskonNota | currency}}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">subTotal :</th>
                                                        <th>{{ data.totalNota | currency }}</th>
                                                    </tr>
                                                    <tr v-if="data.typePembayaran === '1'">
                                                    </tr>
                                                    <tr v-else-if="data.typePembayaran === '2'">
                                                        <th colspan="3">Card Charge : {{ data.chargePembayaran }} %</th>
                                                        <th>{{ data.chargeNota | currency }}</th>
                                                    </tr>

                                                    <tr>
                                                        <th colspan="3">Payment :</th>
                                                        <th>{{ data.bayarNota | currency }}</th>
                                                    </tr>

                                                    <tr v-if="data.typePembayaran === '1'">
                                                        <th colspan="3">Kembalian :</th>
                                                        <th>{{ data.kembalianNota | currency }}</th>
                                                    </tr>
                                                    <tr v-else-if="data.typePembayaran === '2'">
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <p class="text-bold text-center">
                                                            Terima Kasih <br>
                                                            Belanja Anda Hal Baik Bagi Dunia<br>
                                                            Tidak enak Kasi Tau Kami, ENAK kasi tau temanmu<br>                              
                                                            </p>
                                                        </td>
                                                    </tr>
                                            </table>
                                            

                                    </div>
                                    
                                </div>
                                <!-- /.row -->
                                    
                            </div>  

            
                            <transition name="modal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">

                                        


                                        <button type="button" class="close" @click="showModalPenjualan=false">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Detail Penjualan</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="row invoice-info">
                                        <!-- accepted payments column -->
                                            <div class="col-xs-6">
                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                <strong>Customer :</strong> {{data.pelangganNota}}<br>
                                                <b> Tgl : </b>{{data.tglNota}}<br>
                                                <b> Meja No : </b>{{data.noMeja}}<br>
                                                <b>Waiter : </b>{{data.waiterNota}}<br>
                                                <b>Bayar : </b>{{data.bayarNota | currency}}<br>
                                                <b>Kembalian : </b>{{data.kembalianNota | currency}}<br>
                                            </p>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-xs-6">
                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                <b>No Inv: </b>{{data.noNota}}<br>
                                                <b>Kasir : </b>{{ data.name }}<br>
                                                <b>Type : </b>
                                                <span v-if="data.typePembayaran === '1'">
                                                    Cash
                                                </span>
                                                <span v-else-if="data.typePembayaran === '2'">
                                                    Debit
                                                </span>
                                                <span v-else-if="data.typePembayaran === '3'">
                                                    E-Money
                                                </span>
                                                <br>
                                                <b>Tax: </b>{{data.taxNota | currency}}<br>
                                                <b>Diskon : </b>{{ data.diskonNota | currency }}<br>
                                                <b>Card Charge : {{ data.chargePembayaran }} %</b>
                                            </p>
                                            </div>
                                            <!-- /.col -->
                                        
                                    </div>
                                        <h3 class="profile-username text-left">
                                            <label>Total : </label>
                                            {{ data.totalNota  || 0 | currency }}</h3>
                                        
                                        <p class="text-muted text-center">
                                        </p>
                                        
                                        <div v-if="adminuser === 'Admin'">
                                            <a href="#"  @click="pri('printMe')" class="btn btn-md btn-success"><b>Re-Print</b></a>
                                            <a href="#"   @click="showModalAuth=true" class="btn btn-md btn-success"><b>Void</b></a>
                                            <!-- <a href="#"   @click.prevent="DeletePenjualan(id = data.id)" class="btn btn-md btn-success"><b>Delete</b></a> -->
                                        </div>
                                        <span v-if="load">
                                            <looping-rhombuses-spinner
                                            :animation-duration="2500"
                                            :rhombus-size="15"
                                            color="#ff1d5e"
                                            />
                                        </span>
                                        <div v-else-if="adminuser === 'Operator'">
                                            <a href="#"  @click="pri('printMe')" class="btn btn-md btn-success"><b>Re-Print</b></a>
                                        </div>
                                        <div v-else-if="adminuser === 'Kasir'">
                                            <a href="#"  @click="pri('printMe')" class="btn btn-md btn-success"><b>Re-Print</b></a>
                                            <a href="#"   @click="showModalAuth=true" class="btn btn-md btn-success"><b>Void</b></a>
                                        </div>
                                        <br>
            
                    <!-- modal Auth start -->
                    <div v-if="showModalAuth">
                        <transition name="modal">
                        <div class="modal-mask">
                            <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" @click="showModalAuth=false">
                                    <span aria-hidden="true">&times;</span>CLOSE
                                    </button>
                                    <h4 class="modal-title">Auth Require</h4>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="postAuthCek" autocomplete='off'>
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" v-model="data.noNota" disabled>
                                        <input type="text" class="form-control" v-model="username" disabled>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="password" class="form-control" v-model="password" placeholder="Password" autocomplete='off'>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                    <div class="row">
                                        
                                        <!-- /.col -->
                                        <div class="col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Authorize</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </transition>
                    </div>
                    <!------End Modal Auth ---->
                                        
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                            <li class="active"><a href="#brg" data-toggle="tab">Data Barang</a></li>
                            <li><a href="#group" data-toggle="tab">Group</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="brg">

                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nama </th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="pe in pem" :key="pe.id">
                                            <td>{{ pe.nmBarang }} </td>
                                            <td>{{ pe.qty}}</td>
                                            <td>{{ pe.hrgJual | currency }}</td>
                                            <td>{{ pe.qty * pe.hrgJual | currency }}</td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="group">
                                        <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Detail </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="gr in gro" :key="gr.id">
                                            <td >
                                                <tr>
                                                    <td witdh="400">Group</td>
                                                    <td>{{ gr.groupNota}}</td>
                                                    <td>{{ gr.total | currency }}</td>
                                                </tr>
                                                <tr v-for="grB in groB" :key="grB.id">
                                                    <td colspan="3">
                                                        <div class="col-xs-12 table-responsive">
                                                        <table  class="table table-hover table-bordered">
                                                            <tbody >
                                                            <tr v-if="gr.groupNota == grB.groupNota" >
                                                                <td witdh="40%">{{ grB.nmBarang}}</td>
                                                                <td>{{ grB.hrgBarang}}</td>
                                                                <td>{{ grB.qtyBarang}}</td>
                                                                <td>{{ grB.subTotal}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </td>
                                                </tr>
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
                            </transition>
                        </div>
       
    </div>
</template>

<script>
import { LoopingRhombusesSpinner   } from 'epic-spinners'
export default {
    components: { LoopingRhombusesSpinner  },
    name: "ActionButtons",
    data() {
            return {
                username: 'Supervisor',
                password: '',
                showModalAuth: false,
                posts: [],
                pem: [],
                gro: [],
                groB: [],
                showModalPenjualan: false,
                np: this.data.noNota,
                sukses: '',
                adminuser: '',
                totalJ:'',
                load: false,
                gambar: 'image/logoNota.png',
            }

        },
    created() {
            this.loadData()
            //this.something()
            //this.loadDetailPenjualan()
            this.adminuser = this.$session.get('roleID')
        },
    mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            // this.loadData()
    },
       
    methods: {
        pri(printMe){
            var printContent = document.getElementById(printMe);
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write('<html><head><title>reprint</title><link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">');
            // WinPrint.document.write('<link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">');
            // WinPrint.document.write('<script type="text/javascript" src="assets/bower_components/jquery/dist/jquery.min.js"></scr' + 'ipt>');
            // WinPrint.document.write('<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></scr' + 'ipt>');
            // WinPrint.document.write('<script src="assets/dist/js/adminlte.min.js"></scr' + 'ipt>');
            // WinPrint.document.write('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">');
            // WinPrint.document.write('<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css"></head><body>');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.write('</body></html>');
            WinPrint.document.close();
            WinPrint.focus();
            setTimeout(() =>WinPrint.print(), 3000);
            setTimeout(() => WinPrint.close(), 15000);
        },
        
        postAuthCek(){
            let uri = '/api/authcek';
            this.axios.post(uri, {
                username: this.username,
                password: this.password
            }).then(response => {
                if (response.data.success === true ) {
                // alert('suskes Login')
                this.axios.delete('/api/voidPembayaran/'+ this.data.id)
                .then(response => {
                    alert('Berhasil Di Void');
                    // this.loadDataTransaksi();
                    this.loadData();
                    // this.ListOrder();
                    // this.ListOrder1();
                    this.showModalAuth = false;
                    this.showModalPenjualan = false;
                }).catch(error => {
                    // console.log(error)
                    alert('Meja Belum Kosong');
            });
                }
            });
        },
        
        DeletePenjualan(id)
        {
            if(confirm("Do you really want to delete?")){
            this.axios.delete(`/api/hapuspenjualan/${id}`)
                .then(response => {
                    //this.posts.splice(index, 1);
                    this.showModalPenjualan = false;
                    this.loadData();
                }).catch(error => {
                alert('system error!');
            });
            }
        },
        something() {
            return new Promise((resolve) => {
            resolve('np:'+ this.data.noNota);
            });
        },
        loadData:function(){
            let uri = '/api/penjualan';
            this.axios.get(uri).then(response => {
            this.posts = response.data.data;
            
            
        });
        },
        loadDetailPenjualan:function(){
            this.load = true;
            this.showModalPenjualan = true;
            this.loadGroup();
            let uri = '/api/detailpenjualan/'+ this.data.noNota;
            this.axios.get(uri).then(response => {
                this.pem = response.data.data;
                this.totalJ = response.data.total;
                this.load = false;
                
                // alert('no nota '+ this.data.noNota);
        });
        },
        loadGroup:function(){
            let uri = '/api/grouppayment/'+ this.data.noNota;
            this.axios.get(uri).then(response => {
                this.gro = response.data.data;
                this.groB = response.data.databarang;
            });
        },
        // intervalFetchData: function () {
        // setInterval(() => {    
        //     this.loadData();
        //     }, 3000);    
        // },
                      
    },
    props: {
        data: {
            type: Object,
            required: true,
        },
    },
};
</script>