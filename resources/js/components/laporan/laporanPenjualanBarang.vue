<template>

                    <div class="card-body">
                        <status-login></status-login>
                         <h3>Laporan Penjualan Barang</h3>
                        <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">All Report</a></li>
                            <li><a href="#timeline" data-toggle="tab">Periodik</a></li>
                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-content">
                            <div class="active tab-pane" id="activity">

                                <div>
                                <data-table v-bind="bindings" @actionTriggered="ActionButtons"/>
                                </div>
                                
                               
                                
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <!-- The timeline -->
                            <div>

                                <form  @submit.prevent="lapPenjualan" >
                                
                                    <div class="box-body">
                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <label class="control-label" ><i class="fa fa-check"></i>Start Date</label>
                                                <date-picker v-model="startDate" value-type="format" format="YYYY/MM/DD" :required="true"></date-picker>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <label class="control-label" ><i class="fa fa-check"></i>End Date</label>
                                                <date-picker v-model="endDate" value-type="format" format="YYYY/MM/DD" :required="true"></date-picker>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <div class="col-xl-12">
                                                <label class="control-label" ><i class="fa fa-check"></i>Nama Menu</label>
                                                <input type="hidden" class="form-control" v-model="kodeMenu"  >
                                                <input type="text" class="form-control" v-model="namaMenu"  @click="showModalMenu = true" placeholder="Nama Menu">
                                            </div>

                                            <div v-if="showModalMenu">
                                                <transition name="modal">
                                                <div class="modal-mask">
                                                    <div class="modal-wrapper">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" @click="showModalMenu=false">
                                                            <span aria-hidden="true">&times;</span>CLOSE
                                                            </button>
                                                            <h4 class="modal-title">Cari Menu</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                            <!------Tes Select menu ---->
                                                            <input type="text" ref="menu" v-model="menu" v-on:keyup="get_menu" class="form-control "  >
                                                                
                                                                <span v-if="menuss.lenght === 0">
                                                                </span>
                                                                <span v-else>
                                                                    <ul class="list-group">
                                                                    <li v-for="(menu, id) in menuss" @click="select_menu(menu)" :key="menu.id" class="list-group-item autocomplete-box-li">
                                                                        {{ id+1 }}
                                                                        {{ menu.nmMenu }}
                                                                    </li>
                                                                    </ul>
                                                                </span>
                                                            <!------End Tes ---->
                                                            


                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </transition>
                                            </div>

                                        </div>
                                        
                                        <br>
                                        <div class="col-xs-2">
                                        <button type="submit" class="btn btn-md btn-success">View Data</button> 
                                        </div>
                                    
                                    </div>
                                                                   
                                </form>
                                <span v-if="load">Loading...</span>  
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No Nota</th>
                                        <th>Tgl</th>
                                        <th>Kode Menu</th>
                                        <th>Nama Menu</th>
                                        <th>Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1 in posts1" :key="post1.id">
                                        <td>{{ post1.noNota }}</td>
                                        <td>{{ post1.tglNota }}</td>
                                        <td>{{ post1.kdBarang }}</td>
                                        <td>{{ post1.nmBarang }}</td>
                                        <td>{{ post1.qty }}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{totalS}}</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div id="printMe" hidden>
                                <div class="row invoice-info">
                                    Laporan penjualan Tgl {{startDate}} sd {{endDate}}
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>No Nota</th>
                                        <th>Customer</th>
                                        <th>Type Pembayaran</th>
                                        <th>Tgl</th>
                                        <th>Meja</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                    <tr v-for="post1 in posts1" :key="post1.id">
                                        <td>{{ post1.noNota }}</td>
                                        <td>{{ post1.pelangganNota }}</td>
                                        <td>
                                            <span v-if="post1.typeNota === '1'">
                                                Cash
                                            </span>
                                            <span v-else-if="post1.typeNota === '2'">
                                                Debit
                                            </span>
                                            <span v-else-if="post1.typeNota === '3'">
                                                E-Money
                                            </span>
                                        </td>
                                        <td>{{ post1.tglNota }}</td>
                                        <td>{{ post1.noMeja}}</td>
                                        <td>{{ post1.totalNota | currency}}</td>
                                    </tr>
                                    
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{totalS | currency}}</th>
                                        </tr>
                                
                                    </tbody>
                                    
                                </table>
                                </div>
                                </div>
                                <!-- OUTPUT -->
                                <button type="button" class="btn btn-primary" @click="print('printMu')">Print</button>

                            </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">

                                
                            </div>
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                        </div>

                       

                            


                    </div>

                

