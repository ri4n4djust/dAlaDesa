<template>
    <div class="card-body">
      <status-login></status-login>
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center">Meja No. {{post.noMeja}}</h3>

              <p class="text-muted text-center">Max Pax {{post.paxMeja}}</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Billing</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <p class="text-muted text-center">
                <date-picker v-model="tglNota" value-type="format" format="YYYY/MM/DD HH:mm:ss"></date-picker>
                </p>
                <p class="text-muted text-center">
                  <div class="input-group">
                    <span class="input-group-addon">Pelanggan</span>
                    <select v-model="pelanggan" class="form-control">
                        <option v-for="pel in pelanggans" :value="pel.nmPelanggan" :key="pel.id">
                            {{pel.nmPelanggan}}
                        </option>
                    </select>
                    <input type="hidden" class="form-control" v-model="pelanggan" placeholder="Customer">
                  </div>
                
                <p class="text-muted text-center">
                  <div class="input-group">
                    <span class="input-group-addon">No Invoice</span>
                    <input type="text" class="form-control" v-model="noNota" placeholder="No nota" disabled>
                  </div>
               
                <p class="text-muted text-center">
                  <div class="input-group">
                    <span class="input-group-addon">Nm Waiter</span>
                  <input type="text" class="form-control" v-model="post.name" disabled>
                  </div>


                <input type="hidden" class="form-control" :value="subtotal" :name="totalTransaksi" >
                <h3 class="profile-username text-center">Total {{ Math.floor(subtotal)  || 0 | currency }}</h3>
                
                <p class="text-muted text-center">
                <a href="#" @click="showModalBayar = true" class="btn btn-primary btn-block"><b>Payment</b></a>
                </p>
                <p class="text-muted text-center">
                <a href="#" @click="opensplit(trxs)" class="btn btn-primary btn-block"><b>Split Payment</b></a>
                </p>

                
             
              

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>




        <!-- /.col -->
        <div class="col-md-9">
          <div class="box-body">
                <a href="#"  @click="showModalMenu = true" class="btn btn-success"><b>Add Menu</b></a>
                <a href="#"  @click="showModalMove = true" class="btn btn-success"><b>Pindah Meja</b></a>
                <!-- <span v-if="adminuser === 'Admin'"> -->
                  <span v-if=" orders.length == 0 && orders1.length == 0"><a href="#"  class="btn btn-success disabled" role="button" aria-disabled="true">Print Order</a></span>
                  <span v-else>
                    <!-- <a href="#"  @click="printOrder(id= post.id)" class="btn btn-success" >Print Order</a> -->
                    <a href="#"  @click="openOrder(id= post.id)" class="btn btn-success" >Open Print Order</a>
                    
                    </span>
                <!-- </span> -->
                <router-link :to="{ name: 'meja' }" class="btn btn-success">KEMBALI</router-link>
                <!-- /.post -->
          </div>
          <div class="box box-primary">

            

              


              <table class="table table-hover table-bordered">
                  <thead>
                  <tr>
                      <th>Nama </th>
                      <th>Qty</th>
                      <th>Harga</th>
                      <th>Total</th>
                      <th>AKSI</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="trx in trxs" :key="trx.id">
                      <td>{{ trx.nmBarangTmp }} </td>
                      <td>{{ trx.qtyTmp}}</td>
                      <td>{{ trx.hrgJualTmp | currency }}</td>
                      <td>{{ trx.totalTmp | currency }}</td>
                      <td class="text-center">
                        {{trx.stsPrintOrder}}
                          <button @click.prevent="PostEditTrx(id = trx.id, kode=trx.kdBarangTmp, meja = trx.noMejaTmp, nama= trx.nmBarangTmp, aksi='ubah')" class="btn-sm btn-warning"><i class="fa fa-pencil"></i></button>
                          <button @click.prevent="PostDeleteTrx(id = trx.id, kode=trx.kdBarangTmp, meja = trx.noMejaTmp,nama= trx.nmBarangTmp, aksi='hapus')" class="btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                      </td>

                  </tr>
                  </tbody>
              </table>

              


          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>

<!-- modal Order start -->
  <div v-if="showModalOrder">

              <div id="lastOrder">
              <div>
              <h5>ke 1 | Nama Waiter : {{post.name}}</h5> 
                <span v-if=" orders.length != 0 ">
                  <h3 class="profile-username text-center">Meja No: {{ post.noMeja }} | Makanan | Nama Waiter : {{post.name}}</h3>
                 
                  <table style="font-size:18px;font-family: Courier New;width:100%">
                    <thead>
                      <tr>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Jam</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td>{{ order.nmMenu }}<br>
                            {{order.noteOrder }}</td>
                        <td>{{ order.qtyOrder }}</td>
                        <td>{{ new Date(order.wktOrder).toLocaleTimeString() }}</td>
                      </tr>
                    </tbody>
                  </table>
                </span>
                <br>
        
                <span v-if=" orders1.length != 0 ">
                <h3 class="profile-username text-center">Meja No: {{ post.noMeja }} | Minuman</h3>
                  <table style="font-size:18px;font-family: Courier New;width:100%">
                    <thead>
                    <tr>
                      <th>Menu</th>
                      <th>Qty</th>
                      <th>Jam</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders1" :key="order.id">
                        <td>{{ order.nmMenu }}<br>
                            {{order.noteOrder }}</td>
                        <td>{{ order.qtyOrder }}</td>
                        <td>{{ new Date(order.wktOrder).toLocaleTimeString() }}</td>
                      </tr>
                    </tbody>
                  </table>                
                </span>
                </div>
                <p>
                <p>
                <h3 class="profile-username text-center">===============================</h3>
                <p>
                <p>
                <div>
                <h5>ke 2 | Nama Waiter : {{post.name}}</h5>
                <span v-if=" orders.length != 0 ">
                  <h3 class="profile-username text-center">Meja No: {{ post.noMeja }} | Makanan</h3>
                 
                  <table style="font-size:18px;font-family: Courier New;width:100%">
                    <thead>
                      <tr>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Jam</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td>{{ order.nmMenu }}<br>
                            {{order.noteOrder }}</td>
                        <td>{{ order.qtyOrder }}</td>
                        <td>{{ new Date(order.wktOrder).toLocaleTimeString() }}</td>
                      </tr>
                    </tbody>
                  </table>
                </span>
                <br>
        
                <span v-if=" orders1.length != 0 ">
                <h3 class="profile-username text-center">Meja No: {{ post.noMeja }} | Minuman</h3>
                  <table style="font-size:18px;font-family: Courier New;width:100%">
                    <thead>
                    <tr>
                      <th>Menu</th>
                      <th>Qty</th>
                      <th>Jam</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders1" :key="order.id">
                        <td>{{ order.nmMenu }}<br>
                            {{order.noteOrder }}</td>
                        <td>{{ order.qtyOrder }}</td>
                        <td>{{ new Date(order.wktOrder).toLocaleTimeString() }}</td>
                      </tr>
                    </tbody>
                  </table>                
                </span>
                </div>
              </div>

    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalOrder=false">
                  <span aria-hidden="true">&times;</span> CLOSE
                </button>
                <h4 class="modal-title">List Order</h4>
              </div>
              <div class="modal-body">

                <span v-if=" orders.length != 0 ">
                  <h3 class="profile-username text-center">Meja No: {{ post.noMeja }}</h3>
                 
                  <table class="table table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Jam</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td><a @click.prevent="PostDeleteTrxO(id = order.id)" ><i class="fa fa-trash"></i></a></td>
                        <td>{{ order.nmMenu }}<br>
                            {{order.noteOrder }}</td>
                        <td>{{ order.qtyOrder }}</td>
                        <td>{{ new Date(order.wktOrder).toLocaleTimeString() }}</td>
                      </tr>
                    </tbody>
                  </table>
                </span>
                <br>
                <br>
                <br>

                <span v-if=" orders1.length != 0 ">
                <h3 class="profile-username text-center">Meja No: {{ post.noMeja }}</h3>
                  <table class="table table-striped" width="100%">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Menu</th>
                      <th>Qty</th>
                      <th>Jam</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders1" :key="order.id">
                        <td><a @click.prevent="PostDeleteTrxO(id = order.id)" ><i class="fa fa-trash"></i></a></td>
                        <td>{{ order.nmMenu }}<br>
                            {{order.noteOrder }}</td>
                        <td>{{ order.qtyOrder }}</td>
                        <td>{{ new Date(order.wktOrder).toLocaleTimeString() }}</td>
                      </tr>
                    </tbody>
                  </table>                
                </span>
                
              <a href="#"  @click="printOrder(id= post.id)" class="btn btn-success" >Print Order</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
  <!------End Modal Order ----->

