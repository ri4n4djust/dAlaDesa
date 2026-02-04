<template>
    <div class="mt-3">
        <status-login></status-login>
        <section class="content">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <form @submit.prevent="PostUpdate">

                            <div class="form-group">
                                <label>Username </label>
                                <input type="text" class="form-control" v-model="post.username" @keydown.space.prevent >
                            </div>

                            <div class="form-group">
                                <label>Nama </label>
                                <input type="text" class="form-control" v-model="post.name"
                                       placeholder="Masukkan Nama">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" v-model="post.email"
                                       placeholder="Harga">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" v-model="post.password"
                                       placeholder="Password" required>
                            </div>

                            <div class="form-group">
                            <label>Select Role: </label>
                            <select class='form-control' v-model='post.role' required>
                                <option  value='Admin' >Admin</option>
                                <option value='Operator' >Operator</option>
                                <option value='Kasir' >Kasir</option>
                            </select>
                            </div>
                            

                            <div class="form-group">
                                <router-link :to="{ name: 'user' }" class="btn btn-primary btn-success">KEMBALI</router-link>
                                <button type="submit" class="btn btn-md btn-success">UPDATE</button>
                                <button type="reset" class="btn btn-md btn-danger">RESET</button>
                            </div>

                        </form>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
      <!-- /.row -->

    </section>




                    
</div>

</template>

<script>
 import VueSingleSelect from "vue-single-select";
    export default {
components: { VueSingleSelect },
        data() {

            return {
                post: {},
                validation: [],
                post1: null,
                komposisis: {},
                users: {},

            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            let uri = `/api/user/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
            });
            this.loadData()
        },
        watch: {
          post: function() {
            this.$emit('input', this.post);
          }
        },
        props: ['value'],

        mounted () {
            //this.intervalFetchData1();
            //this.intervalFetchData();
            //this.bindings()
            this.loadData()
        },

        methods: {
            PostUpdate() {
                let uri = `/api/user/update/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({name: 'user'});
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },
            loadData:function(){
                let uri = '/api/user';
                this.axios.get(uri).then(response => {
                this.users = response.data.data;
                
                });
            },
            
            PostDelete(id)
            {
                this.axios.delete(`/api/komposisi/${id}`)
                    .then(response => {
                        alert('Berhasil Di Hapus');
                        this.loadDataKomposisi()
                    }).catch(error => {
                    
                });
            },
        }
    }
</script>
