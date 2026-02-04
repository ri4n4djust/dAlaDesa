<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">TAMBAH USER</div>

                    <div class="card-body">

                        <form @submit.prevent="PostStore">

                            
                                


                            <div class="form-group">
                                <label>Username </label>
                                <input type="text" class="form-control" v-model="post.username" @keydown.space.prevent >
                                <div v-if="validation.username">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.username[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nama </label>
                                <input type="text" class="form-control" v-model="post.name"
                                       placeholder="Masukkan Nama">
                                <div v-if="validation.name">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.name[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" v-model="post.email"
                                       placeholder="Email">
                                <div v-if="validation.email">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.email[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" v-model="post.password"
                                       placeholder="Password">
                                <div v-if="validation.password">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.password[0] }}
                                    </div>
                                </div>
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
                                <button type="submit" class="btn btn-md btn-success">SIMPAN</button>
                                <router-link :to="{ name: 'user' }" class="btn btn-primary btn-success">KEMBALI</router-link>

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
            }
        },
        
        created: function(){
            //this.loadUsername()
        },
        methods: {
            
            PostStore() {
                let uri = '/api/user/store';
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({
                            name: 'user'
                        });
                        //this.loadKdMenu()
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },
            
        },
        
    }
</script>
