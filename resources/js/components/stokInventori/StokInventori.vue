<template>

    <div class="card-body">
        <status-login></status-login>
        <button class="btn btn-md btn-success" @click="ModalInputInventori = true" >
            Input Inventori
        </button>
        <router-link :to="{ name: 'stokopnamecreate' }" class="btn btn-md btn-success">Stok Opname Baru</router-link>
                        <h3>Stok Inventori</h3>
                        <p>
                        <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">All Inventori</a></li>
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

                        <div v-if="ModalInputInventori">
                            <transition name="modal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" @click="ModalInputInventori=false">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Input Inventori</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                                                                       
                                       
                        <form @submit.prevent="PostInput" id="anyName">

                            <div class="form-group">
                                <label>Nama Barang</label>
                                <vue-single-select
                                            v-model="post1"
                                            :options="posts"
                                            :required="true"
                                            optionLabel="nmBarang" 
                                ></vue-single-select>
                                <input type="hidden" class="form-control" v-model="post1.kdBarang" >
                                <input type="hidden" class="form-control" v-model="tglInv" >
                            </div>
                            <div class="form-group">
                                <label>Stok Inventori</label>
                                <input type="text" class="form-control" v-model="post1.qty"
                                       placeholder="Stok" required >
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">Input</button>
                            </div>

                        </form>
                                        


                                        

                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </transition>
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

<script>
import Vue from 'vue';

import DataTable from "@andresouzaabreu/vue-data-table";
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

import ActionButtons from './componentAksiStokInventori.vue';
Vue.component("data-table", DataTable);
    export default {
        components: { VueSingleSelect},
        data() {
            return {
                posts: [],
                post:{},
                post1:{},
                ActionButtons: null,
                actionTriggered: {},
                ModalInputInventori: false,
                tglInv: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
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
                            key: "stkInventori",
                            title: "Stok",
                            sortable: true,
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
            PostInput() {
                let uri = `/api/inputInventori`;
                this.axios.post(uri, {
                    kdBarang: this.post1.kdBarang,
                    qty: this.post1.qty,
                    tglInv: this.tglInv,
                })
                    .then((response) => {
                        alert('inventori Berhasil di input');
                        this.loadData();
                        document.getElementById("anyName").reset();
                        //this.$router.push({name: 'kategori'});
                        this.ModalInputInventori = false;
                    }).catch(error => {
                    //this.validation = error.response.data.data;
                    alert('ada yang error');
                });
            },
            loadData:function(){
                let uri = '/api/inventori';
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
            //clearInterval(this.posts)
        },
        
    }
</script>