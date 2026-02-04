<template>
    <div >
        <button class="btn btn-outline-primary" @click="DetailAction('detailInventori')" >
            <i class="fa fa-edit"></i>
        </button>
                        
                        <div v-if="showModalDetail">
                            <transition name="modal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" @click="showModalDetail=false">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Detail</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                                                                       
                                                        <table class="table table-hover table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Nama Barang </th>
                                                            <th>Tgl</th>
                                                            <th>Qty Masuk</th>
                                                            <th>Qty Keluar</th>
                                                            <th>No. Transaksi</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="pe in pem" :key="pe.id">
                                                            <td>{{ pe.kdBarang }} </td>
                                                            <td>{{ pe.tglKartu }}</td>
                                                            <td>{{ pe.qtyMasuk}}</td>
                                                            <td>{{ pe.qtyKeluar}}</td>
                                                            <td>{{ pe.noTransaksi}}</td>
                                                            <td>{{ pe.keteranganKartu }}</td>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                       

                                        


                                        

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

export default {
    name: "ActionButtons",
    data() {
            return {
                posts: [],
                //pem: [],
                showModalDetail: false,
                //data: this.posts,
                qtyGudang: '',
                keterangan: '',
                tglOpname: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
            }

        },
    created() {
            this.loadData()
            //this.something()
            //this.loadDetailStok()
            //this.DetailAction()
        },
    methods: {

            loadData:function(){
                let uri = '/api/posts';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
            });
            },

            DetailAction() {
                const path = '/detailInventori/' + this.data.kdBarang;
                this.$router.push(path)
                //alert('edit' + this.data.id)
                //this.$store.commit(edit, this.data)
            },
            
            PostStokOpname:function(){
                let uri = '/api/posthasilopname/';
                this.axios.post(uri, {
                    kdBarang: this.data.kdBarang,
                    tglOpname: this.tglOpname
                }).then((response) => {
                    this.loadDetailStok()
                    alert('input Opname Berhasil')

                });
            }
            
            
        },
    props: {
        data: {
            type: Object,
            required: true,
        },
    },
};
</script>