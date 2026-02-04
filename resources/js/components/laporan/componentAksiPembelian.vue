<template>
    <div >
        <button  @click="loadDetailPembelian()">
            <i class="fa fa-eye"></i>
        </button>
       

                        <div v-if="showModalPembelian">
                            <transition name="modal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" @click="showModalPembelian=false">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Detail Pembelian</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <p class="text-muted text-left">
                                            <label>Tgl : </label>
                                        {{data.tglNotaPembelian}}
                                        </p>
                                        <p class="text-muted text-left">
                                            <label>No Nota : </label>
                                        {{data.noNotaPembelian}}
                                        </p>
                                        <p class="text-muted text-left">
                                            <label>Supplier : </label>
                                        {{data.nmSupplier}}
                                        </p>
                                        
                                        <h3 class="profile-username text-left">
                                            <label>Total : </label>
                                            {{ data.totalNotaPembelian  || 0 | currency }}</h3>
                                        
                                        <p class="text-muted text-center">
                                        </p>
                                        <a href="#"   @click.prevent="DeletePembelian(data.id, index)" class="btn btn-md btn-success"><b>Delete</b></a>

                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Nama </th>
                                                            <th>Qty</th>
                                                            <th>Harga</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="pe in pem" :key="pe.id">
                                                            <td>{{ pe.nmBarang }} </td>
                                                            <td>{{ pe.qtyBeli}}</td>
                                                            <td>{{ pe.hrgPokok | currency }}</td>
                                                            <td>{{ pe.qtyBeli * pe.hrgPokok | currency }}</td>

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
                pem: [],
                showModalPembelian: false,
                np: this.data.noNota,
                sukses: '',
                index: '',
                
            }

        },
    created() {
            this.loadData()
            //this.loadDetailPembelian()
        },
   
       
    methods: {
        DeletePembelian(id, index)
            {
                if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/hapuspembelian/${id}`)
                    .then(response => {
                        this.posts.splice(index, 1);
                        this.showModalPembelian = false;
                       
                    }).catch(error => {
                    alert('system error!');
                });
                }
            },
            
            loadData:function(){
                let uri = '/api/pembelian';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
                
            });
            },
            loadDetailPembelian:function(){
                this.showModalPembelian = true;
                let uri = '/api/detailpembelian/'+ this.data.noNotaPembelian;
                this.axios.get(uri).then(response => {
                    this.pem = response.data.data;
                   // alert('no nota '+ this.data.noNota);
            });
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