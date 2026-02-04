<template>
    <div class="card-body">
                        <status-login></status-login>
    <section class="content-header">
      <h1>Dashboard</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-check-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Today </span>
              <span class="info-box-number">{{tglToday}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-th-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Meja Terisi</span>
              <span class="info-box-number">{{akupansimeja}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Penjualan Hari Ini</span>
              <span class="info-box-number">{{notaToday}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">User</span>
              <span class="info-box-number">{{jumlahuser}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                
                <div class="col-md-9">
                  <p class="text-center">
                    <strong>Stok Menipis</strong>
                  </p>
              
                  <div class="progress-group" v-for="st in stokT" :key="st.id">
                    <span class="progress-text">{{st.nmBarang}}</span>
                    <span class="progress-number"><b>Stok </b>{{st.stkInventori}}</span>
                    <div class="progress sm">
                      <div v-if="st.stkInventori < 5" class="progress-bar progress-bar-red" style="width: 95%"></div>
                      <div v-if="st.stkInventori >= 5 && st.stkInventori <10" class="progress-bar progress-bar-yellow" style="width: 95%"></div>
                      <div v-if="st.stkInventori >= 10 && st.stkInventori <20" class="progress-bar progress-bar-green" style="width: 95%"></div>
                    </div>
                    <span v-if="$session.get('roleID') === 'Admin'">
                      <button class="btn btn-md btn-success" @click="showModal(kdBarang = st.kdBarang, nmBarang = st.nmBarang)" >
                          Input Inventori
                      </button>
                    </span>
                  </div>

                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL REVENUE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">TOTAL COST</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                    <h5 class="description-header">$24,813.53</h5>
                    <span class="description-text">TOTAL PROFIT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">GOAL COMPLETIONS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      
      <!-- /.row -->
    </section>

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
                        <label>Nama Inventori</label>                        
                        <input type="text" class="form-control" v-model="nmBarang" disabled >
                        <input type="hidden" class="form-control" v-model="kdBarang" >
                        <input type="hidden" class="form-control" v-model="tglInv" >
                    </div>
                    <div class="form-group">
                        <label>Qty Inventori</label>
                        <input type="text" class="form-control" v-model="qty"
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


<script>
//import foto1 from '../image/logo.png';
  export default {
        data() {
            return {
                tglToday: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
                tglInv: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
                image_src: '/image/logo.png',
                akupansimeja: '',
                notaToday: '',
                jumlahuser: '',
                stokT: [],
                ModalInputInventori: false,
                kdBarang:'',
                nmBarang: '',
                qty: '',

            }
        },
        created(){
          this.loadAwal();
          this.stokMenipis();
        },
        methods: {
           loadAwal(){
              let uri = '/api/awaldashboard';
                this.axios.get(uri).then((response) => {
                        this.akupansimeja = response.data.akupansimeja;
                        this.notaToday = response.data.notaToday;
                        this.jumlahuser = response.data.jumlahuser;
                    }).catch(error => {
                      alert('ada yang error');
                });
            },
            stokMenipis(){
              let uri = '/api/stokkurang';
                this.axios.get(uri).then((response) => {
                        this.stokT = response.data.data;
                    }).catch(error => {
                      alert('ada yang error');
                });
            },
            showModal() {
              this.ModalInputInventori = true;


            },
            PostInput() {
                let uri = `/api/inputInventori`;
                this.axios.post(uri, {
                    kdBarang: this.kdBarang,
                    qty: this.qty,
                    tglInv: this.tglInv,
                })
                    .then((response) => {
                        // alert('inventori Berhasil di input');
                        this.stokMenipis();
                        // document.getElementById("anyName").reset();
                        // this.$router.push({name: 'kategori'});
                        this.ModalInputInventori = false;
                    }).catch(error => {
                    //this.validation = error.response.data.data;
                    alert('ada yang error');
                });
            },
        },
        
    }
</script>
