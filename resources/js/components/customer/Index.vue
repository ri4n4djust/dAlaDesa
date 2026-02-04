<template>



                    <div class="card-body">
                        <status-login></status-login>
                        <h3>
                        <router-link :to="{ name: 'createPelanggan' }" class="btn btn-md btn-success">TAMBAH Pelanggan</router-link>
                        </h3>
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Kode </th>
                                    <th>Nama</th>
                                    <th>Alamat </th>
                                    <th>No. HP</th>
                                    <th>AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(post, index) in posts" :key="post.id">
                                    <td>{{ post.kdPelanggan }}</td>
                                    <td>{{ post.nmPelanggan }}</td>
                                    <td>{{ post.almtPelanggan }}</td>
                                    <td>{{ post.noHpPelanggan }}</td>
                                    <td class="text-center">
                                        <router-link :to="{name: 'editPelanggan', params: { id: post.id }}" class="btn btn-sm btn-primary">EDIT</router-link>
                                        <button @click.prevent="PostDelete(post.id, index)" class="btn btn-sm btn-danger">HAPUS</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                

</template>
<script>
    export default {
        data() {
            return {
                posts: []
            }
        },
        created() {
            let uri = '/api/pelanggan';
            this.axios.get(uri).then(response => {
                this.posts = response.data.data;
            });
        }
    }
</script>


<script>
    export default {
        data() {
            return {
                posts: []
            }
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        created() {
            let uri = '/api/pelanggan';
            this.axios.get(uri).then(response => {
                this.posts = response.data.data;
            });
        },
        methods: {
            PostDelete(id, index)
            {
                if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/pelanggan/${id}`)
                    .then(response => {
                        this.posts.splice(index, 1);
                    }).catch(error => {
                    alert('system error!');
                });
                }
            }
        }
    }
</script>