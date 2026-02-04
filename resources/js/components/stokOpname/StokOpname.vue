<template>

    <div class="card-body">
        <status-login></status-login>
                        <h3>Stok Opname
                        <router-link :to="{ name: 'stokopnamecreate' }" class="btn btn-md btn-success">Stok Opname Baru</router-link>
                        </h3>
                        <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">All Stok</a></li>
                            <li><a href="#timeline" data-toggle="tab">Print Daftar Barang</a></li>
                            </ul>
                            <div class="tab-content">
                            <div class="active tab-pane" id="activity">

                                <div>
                                <data-table v-bind="bindings" @actionTriggered="ActionButtons"/>
                                </div>
                                
                               
                                
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <button @click="print" class="btn btn-md btn-success">Print</button>
                                <!-- The timeline -->
                            <div id="printMe">
                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Qty Gdg</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1 in posts" :key="post1.id">
                                        <td>{{ post1.kdBarang }}</td>
                                        <td>{{ post1.nmBarang }}</td>
                                        <td>{{ post1.namaKtg }}</td>
                                        <td>{{ post1.satuanBarang }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                    
                                </table>
                                </div>
                            </div>
                            </div>
                        </div>
                            <!-- /.tab-pane -->

                            
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                        </div>                            
                            
                    


    </div>

</template>
<style >
.data-table {
	display: grid;
	width: 100%;
	height: 100%;
	
}
</style>

</style>

<script>
import Vue from 'vue';

import DataTable from "@andresouzaabreu/vue-data-table";
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

import ActionButtons from './componentAksiStokOpname.vue';
Vue.component("data-table", DataTable);
    export default {
        data() {
            return {
                posts: [],
                ActionButtons: null,
                actionTriggered: {},
                //showModal: false,
            }

        },
        computed: {
            bindings() {
                return {
                    actionMode: "multiple",
                    name: "ActionButtons",
                    columns: [
                        {
                            key: "kdBarang",
                        },
                        {
                            key: "nmBarang",
                            title: "Nama Barang",
                            sortable: false,
                        },
                        
                        {
                            key: "stkBarang",
                            title: "Stok",
                            sortable: true,
                            searchable: false,
                        },
                        {
                            key: "satuanBarang",
                            title: "Satuan",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "namaKtg",
                            title: "Kategori",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "qtyMin",
                            title: "Qty Min",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "qtyMax",
                            title: "Qty Max",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "deskripsi",
                            title: "Keterangan",
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
            this.loadData()
            //this.pollData()
            //setInterval(this.loadData(),60000)
            
        },
        methods: {
            
            loadData:function(){
                let uri = '/api/posts';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
            });
            },
            
            intervalFetchData: function () {
            setInterval(() => {    
                this.loadData();
                }, 3000);    
            },
            print () {
            // Pass the element id here
            this.$htmlToPaper('printMe');
            }
        },
        mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            this.loadData()
        },

        beforeDestroy () {
            clearInterval(this.posts)
        },
        
    }
</script>