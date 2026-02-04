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
                                        
                                        detail 
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