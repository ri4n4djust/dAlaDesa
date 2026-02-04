<template>

    <div class="card-body">
        <status-login></status-login>
                        <h3>Laporan Stok Opname</h3>

                        <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">All Opname</a></li>
                            <li><a href="#timeline" data-toggle="tab">Stok Opname</a></li>
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
                                Stok Opname
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

import ActionButtons from './componentAksiStok.vue';
Vue.component("data-table", DataTable);
    export default {
        data() {
            return {
                posts: [],
                ActionButtons: '',
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
                            key: "noStokOpname",
                            title: "No Opname",
                            sortable: true,
                        },
                        
                        {
                            key: "tglStok",
                            title: "Tanggal",
                            sortable: true,
                            searchable: false,
                        },
                        {
                            key: "totalOpname",
                            title: "Nilai Opname",
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
                let uri = '/api/stokopname';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
            });
            },
            
            intervalFetchData: function () {
            setInterval(() => {    
                this.loadData();
                }, 3000);    
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