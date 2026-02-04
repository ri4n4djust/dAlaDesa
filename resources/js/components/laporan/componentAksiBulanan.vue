<template>
    <div >
        <button  @click="loadDetailPenjualan()">
            <i class="fa fa-eye"></i>
        </button>

        
       

                        <div v-if="showModalPenjualan">
                            <transition name="modal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" @click="showModalPenjualan=false">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Detail Penjualan</h4>
                                    </div>
                                    <div class="modal-body">

                                        {{data.tglNota}}
                                        <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No Nota</th>
                                        <th>Customer</th>
                                        <th>Tgl</th>
                                        <th>PPn</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="post1 in posts1" :key="post1.id">
                                        <td>{{ post1.noNota }}</td>
                                        <td>{{ post1.pelangganNota }}</td>
                                        <td>{{ post1.tglNota }}</td>
                                        <td>{{ post1.taxNota | currency }}</td>
                                        <td>{{ post1.diskonNota | currency }}</td>
                                        <td>{{ post1.totalNota | currency}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{pajakS | currency}}</th>
                                            <th>{{diskonS | currency}}</th>
                                            <th>{{totalS | currency}}</th>
                                        </tr>
                                    </tfoot>
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

<style type="text/css">

    #printMe { display: none; }

    @media print
    {
  body * {
    visibility: hidden;
  }
  #printMe, #printMe * {
    visibility: visible;
  }
  #printMe {
    position: absolute;
    left: 0;
    top: 0;
    font-size: 8pt;
    width: 100%;
  }
}
    </style>

<script>

export default {

    name: "ActionButtons",
    data() {
            return {
                posts: [],
                posts1: {},
                pem: [],
                showModalPenjualan: false,
                np: this.data.noNota,
                sukses: '',
                adminuser: '',
                pajakS: '',
                diskonS: '',
                totalS: '',
                
            }

        },
    created() {
            this.loadData()
            //this.something()
            //this.loadDetailPenjualan()
            this.adminuser = this.$session.get('roleID')
        },
    mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            this.loadData()
    },
       
    methods: {
        rePrint: function(){
            window.print(printMe);
        },
            DeletePenjualan(id)
            {
                if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/hapuspenjualan/${id}`)
                    .then(response => {
                        //this.posts.splice(index, 1);
                        this.showModalPenjualan = false;
                        this.loadData();
                    }).catch(error => {
                    alert('system error!');
                });
                }
            },
            something() {
                return new Promise((resolve) => {
                resolve('np:'+ this.data.noNota);
                });
            },
            loadData:function(){
                let uri = '/api/penjualan';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
                
            });
            },
            loadDetailPenjualan:function(){
                this.showModalPenjualan = true;
                let uri = '/api/lapPenjualan';
                this.axios.post(uri, 
                {
                    startDate: this.data.tglNota,
                    endDate: this.data.tglNota,
                })
                    .then((response) => {
                        this.posts1 = response.data.data;
                        this.totalS = response.data.notaSum;
                        this.pajakS = response.data.pajakSum;
                        this.diskonS = response.data.diskonSum;
                        //alert('Data Ditampilkan');
                        //this.loadDataSorting()
                        //this.loadTotal()
                    });
            },
            intervalFetchData: function () {
            setInterval(() => {    
                this.loadData();
                }, 3000);    
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