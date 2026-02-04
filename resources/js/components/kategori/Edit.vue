<template>
    <div class="mt-3">
        <status-login></status-login>
        <h3>
                    <div class="card-header">EDIT KATEGORI</div>
        </h3>
                    <div class="card-body">

                        <form @submit.prevent="PostUpdate">

                            <div class="form-group">
                                <label>Kode Kategori</label>
                                <input type="text" class="form-control" v-model="post.kodeKtg" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" class="form-control" v-model="post.namaKtg"
                                       placeholder="Alamat Supplier">
                                <div v-if="validation.namaKtg">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.namaKtg[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">UPDATE</button>
                                <button type="reset" class="btn btn-md btn-danger">RESET</button>
                                <router-link :to="{ name: 'kategori' }" class="btn btn-primary btn-success">KEMBALI</router-link>
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
        created() {
            let uri = `/api/kategori/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
            });
        },
        methods: {
            PostUpdate() {
                let uri = `/api/kategori/update/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({name: 'kategori'});
                        this.$swal('suskes Edit');
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            }
        }
    }
</script>