</template>

<style type="text/css">

    #printMe { display: none; }

    @media print

    {
        @page {
        margin:0;
        }
        #non-printable { display: none; }
        #printMe { 
            display: block;
            font-size: 6px;
            
        }
    }
    </style>

<script>
import Vue from 'vue';
import "@andresouzaabreu/vue-data-table/dist/DataTable.css";
import DataTable from "@andresouzaabreu/vue-data-table";

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import VueSingleSelect from "vue-single-select";

import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
}

Vue.use(VueHtmlToPaper, options);

import ActionButtons from './componentAksi.vue';
Vue.component("data-table", DataTable);
    export default {
        components: { DatePicker, VueSingleSelect,  },
        data() {
            return {
                posts: [],
                posts1: [],
                startDate: '',
                endDate: '',
                kodeMenu: '',
                namaMenu: '',
                ActionButtons: '',
                validation: null,
                pelanggans: [],
                totalS: [],
                pajakS: [],
                diskonS: [],
                pax: [],
                //totalSum: '',
                menus: {},
                menu:'',
                menuss: [],
                showModalMenu: false,
                load: false,
            }

        },
        computed: {
            bindings() {
                return {
                    actionMode: "multiple",
                    //name: "ActionButtons",
                    columns: [
                        {
                            key: "noNota",
                            title: "No Nota",
                            sortable: false,
                        },
                        // {
                        //     key: "noMeja",
                        //     title: "No Meja",
                        //     sortable: false,
                        // },
                        {
                            key: "tglNota",
                            title: "Tgl Nota",
                            sortable: false,
                        },
                        {
                            key: "kdBarang",
                            title: "Menu",
                            sortable: false,
                        },
                        {
                            key: "nmBarang",
                            title: "Menu",
                            sortable: false,
                        },
                        {
                            key: "qty",
                            title: "Qty",
                            sortable: false,
                            searchable: false,
                        },
                        // {
                        //     key: "diskonNota",
                        //     title: "Diskon",
                        //     sortable: false,
                        //     searchable: false,
                        // },
                        // {
                        //     key: "totalNota",
                        //     title: "Total",
                        //     sortable: false,
                        //     searchable: false,
                        // },
                        // {
                        //     key: "bayarNota",
                        //     title: "Bayar",
                        //     sortable: false,
                        //     searchable: false,
                        // },
                        // {
                        //     key: "kembalianNota",
                        //     title: "Kembalian",
                        //     sortable: false,
                        //     searchable: false,
                        // },
                        // {
                        //     title: "Action",
                        //     sortable: false,
                        //     searchable: false,                            
                        //     component: ActionButtons,
                        //     index:100,
                        // },
                        
                    ],
                    data: this.posts,
                    /* other props...*/
                    
                }
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            this.loadData();
            // this.loadPelanggan();
        },
        mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            this.loadData()
        },
        methods: {

            select_menu(menu){
                this.kodeMenu = menu.kdMenu
                this.namaMenu = menu.nmMenu
                this.menuss = [];
                this.showModalMenu = false;
            },
            get_menu(){
                if(this.menu.length == 0){
                    this.menuss = [];
                }
                if(this.menu.length > 0){
                    axios.get('/api/carimenu',{params: {menu: this.menu}}).then(response => {
                        this.menuss = response.data.data;
                    });
                }
            },

            print () {
            // Pass the element id here
            window.print(printMe)
            },
            
            loadData:function(){
                let uri = '/api/penjualanbarang';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                        
            });
            },
            lapPenjualan() {
                this.load = true;
                let uri = '/api/lapPenjualanBarang';
                this.axios.post(uri, 
                {
                    startDate: this.startDate,
                    endDate: this.endDate,
                    namaMenu: this.kodeMenu,
                })
                    .then((response) => {
                        this.posts1 = response.data.data;
                        this.totalS = response.data.totalSum;
                        this.load = false;
                    });
                
            },
            intervalFetchData: function () {
            setInterval(() => {    
                this.loadData();
                }, 3000);    
            }
            //print () {
            // Pass the element id here
            //this.$htmlToPaper('printMe');
            //}
           
        },
        
    }
</script>