<!-- modal start -->
  <div v-if="showModalMove">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalMove=false">
                  <span aria-hidden="true">&times;</span>CLOSE
                </button>
                <h4 class="modal-title">Pindah Ke Meja</h4>
              </div>
              <div class="modal-body">

                
                <select v-model='move1' class="form-control">
                  <option v-for='move1 in mejaKosong' v-bind:value='move1' :key="move1.id">Meja No.{{move1.noMeja}}</option>
                </select>

                <div v-if="move1">
                  <form  @submit.prevent="PostMove" >
                    <div class="form-group">
                      <input type="hidden" v-model="post.id">
                      <input type="hidden" v-model="post.waiterMeja">
                      <input type="hidden" class="form-control" v-model="move1.id">
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success">Pindah</button>
                    </div>
                  </form>
                </div>
                <div v-else>
                  no Selected
                </div>
                

              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
  <!------End Modal Move ----->

  <!-- modal Auth start -->
  <div v-if="showModalAuth">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalAuth=false">
                  <span aria-hidden="true">&times;</span>CLOSE
                </button>
                <h4 class="modal-title">Auth Require</h4>
              </div>
              <div class="modal-body">
                <form @submit.prevent="postAuthCek">
                  <div class="form-group has-feedback">
                    <input type="hidden" class="form-control" v-model="idWillDelete" disabled>
                    <input type="hidden" class="form-control" v-model="menuWillEdit" disabled>
                    <input type="hidden" class="form-control" v-model="mejaWillEdit" disabled>
                    <input type="text" class="form-control" v-model="aksi" disabled>
                    <input type="hidden" class="form-control" v-model="username" disabled>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" v-model="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                    <div class="col-xs-4" v-if="aksi === 'ubah'">
                      <h4 class="modal-title">Masukkan Jumlah {{ namaWillEdit }}</h4>
                    </div>
                    <div class="col-xs-4" v-if="aksi === 'ubah'">
                      <input type="text" class="form-control" v-model="newqty" placeholder="new Qty">
                    </div>
                    
                    <!-- /.col -->
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Authorize</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
  <!------End Modal Auth ---->

  <!-- modal edit start -->
  <div v-if="showModalEdit">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalEdit=false">
                  <span aria-hidden="true">&times;</span>CLOSE
                </button>
                <h4 class="modal-title">Edit Qty</h4>
              </div>
              <div class="modal-body">
                <form @submit.prevent="SimpanEdit">
                  <div class="form-group has-feedback">
                    <input type="hidden" class="form-control" v-model="idWillDelete" disabled>
                    <input type="hidden" class="form-control" v-model="menuWillEdit" disabled>
                    <input type="hidden" class="form-control" v-model="mejaWillEdit" disabled>
                    <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                  </div>
                  <div class="row">
                      <div class="col-xs-9" >
                        <h4 class="modal-title">Masukkan Jumlah {{namaWillEdit}}</h4>
                      </div>
                      <div class="col-xs-4" >
                        <input type="text" class="form-control" v-model="newqty" placeholder="new Qty">
                      </div>
                      
                      <!-- /.col -->
                      <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ubah</button>
                      </div>
                      <!-- /.col -->
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
  <!------End Modal Edit ---->


  
  <div v-if="showModalMenu">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalMenu=false">
                  <span aria-hidden="true">&times;</span>CLOSE
                </button>
                <h4 class="modal-title">Add Menu</h4>
              </div>
              <div class="modal-body">

                <!------Tes Select menu ---->
                <label>Menu cari:</label>
                  <input type="text" ref="menu" v-model="menu" v-on:keyup="get_menu" class="form-control "  >
                    
                      <span v-if="menuss.lenght === 0">
                      </span>
                      <span v-else>
                        <ul class="list-group">
                          <li v-for="(menu, id) in menuss" @click="select_menu(menu)" :key="menu.id" class="list-group-item autocomplete-box-li">
                              {{ id+1 }}
                              {{ menu.nmMenu }}
                          </li>
                        </ul>
                      </span>
                    

                <!------End Tes ---->
                
           
                <div v-if="post2">
                  <form  @submit.prevent="PostMenu" >
                    <div class="form-group">
                      
                      <input type="hidden" v-model="post.noMeja">
                      <input type="hidden" v-model="noNota" placeholder="No nota">
                      <input type="hidden" v-model="post2.id">
                      <input type="hidden" v-model="post2.kdMenu">
                      <input type="hidden" v-model="post2.ktgMenu">
                      <input type="hidden" v-model="post2.promoMenu">
                      <input type="hidden" class="form-control" v-model="post2.nmMenu">
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" v-model="note" rows="2" placeholder="Note"></textarea>
                    </div>
                    <div class="form-group">
                      <input type="number" class="form-control" v-model="post2.hargaMenu" placeholder="Harga" @keypress="onlyNumber" required>
                    </div>
                    <div class="form-group">
                      <input type="number" class="form-control" v-model="qtyBarang" placeholder="Qty" @keypress="onlyNumber" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" :value="(post2.hargaMenu * qtyBarang) || 0" :name="total"  disabled>
                    </div>
                    <div class="form-group">
                    <button type="submit"  class="btn btn-success">Add</button>
                    </div>
                  </form>
                </div>
                <div v-else>
                  No Selected
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>

