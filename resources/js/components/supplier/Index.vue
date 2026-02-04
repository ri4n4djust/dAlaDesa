<template>



                    <div class="card-body">
                        <status-login></status-login>
                        <h3>
                        <router-link :to="{ name: 'createSupplier' }" class="btn btn-md btn-success">TAMBAH SUPPLIER</router-link>
                        </h3>
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <th>Alamat Suuplier</th>
                                    <th>No. HP</th>
                                    <th>Kontak Person</th>
                                    <th>AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(post, index) in posts" :key="post.id">
                                    <td>{{ post.nmSupplier }}</td>
                                    <td>{{ post.almtSupplier }}</td>
                                    <td>{{ post.noHp }}</td>
                                    <td>{{ post.kontakSupplier }}</td>
                                    <td class="text-center">
                                        <router-link :to="{name: 'editSupplier', params: { id: post.id }}" class="btn btn-sm btn-primary">EDIT</router-link>
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
            let uri = 'http://localhost:8000/api/supplier';
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
            let uri = '/api/supplier';
            this.axios.get(uri).then(response => {
                this.posts = response.data.data;
            });
        },
        methods: {
            PostDelete(id, index)
            {
                this.axios.delete(`/api/supplier/${id}`)
                    .then(response => {
                        this.posts.splice(index, 1);
                    }).catch(error => {
                    alert('system error!');
                });
            }
        }
    }
</script>