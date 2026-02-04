<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">TAMBAH MENU</div>

                    <div class="card-body">

                        <form @submit.prevent="PostStore">

                            
                                <input type="text" class="form-control" v-model="post.kdMenu" disabled >


                            <div class="form-group">
                                <label>Nama Menu</label>
                                <input type="text" class="form-control" v-model="post.nmMenu"
                                       placeholder="Masukkan Nama">
                                <div v-if="validation.nmMenu">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.nmMenu[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" class="form-control" v-model="post.hargaMenu"
                                       placeholder="Harga">
                                <div v-if="validation.hargaMenu">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.hargaMenu[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                            <label>Kategori Menu:</label>
                            <select class='form-control' v-model='post.ktgMenu' required>
                                <option  value='M01' selected>Food</option>
                                <option value='M02' >Drink</option>
                            </select>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="promo" v-model="post.promo">
                                <label for="promo">Promo</label>
                            </div>
                            

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">SIMPAN</button>
                                <router-link :to="{ name: 'menu' }" class="btn btn-primary btn-success">KEMBALI</router-link>

                            </div>


                        </form>


                    </div>
                </div>
      
  
  
</template>


<script>
    export default {
        data() {
            return {
                post: {},
                validation: [],
                kdMenu: '',
                stokMenu: '1',
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created: function(){
            this.loadKdMenu()
        },
        methods: {
            
            PostStore() {
                let uri = '/api/menu/store';
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({ name: 'menu' });
                        this.loadKdMenu()
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },
            loadKdMenu:function(){
                let uri = '/api/kodeMenu/';
                this.axios.get(uri).then(response => {
                this.post.kdMenu = response.data.kdMenu;
                
            });
            },
            
        },
        
    }
</script>