<div v-if="showModalSplit">

  <div id="printMeSplit">
                <!-- info row -->
                <p class="text-muted text-center">
                <img :src="'/image/logoNota.png'" id="logono" >
                </p>
                <p class="text-bold text-center">
               
                    Phone / Wa: 081 239 099 998<br>
                    Email: warungdaladesa@gmail.com<br>
                    FB : warungdaladesa<br>
                    IG : warung.daladesa.sangeh
                  
                </p>
              <div class="row invoice-info">
                <div class="col-xs-6">
                  <p class="text-muted" style="margin-top: 2px;">
                  <address>
                    <strong>Customer :</strong> {{pelanggan}}<br>
                    <b> Tgl : </b>{{tglNota}}<br>
                    <b> Meja No : </b>{{post.noMeja}}<br>
                    <b>Waiter : </b>{{post.name}}<br>
                  </address>
                  
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                  <p class="text-muted" style="margin-top: 2px;">
                  <address>
                  <b>No Inv: </b>{{noNota}}<br>
                  <b>Kasir : </b>{{$session.get('user')}}<br>
                  <b>Pax: </b>{{post.paxMeja}}<br>
                  <b>Type : </b>
                  <span v-if="pembayaran === '1'">
                    Cash
                  </span>
                  <span v-else-if="pembayaran === '2'">
                    Debit
                  </span>
                  <span v-else-if="pembayaran === '3'">
                    E-Money
                  </span>
                  </address>
                  
                </div>

                <!-- /.col -->
              <!-- /.row -->

                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>Nama </th>
                          <th>Qty</th>
                          <th>Harga</th>
                          <th>Total</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="trx in splitNota" :key="trx.id">
                          <td >{{ trx.nmBarangTmp }} </td>
                          <td >{{ trx.qtyTmp}}</td>
                          <td >{{ trx.hrgJualTmp | currency }}</td>
                          <td >{{ trx.qtyTmp * trx.hrgJualTmp | currency }}</td>
                      </tr>
                      </tbody>
                          <tr>
                              <th colspan="3">subTotal :</th>
                              <th>{{totalItem | currency}}</th>
                          </tr>
                          <tr>
                              <th colspan="3">Tax & Service : {{ pajak }} %</th>
                              <th>{{ Math.floor(totalItem * pajak / 100 ) | currency}}</th>
                          </tr>
                          <tr>
                              <th colspan="3">Discount : {{ diskon }} %</th>
                              <th>{{ Math.floor(totalItem * diskon / 100) | currency}}</th>
                          </tr>
                          <tr>
                              <th colspan="3">subTotal :</th>
                              <th>{{ Math.floor((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100))  || 0 | currency }}</th>
                          </tr>

                          <tr v-if="pembayaran === '1'">
                          </tr>
                          <tr v-else-if="pembayaran === '2'">
                              <th colspan="3">Card Charge : {{ taxDebit }} %</th>
                              <th>{{ Math.floor((totalItem * pajak / 100 + totalItem) - (groupNota * diskon / 100)) * taxDebit / 100 | currency }}</th>
                          </tr>

                          <tr>
                              <th colspan="3">Payment :</th>
                              <th>{{ totalBayarS | currency }}</th>
                          </tr>

                          <tr v-if="pembayaran === '1'">
                              <th colspan="3">Kembalian :</th>
                              <th>{{ Math.floor(totalBayarS - ((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100)))  || 0 | currency }}</th>
                          </tr>
                          <tr v-else-if="pembayaran === '2'">
                          </tr>

                  </table>
                  <p class="text-bold text-center">
                      Terima Kasih <br>
                      Belanja Anda Hal Baik Bagi Dunia<br>
                      Tidak enak Kasi Tau Kami, ENAK kasi tau temanmu<br>                              
                  </p>
                </div>
              </div>
    </div>

    
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalSplit=false">
                  <span aria-hidden="true">&times;</span>CLOSE
                </button>
                <h4 class="modal-title">Split Bill</h4>
              </div>
              <div class="modal-body">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th colspan="5">Barang Yang Belum di bayar</th>
                    </tr>
                    <tr>
                      <th>Nama </th>
                      <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
                      <th>AKSI</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(trx, index) in crt" :key="trx.index" >
                      <td v-if="trx.qtyTmp > 0">{{ trx.nmBarangTmp }} </td>
                      <td v-if="trx.qtyTmp > 0">{{ trx.hrgJualTmp | currency }}</td>
                      <td v-if="trx.qtyTmp > 0">
                        <input type="number" v-model="qtySplit[index]" />
                          <div hidden>
                          <vue-numeric-input v-model="qtySplit[index]" :min="0" :max="trx.qtyTmp" :value="1" required></vue-numeric-input>
                          </div>
                      </td>
                      <td v-if="trx.qtyTmp > 0">{{ trx.hrgJualTmp * qtySplit[index] | currency }}</td>
                      <td v-if="trx.qtyTmp > 0" class="text-center">
                        <div v-if="qtySplit[index] >= '1'">
                          <button @click.prevent="updateItem(barcode = trx.id, index, trx)" class="btn btn-success">Tambah</button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-hover table-bordered">
                 <thead>
                   <tr>
                     <th colspan="4">Barang Yang akan di bayar</th>
                   </tr>
                  <tr>
                      <th>Nama </th>
                      <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
                      <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(trx, index) in splitNota" :key="trx.id">                                    
                      <td>{{ trx.nmBarangTmp }} </td>
                      <td>{{ trx.hrgJualTmp | currency }}</td>
                      <td>{{ trx.qtyTmp }}</td>
                      <td>{{ trx.hrgJualTmp * trx.qtyTmp | currency }}</td>
                      <td>
                        <button @click.prevent="batalItem(barcode = trx.id, index, trx)" class="btn btn-danger">Batal</button>
                      </td>
                  </tr>
                  </tbody>
                </table> 
                <form  @submit.prevent="PostSplit" >
                <input type="hidden" class="form-control" v-model="tglNota" >
                <input type="hidden" class="form-control" v-model="pelanggan" placeholder="Customer">
                <input type="hidden" class="form-control" v-model="noNota" placeholder="No nota">
                <input type="hidden" class="form-control" v-model="totalItem">
                <input type="hidden" class="form-control" v-model="post.waiterMeja">
                <input type="hidden" class="form-control" v-model="subtotaltp">
                <input type="hidden" class="form-control" v-model="groupNota">
                <p class="text-muted text-center">
                <input type="hidden" class="form-control" :value="((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100))  || 0 " :name="totalTransaksiBayar"  >
                <h3 class="profile-username ">Total {{ Math.floor(((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100)) + ((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100)) * taxDebit / 100)  || 0 | currency }}</h3>
                <div class="row input-group">
                <div class="col-xs-4">
                  <span class="input-group-addon">Tax in %</span>
                  <input type="number" step=".01" class="form-control " v-model="pajak" placeholder="Tax">
                  <input type="hidden" class="form-control" :value="(totalItem * pajak / 100 + totalItem)" :name="totalTransaksipjk" >
                </div>
                <div class="col-xs-4">
                  <span class="input-group-addon">Disc in %</span>
                  <input type="number" step=".01" class="form-control" v-model="diskon" placeholder="Diskon">
                  <input type="hidden" class="form-control" :value="totalItem * diskon / 100" :name="diskon1" >
                </div>
              </div>
              <br>
                            <select class='form-control' v-model='pembayaran' >
                                <option value='1' selected>Cash</option>
                                <option value='2'>Debit</option>
                                <option value='3'>E-Money</option>
                            </select>
                            <br>
                            <div v-if="pembayaran === '1'">
                              <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" class="form-control" v-model="totalBayarS" placeholder="Bayar" required>
                                  </div>
                                  <input type="hidden" class="form-control" :value="Math.floor(totalBayarS - ((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100)))" :name="kembalianS" >
                                  <h3 class="profile-username ">Kembali : {{ Math.floor(totalBayarS - ((totalItem * pajak / 100 + totalItem) - (totalItem * diskon / 100)))  || 0 | currency  }}</h3>
                                  <p class="text-muted text-center">
                                  <button type="submit" v-on:click="addG()" class="btn btn-success" >Bayar</button> 
                                  </p>
                            </div>
                            <div v-else-if="pembayaran === '2'">
                              <div class="input-group">
                                    <span class="input-group-addon">Card Carge %</span>
                                    <input type="number" step=".01" class="form-control" v-model="taxDebit" placeholder="0" >
                                    <input type="hidden" class="form-control" :value="((totalItem * pajak / 100 + subtotal) - ((totalItem * pajak / 100 + totalItem) * diskon / 100)) * taxDebit / 100 " :name="pajakKartu" >
                                  </div>
                                  <p>
                                  <div class="input-group">
                                    <span class="input-group-addon">Card No.</span>
                                    <input type="number" class="form-control" v-model="noDebit" placeholder="No Kartu" >
                                  </div>
                                  <p>
                                  <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" class="form-control" v-model="totalBayarS" placeholder="Bayar" required>
                                  </div>
                                  <br>
                                  <p class="text-muted text-center">
                                  <button type="submit" v-on:click="addG()" class="btn btn-success" >Bayar</button>       
                                          
                                  </p>
                            </div>
                            <div v-else-if="pembayaran === '3'">
                              Emoney
                            </div>

               
              </form>

              
              


              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
