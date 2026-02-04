<template>


                    <div class="card-body">
                        <status-login></status-login>
                        
                        <h3>
                        <router-link :to="{ name: 'createMenu' }" class="btn btn-md btn-success">TAMBAH MENU</router-link>
                        </h3>
                            
                            <div>
                                
                                <data-table v-bind="bindings" @actionTriggered="ActionButtons"/>
                                
                            </div>

                            
                        </div>

                

</template>


<script>
import Vue from 'vue';
import DataTable from "@andresouzaabreu/vue-data-table";

import ActionButtons from './componentAksi.vue';
Vue.component("data-table", DataTable);

    export default {
        data() {
            return {
                posts: [],
                ActionButtons: '',
            }
        },
        computed: {
            bindings() {
                return {
                    actionMode: "multiple",
                    name: "ActionButtons",
                    columns: [
                        {
                            key: "kdMenu",
                        },
                        {
                            key: "nmMenu",
                            title: "Nama Menu",
                            sortable: false,
                        },
                        {
                            key: "nmKtgMenu",
                            title: "Kategori",
                            sortable: false,
                        },
                        {
                            key: 'hppMenu',
                            title: "Harga Pokok",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            key: "hargaMenu",
                            title: "Harga Jual",
                            sortable: false,
                            searchable: false,
                        },
                        {
                            title: "Action",
                            sortable: false,
                            searchable: false,
                            /* this will make this column appear to the right of the table
                            since its index is greater than others*/
                            
                            component: ActionButtons,
                            index:100,
                        },
                        
                    ],
                    data: this.posts,
                    /* other props...*/
                    
                }
            }
        },
        created() {
            let uri = '/api/menu';
            this.axios.get(uri).then(response => {
                this.posts = response.data.data;
            });
        },
        beforeCreate: function () {
            if (!this.$session.exists()) {
            this.$router.push('/')
            }
        },
        methods: {

           
            PostDelete(id, index)
            {
            if(confirm("Do you really want to delete?")){
                this.axios.delete(`/api/menu/${id}`)
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