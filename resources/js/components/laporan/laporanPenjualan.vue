<template>

                    <div class="card-body">
                        <status-login></status-login>
                         <h3>Laporan Penjualan</h3>
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
                                        <div class="col-md-6">
                                        <label class="control-label" ><i class="fa fa-check"></i>Jenis Pembayaran</label>
                                            <select class='form-control' v-model='typeNotaCari' required>
                                            <option  value='0' selected>Semua</option>
                                            <option value='1' >Cash</option>
                                            <option value='2' >Debit</option>
                                        </select>
                                            
                                        </div>
                                        </div>
                                        <div class="input-group">
                                        <div class="col-md-6">
                                        <label class="control-label" ><i class="fa fa-check"></i>Pelanggan</label>
                                            <select v-model="typePelangganCari" class="form-control">
                                                <option v-for="pel in pelanggans" :value="pel.nmPelanggan" :key="pel.id">
                                                    {{pel.nmPelanggan}}
                                                </option>
                                            </select>
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
                                        <th>Customer</th>
                                        <th>Type Pembayaran</th>
                                        <th>Tgl</th>
                                        <th>Pax</th>
                                        <th>PPn</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
                                        <td>{{ post1.pax }}</td>
                                        <td>{{ post1.taxNota | currency }}</td>
                                        <td>{{ post1.diskonNota | currency }}</td>
                                        <td>{{ post1.totalNota | currency}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{pax}}</th>
                                            <th>{{pajakS | currency}}</th>
                                            <th>{{diskonS | currency}}</th>
                                            <th>{{totalS | currency}}</th>
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
                typeNotaCari: '0',
                typePelangganCari: 'Cash',
                ActionButtons: '',
                validation: null,
                pelanggans: [],
                totalS: [],
                pajakS: [],
                diskonS: [],
                pax: [],
                //totalSum: '',
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
                        {
                            key: "noMeja",
                            title: "No Meja",
                            sortable: false,
                        },
                        {
                            key: "pelangganNota",
                            title: "Pelanggan",
                            sortable: false,
                        },
                        {
                            key: "tglNota",
                            title: "Tgl Nota",
                            sortable: false,
                        },
                        {
                            key: "taxNota",
                            title: "PPn",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "diskonNota",
                            title: "Diskon",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "totalNota",
                            title: "Total",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "bayarNota",
                            title: "Bayar",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "kembalianNota",
                            title: "Kembalian",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            title: "Action",
                            sortable: false,
                            searchable: false,
                            /* this will make this column appear to the right of the table
                            since its index is greater than others*/
                            
                            component: ActionButtons,
                            index:100,
                        },
                        
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
            this.loadPelanggan();
        },
        mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            this.loadData()
        },
        methods: {

            print () {
            // Pass the element id here
            window.print(printMe)
            },
            
            loadData:function(){
                let uri = '/api/penjualan';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                        
            });
            },
            loadPelanggan:function(){
                let uri = '/api/pelanggan';
                this.axios.get(uri).then(response => {
                this.pelanggans = response.data.data;
                
            });
            },
            lapPenjualan() {
                this.load = true;
                let uri = '/api/lapPenjualan';
                this.axios.post(uri, 
                {
                    startDate: this.startDate,
                    endDate: this.endDate,
                    typeNotaCari: this.typeNotaCari,
                    typePelangganCari: this.typePelangganCari,
                })
                    .then((response) => {
                        this.posts1 = response.data.data;
                        this.totalS = response.data.notaSum;
                        this.pajakS = response.data.pajakSum;
                        this.diskonS = response.data.diskonSum;
                        this.pax = response.data.paxSum;
                        //alert('Data Ditampilkan');
                        //this.loadDataSorting()
                        //this.loadTotal()
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