<!---- Modal Bayar End ---->
  

  <div v-if="showModalBayar">

    <div id="printMe">
                <section class="invoice">
                <!-- info row -->
                <p class="text-muted text-center">
                <img :src="'/image/logoNota.png'" id="logono">
                </p>
                <p class="text-bold text-center">
               
                    Phone / Wa: 081 239 099 998<br>
                    Email: warungdaladesa@gmail.com<br>
                    FB : warungdaladesa<br>
                    IG : warung.daladesa.sangeh
                  
                </p>
              <div class="row invoice-info">
                <div class="col-xs-6">
                  <p class="text-muted" style="margin-top: 2px;">
                  <address>
                    <strong>Customer :</strong> {{pelanggan}}<br>
                    <b> Tgl : </b>{{tglNota}}<br>
                    <b> Meja No : </b>{{post.noMeja}}<br>
                    <b>Waiter : </b>{{post.name}}<br>
                  </address>
                  
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                  <p class="text-muted" style="margin-top: 2px;">
                  <address>
                  <b>No Inv: </b>{{noNota}}<br>
                  <b>Kasir : </b>{{$session.get('user')}}<br>
                  <b>Pax: </b>{{post.paxMeja}}<br>
                  <b>Type : </b>
                  <span v-if="pembayaran === '1'">
                    Cash
                  </span>
                  <span v-else-if="pembayaran === '2'">
                    Debit
                  </span>
                  <span v-else-if="pembayaran === '3'">
                    E-Money
                  </span>
                  </address>
                  
                </div>

                <!-- /.col -->
              <!-- /.row -->

                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Nama </th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="trx in trxs" :key="trx.id">
                                    <td width="40%">{{ trx.nmBarangTmp }} </td>
                                    <td width="10">{{ trx.qtyTmp}}</td>
                                    <td width="25%">{{ trx.hrgJualTmp | currency }}</td>
                                    <td width="25%" style="text-align:right">{{ trx.totalTmp | currency }}</td>
                                </tr>
                                </tbody>
                                <tfoot style="display: table-row-group">
                                    <tr>
                                        <th colspan="2">subTotal :</th>
                                        <th colspan="2" style="text-align:right">{{subtotal | currency}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Tax & Service : {{ pajak }} %</th>
                                        <th colspan="2" style="text-align:right">{{ Math.floor(subtotal * pajak / 100 ) | currency}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Discount : {{ diskon }} %</th>
                                        <th colspan="2" style="text-align:right">{{ Math.floor(subtotaltp * diskon / 100) | currency}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">subTotal :</th>
                                        <th colspan="2" style="text-align:right">{{ Math.floor((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100))  || 0 | currency }}</th>
                                    </tr>

                                    <tr v-if="pembayaran === '1'">
                                      
                                    </tr>
                                    <tr v-else-if="pembayaran === '2'">
                                        <th colspan="2">Card Charge : {{ taxDebit }} %</th>
                                        <th colspan="2" style="text-align:right">{{ Math.floor((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100)) * taxDebit / 100 | currency }}</th>
                                    </tr>

                                    <tr>
                                        <th colspan="2">Payment :</th>
                                        <th colspan="2" style="text-align:right">

                                        {{ totalBayar || 0 | currency }}
                                        

                                        </th>
                                    </tr>

                                    <tr v-if="pembayaran === '1'">
                                        <th colspan="2">Kembalian :</th>
                                        <th colspan="2" style="text-align:right">{{ Math.floor(totalBayar - ((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100)))  || 0 | currency }}</th>
                                    </tr>
                                    <tr v-else-if="pembayaran === '2'">
                                    </tr>
                              </tfoot>
                            </table>
                            <p class="text-bold text-center">
                                Terima Kasih <br>
                                Belanja Anda Hal Baik Bagi Dunia<br>
                                Tidak enak Kasi Tau Kami, ENAK kasi tau temanmu<br>                              
                            </p>
                        </div>
                      </div>
                        </section>
            </div>


    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="showModalBayar=false">
                  <span aria-hidden="true">&times;</span>CLOSE
                </button>
                <h4 class="modal-title">Add Payment</h4>
              </div>
              <div class="modal-body">
                <form  @submit.prevent="PostTransaksi" >
                  <input type="hidden" class="form-control" v-model="tglNota" >
                <input type="hidden" class="form-control" v-model="pelanggan" placeholder="Customer">
                <input type="hidden" class="form-control" v-model="noNota" placeholder="No nota">
                <input type="hidden" class="form-control" v-model="subtotal">
                <input type="hidden" class="form-control" v-model="post.waiterMeja">

                <input type="hidden" class="form-control" v-model="subtotaltp">

                <p class="text-muted text-center">
                <input type="hidden" class="form-control" :value="((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100))  || 0 " :name="totalTransaksiBayar"  >
                <h3 class="profile-username ">Total {{ Math.floor(((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100)) + ((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100)) * taxDebit / 100)  || 0 | currency }}</h3>


                <div class="row input-group">
                <div class="col-xs-4">
                  <span class="input-group-addon">Tax in %</span>
                  <input type="number" step=".01" class="form-control " v-model="pajak" placeholder="Tax">
                  <input type="hidden" class="form-control" :value="(subtotal * pajak / 100 + subtotal)" :name="totalTransaksipjk" >
                </div>
                <div class="col-xs-4">
                  <span class="input-group-addon">Disc in %</span>
                  <input type="number" step=".01" class="form-control" v-model="diskon" placeholder="Diskon">
                  <input type="hidden" class="form-control" :value="subtotaltp * diskon / 100" :name="diskon1" >
                </div>
              </div>
              <br>
                            <select class='form-control' v-model='pembayaran' >
                                <option value='1' selected>Cash</option>
                                <option value='2'>Debit</option>
                                <option value='3'>E-Money</option>
                            </select>
                            <br>
                            <div v-if="pembayaran === '1'">
                              <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" class="form-control" v-model="totalBayar" placeholder="Bayar" required>
                                  </div>
                                  
                                  <h3 class="profile-username ">Kembali : {{ Math.floor(totalBayar - ((subtotal * pajak / 100 + subtotal) - (subtotaltp * diskon / 100)))  || 0 | currency  }}</h3>
                                  <p class="text-muted text-center">
                                  <button type="submit"  class="btn btn-success" >Bayar</button> 
                                  <a href="#"  @click="printBill(printMe)" class="btn btn-success" >Print Bill</a>               
                                  </p>
                            </div>
                            <div v-else-if="pembayaran === '2'">
                              <div class="input-group">
                                    <span class="input-group-addon">Card Carge %</span>
                                    <input type="number" step=".01" class="form-control" v-model="taxDebit" placeholder="0" >
                                    <input type="hidden" class="form-control" :value="((subtotal * pajak / 100 + subtotal) - ((subtotal * pajak / 100 + subtotal) * diskon / 100)) * taxDebit / 100 " :name="pajakKartu" >
                                  </div>
                                  <p>
                                  <div class="input-group">
                                    <span class="input-group-addon">Card No.</span>
                                    <input type="number" class="form-control" v-model="noDebit" placeholder="No Kartu" >
                                  </div>
                                  <p>
                                  <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" class="form-control" v-model="totalBayar" placeholder="Bayar" required>
                                  </div>
                                  <br>
                                  <p class="text-muted text-center">
                                  <button type="submit"  class="btn btn-success" >Bayar</button>       
                                  <a href="#"  @click="printBill(printMe)" class="btn btn-success" >Print Bill</a>         
                                  </p>
                            </div>
                            <div v-else-if="pembayaran === '3'">
                              Emoney
                            </div>

               
              </form>

              
              


              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
<!---- Modal End ---->
                    
    </div>


    

</template>

<style type="text/css">
.autocomplete-box-li:hover {
  background-color: #f2f2f2;
}
.autocomplete-box{
  position: absolute;
  z-index: 1;
}
.swal2-container {
  z-index: 20000 !important;
}

    #printMe { display: block; }
    #lastOrder { display: block; }

    @media print
    {
      @page{
        margin: 0;
        /* width: 90mm; */
        /* height: auto; */
        
      }
      body * {
        visibility: hidden;
        /* width: 90mm; */
        height: auto;
      }
      #printMe, #printMe * {
        visibility: visible;
        font-size: 8pt;
      }
      #printMeSplit, #printMeSplit * {
        visibility: visible;
        font-size: 8pt;
      }
      #lastOrder, #lastOrder * {
        visibility: visible;
        font-size: 8pt;
        
      }

      #printMe {
        position: absolute;
        left: 0;
        top: 0;
        font-size: 8pt;
        width: 100%;
        height: 100%;
      }
      #printMeSplit {
        position: absolute;
        left: 0;
        top: 0;
        font-size: 8pt;
        width: 100%;
        height: 100%;
      }
      #logono {
        width: 60px;
      }

      #lastOrder {
        position: absolute;
        left: 0;
        top: 0;
        font-size: 8pt;
        width: 100%;
        height: 100%;
      }
    }
    </style>


