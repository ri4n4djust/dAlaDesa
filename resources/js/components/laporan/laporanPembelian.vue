<template>

                    <div class="card-body">
                        <status-login></status-login>
                         <h3>Laporan Pembelian</h3>
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
                                <form  @submit.prevent="lapPembelian" >
                                    
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
                                        <th>No Nota</th>
                                        <th>Supplier</th>
                                        <th>Tgl</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1 in posts1" :key="post1.id">
                                        <td>{{ post1.noNotaPembelian }}</td>
                                        <td>{{ post1.nmSupplier }}</td>
                                        <td>{{ post1.tglNotaPembelian }}</td>
                                        <td>{{ post1.totalNotaPembelian | currency}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{totalP | currency}}</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div id="printMe" hidden>
                                <table width="90%" border="1" style="border:1px solid black; border-collapse: collapse;">
                                    <thead>
                                    <tr>
                                        <th>No Nota</th>
                                        <th>Customer</th>
                                        <th>Tgl</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1 in posts1" :key="post1.id">
                                        <td>{{ post1.noNotaPembelian }}</td>
                                        <td>{{ post1.nmSupplier }}</td>
                                        <td>{{ post1.tglNotaPembelian }}</td>
                                        <td>{{ post1.totalNotaPembelian | currency}}</td>
                                    </tr>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{totalP | currency}}</th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                    
                                </table>
                                </div>
                                <!-- OUTPUT -->
                                <button @click="print" class="btn btn-md btn-success">Print</button>


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

import ActionButtons from './componentAksiPembelian.vue';
Vue.component("data-table", DataTable);
    export default {
        components: { DatePicker, VueSingleSelect,  },
        data() {
            return {
                posts: [],
                posts1: [],
                totalP: [],
                startDate: '',
                endDate: '',
                ActionButtons: '',
                validation: null,
                index: ''
                //actionTriggered: null,
                
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
                            key: "noNotaPembelian",
                            title: "No Nota",
                            sortable: false,
                        },
                        {
                            key: "nmSupplier",
                            title: "Supplier",
                            sortable: false,
                        },
                        {
                            key: "tglNotaPembelian",
                            title: "Tgl Nota",
                            sortable: false,
                        },
                        
                        {
                            key: "totalNotaPembelian",
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
            this.intervalFetchData();
            //this.bindings()
            //this.loadData()
        },
        methods: {
            loadData(){
                let uri = '/api/pembelian';
                this.axios.get(uri).then(response => {
                    this.posts = response.data.data;
                });
            },

            intervalFetchData: function () {
            setInterval(() => {    
                this.loadData();
                }, 3000);    
            },
            
            PostDelete(id, index)
            {
                this.axios.delete(`/api/pembelian/${id}`)
                    .then(response => {
                        this.posts.splice(index, 1);
                    }).catch(error => {
                    alert('system error!');
                });
            },
            lapPembelian() {
                let uri = '/api/lapPembelian';
                this.axios.post(uri, 
                {
                    startDate: this.startDate,
                    endDate: this.endDate,
                })
                    .then((response) => {
                        this.posts1 = response.data.data;
                        this.totalP = response.data.notaSum;
                        //alert('Data Ditampilkan');
                        //this.loadDataSorting()
                        //this.loadTotal()
                    });
                
            },
            print () {
            // Pass the element id here
            this.$htmlToPaper('printMe');
            }
           
        },
        
    }
</script>