<template>
    <div class="mt-3">
        <status-login></status-login>
                    <div class="card-header">EDIT MEJA</div>

                    <div class="card-body">

                        <form @submit.prevent="PostUpdate">

                            <div class="form-group">
                                <label>No Meja</label>
                                <input type="text" class="form-control" v-model="post.noMeja"
                                       placeholder="No Meja">
                                <div v-if="validation.noMeja">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.noMeja[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Max Accupannci</label>
                                <input type="text" class="form-control" v-model="post.paxMeja"
                                       placeholder="Accupanci">
                                <div v-if="validation.paxMeja">
                                    <div class="alert alert-danger mt-1" role="alert">
                                        {{ validation.paxMeja[0] }}
                                    </div>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success">UPDATE</button>
                                <span v-if="$session.get('roleID') === 'Admin'">
                                    <button @click.prevent="PostDelete(post.id)" class="btn btn-md btn-danger">HAPUS</button>
                                </span>
                                <router-link :to="{ name: 'meja' }" class="btn btn-primary btn-success">KEMBALI</router-link>
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
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            let uri = `/api/meja/edit/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.post = response.data.data;
            });
        },
        methods: {
            PostUpdate() {
                let uri = `/api/meja/update/${this.$route.params.id}`;
                this.axios.post(uri, this.post)
                    .then((response) => {
                        this.$router.push({name: 'meja'});
                    }).catch(error => {
                    this.validation = error.response.data.data;
                });
            },
            PostDelete(id)
            {
            if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/meja/${id}`)
                    .then(response => {
                        this.$router.push({name: 'meja'});
                    }).catch(error => {
                    alert('system error!');
                });
            }
            },
        }
    }
</script>