<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';
  import VueSingleSelect from "vue-single-select";
  import moment from 'moment'
  import Print from 'vue-print-plugin';
 

  
    export default {
      components: { DatePicker, VueSingleSelect, Print },
        data() {
            return {
              username: 'Supervisor',
              password: '',
              idWillDelete: '',
              menuWillEdit: '',
              mejaWillEdit: '',
              namaWillEdit: '',
              aksi: '',
              newqty: 1,
              post: {},
              waiters: {},
              statusMeja:{},
              orders:[],
              orders1:{},
              move1: null,
              post1: null,
              post2: [],
              waiter: {},
              users: {},
              menus: {},
              menu:'',
              menuss: [],
              trxs: [],
              mejaKosong: {},
              validation: [],
              showModalMove: false,
              showModalOrder: false,
              showModalAuth: false,
              showModalEdit: false,
              showModal: false,
              showModalMenu: false,
              showModalBayar: false,
              showModalSplit: false,
              nmBarang: '',
              idBarang: '',
              hargaJual: '',
              qtyBarang: 1,
              note:  '',
              sisaStok: '',
              noNota: '',
              pelanggans: {},
              pelanggan: 'Cash',
              noMeja: '',
              total: '',
              subtotal: '',
              subtotaltp: '',
              pajak: '0',
              diskon: '0',
              diskon1: '',
              totalTransaksi: '',
              totalTransaksipjk: '',
              totalBayar: '',
              totalBayarS: '',
              kembalianBayar: '0',
              totalTransaksiBayar: '',
              type: '',
              brg: '',
              taxDebit: '0',
              noDebit: '0',
              pembayaran: '1',
              pajakKartu:'',
              mytimer: 0,
              adminuser: '',
              nmMenu1: '',
              kdMenu1: '',
              qtySplit: [],
              printMe: '',
              printMeSplit: '',
              crt: [],
              splitNota: [],
              groupNota: 0,
              kembalianS: '',
              //waitername : this.waiter.name,
              //optionLabel: users.nmBarang,
              // tglNota: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
              tglNota: moment().format('YYYY/MM/DD HH:mm:ss'),
              // toDay: moment().format('YYYY/MM/DD'),
                
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            let uri = `/api/meja/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
            });
            this.loadMejaKosong();
            this.loadTotal();
            this.loadTotalTnpPromo();
            this.loadNota();
            this.loadDataMenu();
            this.loadDataTransaksi();
            this.loadWaiter();
            this.ListOrder();
            this.ListOrder1();
            this.loadPelanggan();
            this.adminuser = this.$session.get('roleID');
            localStorage.setItem('notaSplit', '[]');
            if(localStorage.getItem('cartItems') != null){
              this.crt = JSON.parse(localStorage.getItem('cartItems'));
              // localStorage.setItem('cartItems',JSON.stringify(trxs));
            }else{
              localStorage.setItem('cartItems', '[]');
            }
            
            
            
            
        },
        watch: {
          post: function() {
            this.$emit('input', this.post);
          }
        },
        //props: ['value'],
        props: ['optionLabel','value',],

              
        methods: {
          postAuthCek(){
                let uri = '/api/authcek';
                this.axios.post(uri, {
                  username: this.username,
                  password: this.password
                }).then(response => {

                  if (response.data.success === true ) {
                    // alert(this.aksi)
                    if(this.aksi === 'hapus'){

                      this.axios.delete('/api/orderDelete/'+ this.idWillDelete)
                      .then(response => {
                          // alert('Berhasil Di Hapus');
                          this.$swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil Di Hapus',
                            showConfirmButton: false,
                            timer: 1500
                          });
                          this.loadDataTransaksi();
                          this.loadTotal();
                          this.ListOrder();
                          this.ListOrder1();
                          this.showModalAuth = false;
                          this.password = '';
                      }).catch(error => {
                        alert('gagal hapus')
                      });

                    }else if(this.aksi === 'ubah'){

                      let uri = '/api/editqty';
                      this.axios.post(uri, {
                        id: this.idWillDelete,
                        qty: this.newqty
                      }).then(response => {
                        this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Qty Di Update',
                          showConfirmButton: false,
                          timer: 1500
                        });
                        this.loadDataTransaksi();
                        this.loadTotal();
                        this.ListOrder();
                        this.ListOrder1();
                        this.showModalAuth = false;
                        this.password = '';
                      });
                      console.log('ubah qty dengan auth');

                    }

                  }else{
                    alert('you not authorize');
                  }

                }).catch(error => {
                  alert('gagal login')
                });
          },
          addG: function() {
              this.groupNota++
          },
          opensplit(trxs){
            this.showModalSplit = true;
            history.pushState(null, null, location.href);
                    window.onpopstate = function () {
                        history.go(1);
                    };
            // let cartItems = this.orders;
            // localStorage.setItem('cartItems', '[]');
            if(localStorage.getItem('cartItems') === '[]'){
              localStorage.setItem('cartItems',JSON.stringify(trxs));
              this.getCart();
              this.getSplitNota();
            }else{
              // var cartItems = JSON.parse(localStorage.getItem('cartItems'));
              // var $ada = cartItems.filter(d => d.noMejaTmp === this.mj);
              // if($ada != null){
                this.getCart();
                this.getSplitNota();
              // }else{
              //   cartItems.push(trxs);
              //   localStorage.setItem('cartItems',JSON.stringify(cartItems));
              //   this.getCart();
              // this.getSplitNota();
              // }
            }           
          },
          getCart: function() {
                //  if (this.crt === null){
                //       this.crt = localStorage.setItem('cartItems', '[]');
                //  }else{
                   this.crt = JSON.parse(localStorage.getItem('cartItems'));
                      // const cartItems = JSON.parse(localStorage.getItem('cartItems'));
                      // const objIndex = cartItems.findIndex((e => e.noMejaTmp === '15'));
                      // this.crt = cartItems.filter(b => b.noMejaTmp === this.mj);
                      this.isicart = Object.keys(JSON.parse(localStorage.getItem('cartItems'))).length;
                 // }
            },
          getSplitNota: function() {
                 if (this.splitNota === null){
                      this.splitNota = localStorage.setItem('notaSplit', '[]');
                 }else{
                      this.splitNota = JSON.parse(localStorage.getItem('notaSplit'));
                      // var notaSplit = JSON.parse(localStorage.getItem('notaSplit'));
                      // this.splitNota = notaSplit.filter(d => d.noMejaTmp === this.mj);
                      // this.isicart = JSON.parse(localStorage.getItem('notaSplit')).length;
                 }
            },
          updateItem(barcode, index, trx) {
                const cartItems = JSON.parse(localStorage.getItem('cartItems'));
                const objIndex = cartItems.findIndex((e => e.id === barcode));
                const newQty = parseInt(this.qtySplit[index]) ;
                cartItems[objIndex].qtyTmp = cartItems[objIndex].qtyTmp - parseInt(newQty);
                localStorage.setItem('cartItems',JSON.stringify(cartItems));
                //alert('Quantity Update')
                this.getCart();
                this.isicart = Object.keys(JSON.parse(localStorage.getItem('cartItems'))).length;

                // notaSplit.push(trx); 
                // localStorage.setItem('cartItems',JSON.stringify(cartItems));
                // localStorage.setItem('notaSplit',JSON.stringify(trx));
                  let notaSplit;
                    if (localStorage.getItem('notaSplit')===null){
                        notaSplit = [];
                    }else{
                        notaSplit = JSON.parse(localStorage.getItem('notaSplit'));
                    
                        const oldItems = JSON.parse(localStorage.getItem('notaSplit')) || [];
                        const existingItem = oldItems.find(({ id }) => id === trx.id);
                        if (existingItem) {
                            const objIndex = notaSplit.findIndex((e => e.id === trx.id));
                            const oldQty = notaSplit[objIndex].qtyTmp;
                            const newQty = parseInt(oldQty) + parseInt(this.qtySplit[index]) ;
                            notaSplit[objIndex].qtyTmp = parseInt(newQty);
                            localStorage.setItem('notaSplit',JSON.stringify(notaSplit));
                            this.$swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: 'Quantity Update',
                              showConfirmButton: false,
                              timer: 1500
                            });
                            // alert('Quantity Update')
                            this.qtySplit[index] = 0;
                            this.getCart();
                            this.getSplitNota();
                            this.isiNotaSplit = Object.keys(JSON.parse(localStorage.getItem('notaSplit'))).length;
                        }else{
                        notaSplit.push(trx);
                        const objIndex = notaSplit.findIndex((e => e.id === trx.id));
                        notaSplit[objIndex].qtyTmp = parseInt(this.qtySplit[index]);  
                        localStorage.setItem('notaSplit',JSON.stringify(notaSplit));
                        this.getCart();
                        this.getSplitNota();
                        this.isiNotaSplit = Object.keys(JSON.parse(localStorage.getItem('notaSplit'))).length;
                        this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: trx.nmBarangTmp + 'Menu di tambahkan',
                          showConfirmButton: false,
                          timer: 1500
                        });
                        // alert(trx.nmBarangTmp + " berhasil disimpan")
                        this.qtySplit[index] = 0;
                        }
                        // this.qtySplit = 0 ;
                    }
            },
            batalItem(barcode, index, trx){
              const newCart = JSON.parse(localStorage.getItem('notaSplit'));
              const oldNota = JSON.parse(localStorage.getItem('notaSplit')) || [];
              const existingNota = oldNota.find(({ id }) => id === trx.id); 
              if (existingNota) {
                  const objIndex = newCart.findIndex((e => e.id === trx.id));
                  const oldQty = oldNota[objIndex].qtyTmp;

                  const newCartItem = JSON.parse(localStorage.getItem('cartItems'));
                  const objIndexItem = newCartItem.findIndex((a => a.id === trx.id));
                  const oldQtyItem = newCartItem[objIndexItem].qtyTmp;
                  // const nQty = oldItems[objIndex].qtyTmp;
                  const newQty = parseInt(oldQty) + parseInt(oldQtyItem) ;
                  newCartItem[objIndexItem].qtyTmp = parseInt(newQty);
                  localStorage.setItem('cartItems',JSON.stringify(newCartItem));

                  const filtered = newCart.filter(c => c.id !== trx.id);
                  localStorage.setItem('notaSplit', JSON.stringify(filtered));
                  this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Quantity Update',
                          showConfirmButton: false,
                          timer: 1500
                        });
                  // alert('Quantity Update')
                  this.getCart();
                  this.getSplitNota();
              }else{
                console.log("tidak ada barangnya");
              }
            },
          select_menu(menu){
                this.post2.id = menu.id
                this.post2.nmMenu = menu.nmMenu
                this.post2.kdMenu = menu.kdMenu
                this.post2.ktgMenu = menu.ktgMenu
                this.post2.promoMenu = menu.promoMenu
                this.post2.hargaMenu = menu.hargaMenu
                this.menu = menu.nmMenu
                this.menuss = [];
            },
          get_menu(){
                if(this.menu.length == 0){
                    this.menuss = [];
                }
                if(this.menu.length > 0){
                    axios.get('/api/carimenu',{params: {menu: this.menu}}).then(response => {
                        this.menuss = response.data.data;
                    });
                }
            },
          onlyNumber ($event) {
                //console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }   
            },
            qtyOnsplit () {
                //console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }   
            },

            cekStok() {
                this.brg = this.post1 - this.qtyBarang;
            },
            printBill() {
              //alert('print bill');
                window.print(printMe);
                //this.showModalBayar = false
            },
            printBillSplit() {
              //alert('print bill');
                window.print(printMeSplit);
                //this.showModalBayar = false
            },
            openOrder(){
              this.showModalOrder = true;
            },
            printOrder(id) {
                  var printOrder = document.getElementById("lastOrder");
                  var WinPrint = window.open('', '', 'width=900,height=650');
                  WinPrint.document.write('<html><head><title>reprint</title><link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">');
                  WinPrint.document.write('<link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">');
                  // WinPrint.document.write('<script type="text/javascript" src="assets/bower_components/jquery/dist/jquery.min.js"></scr' + 'ipt>');
                  // WinPrint.document.write('<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></scr' + 'ipt>');
                  // WinPrint.document.write('<script src="assets/dist/js/adminlte.min.js"></scr' + 'ipt>');
                  WinPrint.document.write('<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css"></head><body>');
                  WinPrint.document.write(printOrder.innerHTML);
                  WinPrint.document.write('</body></html>');
                  WinPrint.document.close();
                  WinPrint.focus();
                  WinPrint.print();
                  setTimeout(() => WinPrint.close(), 15000);
                // alert('print last order'+ id);
                // window.print(printOrder);
                // setTimeout(function(){
                  let uri = '/api/afterorderprint/'+ id;
                  this.axios.post(uri)
                      .then((response) => {
                          //this.$router.push({name: 'posts'});
                          this.orders = response.data.data;
                          // this.ListOrder();
                          // this.ListOrder1();
                          console.log('print order sukses');
                          //this.intervalFetchData();
                      }).catch(error => {
                        // this.ListOrder();
                      //this.validation = error.response.data.data;
                        console.log('ada yang error stelah print');
                  });
                // }, 12000); 
                setTimeout(() => this.$router.push({name: 'meja'}), 12000);
            },
            ListOrder(){
              let uri = `/api/orderprint/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        //this.$router.push({name: 'posts'});
                        this.orders = response.data.data;
                        // console.log(this.orders)
                    }).catch(error => {
                    //this.validation = error.response.data.data;
                      alert('ada yang error');
                });
            },
            ListOrder1(){
              let uri = `/api/orderprint1/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        //this.$router.push({name: 'posts'});
                        this.orders1 = response.data.data;
                    }).catch(error => {
                    //this.validation = error.response.data.data;
                      alert('ada yang error');
                });
            },
            PostUpdate() {
                let uri = `/api/posts/update/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({name: 'posts'});
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },
            loadTotal:function(){
                let uri = `/api/totalTrx/${this.$route.params.id}`;
                this.axios.post(uri).then(response => {
                  this.subtotal = response.data.subTotal;
                }).catch(error => {
                    console.log(error.response)
                });
            },
            loadTotalTnpPromo:function(){
                let uri = `/api/totalTrxTnpPromo/${this.$route.params.id}`;
                this.axios.post(uri).then(response => {
                  this.subtotaltp = response.data.subTotal;
                }).catch(error => {
                    console.log(error.response)
                });
            },
            loadNota:function(){
                let uri = `/api/noNota/${this.$route.params.id}`;
                this.axios.post(uri).then(response => {
                this.noNota = response.data.noNota;
                
            });
            },
            loadDataMenu:function(){
                let uri = '/api/menu';
                this.axios.get(uri).then(response => {
                this.menus = response.data.data;
                
            });
            },
            loadPelanggan:function(){
                let uri = '/api/pelanggan';
                this.axios.get(uri).then(response => {
                this.pelanggans = response.data.data;
                
            });
            },
            loadDataTransaksi:function(){
                let uri = `/api/transaksi/${this.$route.params.id}`;
                this.axios.post(uri).then(response => {
                this.trxs = response.data.data;
                // console.log(this.trxs)
                
            });
            },
            PostMove() {
                let uri = '/api/meja/pindah';
                this.axios.post(uri, {
                  noMejaLama: this.post.id,
                  noMejaBaru: this.move1.id,
                  waiterMeja: this.post.waiterMeja,
                })
                    .then((response) => {
                        this.$router.push({name: 'meja'});
                    }).catch(error => {
                        this.$router.push({name: 'meja'});
                });
            },
            loadMejaKosong:function(){
                let uri = '/api/mejakosong/';
                this.axios.get(uri).then(response => {
                this.mejaKosong = response.data.data;
                
                
            });
            },
            loadWaiter: function(){
                axios.get('/api/user/')
                    .then(function (response) {
                        this.waiters = response.data.data;
                    }.bind(this));
            },
            PostDeleteTrx(id, sts){
              this.idWillDelete = id;
              if(this.$session.get('roleID') == 'Admin') {
                this.axios.delete(`/api/orderDelete/${id}`)
                    .then(response => {
                        this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Berhasil Di Hapus',
                          showConfirmButton: false,
                          timer: 1500
                        });
                        this.loadDataTransaksi();
                        this.loadTotal();
                        this.ListOrder();
                        this.ListOrder1();
                    }).catch(error => {
                    
                });
              }else if(sts == '0'){
                this.axios.delete(`/api/orderDelete/${id}`)
                    .then(response => {
                        this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Berhasil DI Hapus',
                          showConfirmButton: false,
                          timer: 1500
                        });
                        this.loadDataTransaksi();
                        this.loadTotal();
                        this.ListOrder();
                        this.ListOrder1();
                    }).catch(error => {
                    
                });
              }else if(sts == '1' | this.$session.get('roleID') != 'Admin'){
                this.showModalAuth = true ;
              }
            },

            PostEditTrx(id, kode, meja, nama){
              this.idWillDelete = id;
              this.menuWillEdit = kode;
              this.mejaWillEdit = meja;
              this.namaWillEdit = nama;
              // console.log(id+' dan '+meja);
              if(this.$session.get('roleID') == 'Admin') {

                this.showModalEdit = true ;
                console.log('langsung eksekusi')
              }else{
                this.axios.post('/api/getprintstatus/', { kodeMenu : kode, meja: meja})
                    .then(response => {
                      var sts = response.data.data;
                      // console.log(sts.stsPrintOrder)

                      if(sts.stsPrintOrder == '0'){

                        console.log('langsung eksekusi blm di print order')
                        this.showModalEdit = true ;
                      }else if(this.$session.get('roleID') != 'Admin'){

                        this.showModalAuth = true ;
                      }

                    }).catch(error => {
                      console.log(error)
                    
                });                
              }

            },

            SimpanEdit(){
              // console.log('langsung ubah')
              // this.idWillDelete = id;
              let uri = '/api/editqty';
              this.axios.post(uri, {
                id: this.idWillDelete,
                qty: this.newqty
              }).then(response => {
                this.$swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Qty Di Update',
                  showConfirmButton: false,
                  timer: 1500
                });
                this.loadDataTransaksi();
                this.loadTotal();
                this.ListOrder();
                this.ListOrder1();
                this.showModalEdit = false;
              });
            },

            PostDeleteTrxO(id){
                this.axios.delete('/api/deleteneworder/'+id)
                    .then(response => {
                        this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Berhasil Di Hapus',
                          showConfirmButton: false,
                          timer: 1500
                        })
                        this.loadDataTransaksi();
                        this.loadTotal();
                        this.ListOrder();
                        this.ListOrder1();
                    }).catch(error => {
                    
                });
              
            },
            
            PostMenu() {
                let uri = '/api/addMenu/store';
                var harga = this.post2.hargaMenu;
                var jumlah = this.qtyBarang;
                this.axios.post(uri, 
                {
                    noNota: this.noNota,
                    noMeja: this.post.id,
                    nmBarang: this.post2.nmMenu,
                    idBarang: this.post2.kdMenu,
                    hargaJual: this.post2.hargaMenu,
                    qtyBarang: this.qtyBarang,
                    total: Number(harga) * Number(jumlah),
                    type: this.post2.kdMenu,
                    tglNota: this.tglNota,
                    waiterOrder: this.post.name,
                    note: this.note,
                    ktgMenu: this.post2.ktgMenu,
                    promoMenu: this.post2.promoMenu
                }).then((response) => {
                        //alert('sukses donkkkkkkkk');
                        // alert('sukses ditambahkan');
                        this.$swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Menu di tambahkan',
                          showConfirmButton: false,
                          timer: 1500
                        });
                        this.loadDataTransaksi();
                        this.loadTotal();
                        this.loadTotalTnpPromo();
                        this.ListOrder();
                        this.ListOrder1();
                        this.menu= '';
                        this.note= '';
                        this.qtyBarang= 1;
                        this.post2.hargaMenu= '';
                        //this.cekStatusMeja()
                        //this.showModalMenu = false
                    });
                
            },
            PostTransaksi() {
              let totalinv = Math.floor((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotaltp * this.diskon / 100)) + ((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotaltp * this.diskon / 100)) * this.taxDebit / 100;
              if(this.totalBayar < totalinv){
                alert('Jumlah Bayar Kurang Dari Total Invoice');
                }else{
                  // totalBayar = this.totalBayar;
                  let uri = '/api/addTransaksi/store';
                  this.axios.post(uri, 
                  {
                      noNota: this.noNota,
                      noMeja: this.post.id,
                      pelanggan: this.pelanggan,
                      tglNota: this.tglNota,
                      taxNota: Math.floor(this.subtotal * this.pajak / 100),
                      chargeNota: Math.floor((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotaltp * this.diskon / 100)) * this.taxDebit / 100,
                      diskonNota: Math.floor(this.subtotaltp * this.diskon / 100),
                      totalNota: Math.floor((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotaltp * this.diskon / 100)) + ((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotaltp * this.diskon / 100)) * this.taxDebit / 100,
                      bayarNota: this.totalBayar,
                      userNota: this.$session.get('userId'),
                      waiterNota: this.post.name,
                      typeNota: this.pembayaran,
                      pax: this.post.paxMeja,
                      pajakPembayaran: this.pajak,
                      diskonPembayaran: this.diskon,
                      chargePembayaran: this.taxDebit,
                      noKartuPembayaran: this.noDebit,
                      
                      kembalianNota: Math.abs(this.totalBayar - (((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotaltp * this.diskon / 100)) + ((this.subtotal * this.pajak / 100 + this.subtotal) - (this.subtotal * this.diskon / 100)) * this.taxDebit / 100)),
                      
                  }).then((response) => {
                          // this.$print(printMe);
                          window.print(printMe)
                          // this.totalBayar = '';
                          localStorage.removeItem('cartItems');
                          setTimeout(function(){
                              window.location.href = '/meja';
                          }, 13000);           
                  }).catch(error => {
                      alert('error! bro');
                      //console.log(error.response.message)
                  });
              
                }
            },
            // intervalFetchData: function () {
            // this.mytimer = setInterval(() => {    
            //     this.ListOrder();
            //     }, 3000);    
            // },
            PostSplit() {
              var isiform = this.splitNota;
              var gr = this.groupNota;
              var bs = this.totalBayarS;
              var km = Math.floor(this.totalBayarS - ((this.totalItem * this.pajak / 100 + this.totalItem) - (this.totalItem * this.diskon / 100)));// Math.abs(this.totalBayarS - (((this.totalItem * this.pajak / 100 + this.totalItem) - (this.groupNota * this.diskon / 100)) + ((this.totalItem * this.pajak / 100 + this.totalItem) - (this.totalItem * this.diskon / 100)) * this.taxDebit / 100));
              isiform.forEach(function (element) {
                element.groupNot = gr;
                element.bayarS = bs;
                element.kembalianS = km;
              });
              var formData = new FormData();
              formData.append('data', JSON.stringify(isiform));
              // console.log(JSON.stringify(isiform));
                let uri = '/api/addSplit/store';
                this.axios.post(uri, formData)
                .then((response) => {
                        //this.$print(printMe);
                        window.print(printMeSplit);
                        this.totalBayar = '';
                        setTimeout(() => {    
                          localStorage.setItem('notaSplit', '[]'); 
                          this.getSplitNota();
                        }, 10000);
                }).catch(error => {
                    alert('error! bro');
                    //console.log(error.response.message)
                });
                  
            },
        },
        mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            //loadData.call(this)
            this.loadTotalTnpPromo();
            // if(this.isicart > 0){
            // window.onbeforeunload = function() { return "Your work will be lost."; };
            // }
            
        },

        beforeDestroy () {
            clearInterval(this.mytimer)
            console.log('detail bersih')
        },

        computed: {
          totalItem: function(){
              let sum = 0;
              for(let i = 0; i < this.splitNota.length; i++){
                sum += (parseFloat(this.splitNota[i].hrgJualTmp) * parseFloat(this.splitNota[i].qtyTmp));
              }

            return sum;
          },
          
}
        
    }
</script>
