<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">EDIT SUPPLIER</div>

                    <div class="card-body">

                        <form @submit.prevent="PostUpdate">

                            <div class="form-group">
                                <label>Nama Spplier</label>
                                <input type="text" class="form-control" v-model="post.nmSupplier"
                                       placeholder="Masukkan Nama Supplier">
                                <div v-if="validation.nmSupplier">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.nmSupplier[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat Supplier</label>
                                <input type="text" class="form-control" v-model="post.almtSupplier"
                                       placeholder="Alamat Supplier">
                                <div v-if="validation.almtSupplier">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.almtSupplier[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" class="form-control" v-model="post.noHp"
                                       placeholder="No HP">
                                <div v-if="validation.noHp">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.noHp[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kontak Person</label>
                                <input type="text" class="form-control" v-model="post.kontakSupplier"
                                       placeholder="Kontak Supplier">
                                <div v-if="validation.kontakSupplier">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.kontakSupplier[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">UPDATE</button>
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
        created() {
            let uri = `/api/supplier/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
            });
        },
        methods: {
            PostUpdate() {
                let uri = `/api/supplier/update/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({name: 'supplier'});
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            }
        }
    }
</script>
