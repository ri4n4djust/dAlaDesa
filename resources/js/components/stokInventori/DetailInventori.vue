<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">Detail</div>
                    <div class="card-body">



          <!-- general form elements -->
                <div class="box box-primary">
                            
                            <div class="form-group">
                                <label>Nama Barang : {{post.nmBarang}}</label>
                            <br>
                                <label>Stok Inventori : {{post.stkInventori}}</label>
                            </div>
                    <button class="btn btn-primary btn-success" @click="cariStok()">CARI</button>  
                    <router-link :to="{ name: 'stokinventori' }" class="btn btn-primary btn-success">KEMBALI</router-link>  

                </div>
                <div class="input-group">
                    <div class="col-md-6">
                        <label class="control-label" ><i class="fa fa-check"></i>Start Date</label>
                        <date-picker v-model="startDate" value-type="format" format="YYYY/MM/DD" :required="true"></date-picker>
                    </div>
                </div>
                <div class="input-group">
                    <div class="col-md-6">
                        <label class="control-label" ><i class="fa fa-check"></i>End Date</label>
                        <date-picker v-model="endDate" value-type="format" format="YYYY/MM/DD" :required="true"></date-picker>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Barang : {{post.nmBarang}}</label>   | 
                    <label>Stok Inventori : {{post.stkInventori}}</label>
                </div>
                <div class="form-group">
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
                            <td>{{ pe.tglInv }}</td>
                            <td>{{ pe.qtyMasukInv}}</td>
                            <td>{{ pe.qtyKeluarInv}}</td>
                            <td>{{ pe.noTransaksiInv}}</td>
                            <td>{{ pe.keteranganKartuInv }}</td>

                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total</td>
                                <td>{{ totalQtyMasuk }}</td>
                                <td>{{ totalQtyKeluar }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>


            </div>
        </div>

</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import VueSingleSelect from "vue-single-select";

    export default {
        components: { DatePicker, VueSingleSelect,  },
        data() {
            return {
                post: {},
                pem: {},
                validation: [],
                selected : '',
                country: 0,
                countries: {},
                startDate: '',
                endDate: '',
                totalQtyMasuk: '',
                totalQtyKeluar: '',
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            let uri = `/api/detailbarang/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
            });
            this.loadDetailInventori();
        },
        methods: {
            loadDetailInventori:function(){
                let uri = `/api/detailinventori/${this.$route.params.id}`;
                this.axios.post(uri).then(response => {
                    this.pem = response.data.data;
                   // alert('no nota '+ this.data.noNota);
            });
            },
            cariStok:function(){
                let uri = `/api/detailinventoridate/${this.$route.params.id}`;
                this.axios.post(uri, {
                    startDate: this.startDate,
                    endDate: this.endDate,
                    idI: this.$route.params.id
                }).then(response => {
                    this.pem = response.data.data;
                    this.totalQtyMasuk = response.data.qtyMasukInv;
                    this.totalQtyKeluar = response.data.qtyKeluarInv;
                });
            },
           
        },
        props: {
        data: {
            type: Object,
            required: true,
           
        },
    },
       
    }
</script>
