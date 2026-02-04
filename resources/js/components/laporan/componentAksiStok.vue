<template>
    <div >
        <button class="btn btn-outline-success" @click="showModalDetail = true">
            <i class="fa fa-eye"></i>
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
                                                <th>Nama </th>
                                                <th>Qty Gudang</th>
                                                <th>Selisih</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="pe in pem" :key="pe.id">
                                                <td>{{ pe.kdBarang }} </td>
                                                <td>{{ pe.qtyGudang}}</td>
                                                <td>{{ pe.selisihStok }}</td>
                                                <td>{{ pe.satuanStok }}</td>
                                                <td>{{ pe.keteranganStok }}</td>
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
                //np: this.posts,
            }

        },
    created() {
            this.loadData()
            //this.something()
            this.loadDetailStok()
        },
    methods: {

            loadData:function(){
                let uri = '/api/stokopname';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
            });
            },
            
            loadDetailStok:function(){
                let uri = '/api/detailstokopname/'+ this.data.noStokOpname;
                this.axios.post(uri).then(response => {
                    this.pem = response.data.data;
                   // alert('no nota '+ this.data.noNota);
            });
            },
            
            EditAction() {
                const path = '/barang/edit/' + this.data.id
                this.$router.push(path)
                //alert('edit' + this.data.id)
                //this.$store.commit(edit, this.data)
            },
            ViewAction() {
                alert('View' + this.data.id)
                //this.$store.commit(edit, this.data)
            },
            
        },
    props: {
        data: {
            type: Object,
            required: true,
        },
    },
};
</script>