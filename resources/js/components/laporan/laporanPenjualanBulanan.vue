<template>

                    <div class="card-body">
                        <status-login></status-login>
                         <h3>Laporan Penjualan Bulanan</h3>
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
                                <form  @submit.prevent="lapPenjualan" >
                                    
                                        <p class="text-muted text-left">
                                        <label>Start Date</label>
                                    <date-picker v-model="startDate" value-type="format" format="YYYY/MM/DD" :required="true"></date-picker>
                                        </p>
                                        <p class="text-muted text-left">
                                        <label>End Date</label>
                                    <date-picker v-model="endDate" value-type="format" format="YYYY/MM/DD" :required="true"></date-picker>
                                        </p>
                                        <p class="text-muted text-left">
                                    <button type="submit" class="btn btn-md btn-success">View Data</button> 
                                        </p>                       
                                    
                                </form>
                                  
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl</th>
                                        <th>Pax</th>
                                        <th>PPn</th>
                                        <th>Diskon</th>
                                        <th>Charge</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1, key in posts1" :key="post1.id">
                                        <td>{{ key +1 }}</td>
                                        <td>{{ post1.tglNota }}</td>
                                        <td>{{ post1.pax }}</td>
                                        <td>{{ post1.ppn | currency}}</td>
                                        <td>{{ post1.diskon | currency }}</td>
                                        <td>{{ post1.charge | currency }}</td>
                                        <td>{{ post1.total | currency}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>{{pax }}</th>
                                            <th>{{pajakS | currency}}</th>
                                            <th>{{diskonS | currency}}</th>
                                            <th>{{chargeS | currency}}</th>
                                            <th>{{totalS | currency}}</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div id="printMe" hidden>
                                <div class="row invoice-info">
                                    Laporan penjualan Tgl {{startDate}} sd {{endDate}}
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl</th>
                                        <th>PPn</th>
                                        <th>Diskon</th>
                                        <th>Charge</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1, key in posts1" :key="post1.id">
                                        <td>{{ key +1 }}</td>
                                        <td>{{ post1.tglNota }}</td>
                                        <td>{{ post1.pax }}</td>
                                        <td>{{ post1.ppn | currency}}</td>
                                        <td>{{ post1.diskon | currency }}</td>
                                        <td>{{ post1.charge | currency }}</td>
                                        <td>{{ post1.total | currency}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>{{pajakS | currency}}</th>
                                            <th>{{diskonS | currency}}</th>
                                            <th>{{chargeS | currency}}</th>
                                            <th>{{totalS | currency}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                </div>
                                </div>
                                <!-- OUTPUT -->
                                <button type="button" class="btn btn-primary" @click="print('printMu')">Print</button>

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

import ActionButtons from './componentAksiBulanan.vue';
Vue.component("data-table", DataTable);
    export default {
        components: { DatePicker, VueSingleSelect,  },
        data() {
            return {
                posts: [],
                posts1: [],
                startDate: '',
                endDate: '',
                ActionButtons: '',
                validation: null,
                //actionTriggered: null,
                totalS: [],
                pajakS: [],
                diskonS: [],
                chargeS: [],
                pax: [],
                //totalSum: '',
            }

        },
        computed: {
            bindings() {
                return {
                    actionMode: "multiple",
                    //name: "ActionButtons",
                    columns: [
                        {
                            key: "tglNota",
                            title: "Tgl",
                            sortable: false,
                        },
                        {
                            key: "ppn",
                            title: "PPn",
                            sortable: false,
                        },
                        {
                            key: "diskon",
                            title: "Diskon",
                            sortable: false,
                        },
                        {
                            key: "charge",
                            title: "Charge",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "total",
                            title: "Total",
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
                let uri = '/api/penjualanbulanan';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                        
            });
            },
            
            lapPenjualan() {
                let uri = '/api/lapPenjualanBulanan';
                this.axios.post(uri, 
                {
                    startDate: this.startDate,
                    endDate: this.endDate,
                })
                    .then((response) => {
                        this.posts1 = response.data.data;
                        this.totalS = response.data.notaSum;
                        this.pajakS = response.data.pajakSum;
                        this.diskonS = response.data.diskonSum;
                        this.chargeS = response.data.chargeSum;
                        this.pax = response.data.paxSum;
                        //alert('Data Ditampilkan');
                        //this.loadDataSorting()
                        //this.loadTotal()
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