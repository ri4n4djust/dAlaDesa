<template>

                    <div class="card-body">
                        <status-login></status-login>
                        <h3>Live Order</h3>
                        <!-- TO DO List -->
                        <div class="box box-primary">
                            <div class="box-header">
                            <i class="ion ion-clipboard"></i>

                            <h3 class="box-title">To Do List</h3>

                           
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                            <ul class="todo-list">

                                <li v-for="post1 in posts" :key="post1.id">
                                <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                <input type="checkbox" value="">
                                <span class="text">{{post1.nmBarangTmp}}</span>
                                <span class="text">{{post1.qtyTmp}}</span>
                                <small class="label label-danger"><i class="fa fa-clock-o"></i>Meja No. {{post1.noMeja}}</small>
                                <div class="tools">
                                    <i class="fa fa-edit"></i>
                                    <i class="fa fa-trash-o"></i>
                                </div>
                                </li>
                                
                            </ul>

                            </div>

                        </div>
                        <!-- /.box -->
                            
                   


                    </div>

</template>


<script>

    export default {
        data() {
            return {
                posts: [],

                //showModal: false,
            }

        },
        computed: {
            
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
                let uri = '/api/orderlist';
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
            this.intervalFetchData();
            //this.bindings()
            this.loadData()
        },

        beforeDestroy () {
            clearInterval(this.posts)
        },
        
    }
</script>