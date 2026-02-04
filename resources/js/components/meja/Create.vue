<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">TAMBAH MEJA</div>

                    <div class="card-body">

                        <form @submit.prevent="PostStore">

                            <div class="form-group">
                                <label>No. Meja</label>
                                <input type="text" class="form-control" v-model="post.noMeja"
                                       placeholder="No Meja" required>
                                <div v-if="validation.noMeja">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.noMeja[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pax</label>
                                <input type="text" class="form-control" v-model="post.paxMeja"
                                       placeholder="PAX">
                                <div v-if="validation.paxMeja">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.paxMeja[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">SIMPAN</button>
                                <button type="reset" class="btn btn-md btn-danger">RESET</button>
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
                validation: []
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        methods: {
            
            PostStore() {
                let uri = '/api/meja/store';
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({
                            name: 'meja'
                        });
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            }
        }
    }
</script>
