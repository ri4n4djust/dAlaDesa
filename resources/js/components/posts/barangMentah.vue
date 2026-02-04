<template>

                    <div class="card-body">
                        <status-login></status-login>
                        <h3>Barang Mentah</h3>
                        <h3>
                        <router-link :to="{ name: 'create' }" class="btn btn-md btn-success">TAMBAH BARANG</router-link>
                        </h3>
                            
                            <div>
                                
                                <data-table v-bind="bindings" @actionTriggered="ActionButtons"/>
                                
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

import ActionButtons from './componentAksi.vue';
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
                            key: 'hrgPokok',
                            title: "Harga Pokok",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "hrgJual",
                            title: "Harga Jual",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "stkBarang",
                            title: "Stok",
                            sortable: false,
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
        created() {
            this.loadData()
            //this.pollData()
            //setInterval(this.loadData(),60000)
            
        },
        methods: {
            
            loadData:function(){
                let uri = '/api/mentah';
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