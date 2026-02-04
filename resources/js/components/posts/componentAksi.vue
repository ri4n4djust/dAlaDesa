<template>
    <div >
        <button class="btn btn-outline-success" @click="showModalDetail = true">
            <i class="fa fa-eye"></i>
        </button>
        <button class="btn btn-outline-primary" @click="EditAction('edit')" >
            <i class="fa fa-edit"></i>
        </button>
                        
                        <div v-if="showModalDetail">
                            <transition name="modal">
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" @click="showModalDetail=false">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Add Item</h4>
                                    </div>
                                    <div class="modal-body">

                                        detail

                                        {{data.id}} {{data.nmBarang}}
                                        

                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </transition>
                        </div>
        
       
    </div>
</template>
<script>
export default {
    name: "ActionButtons",
    data() {
            return {
                posts: [],
                showModalDetail: false,
                //data: this.posts,
            }

        },
    created() {
            let uri = '/api/posts';
            this.axios.get(uri).then(response => {
                this.posts = response.data.data;
            });
        },
    methods: {

            loadData:function(){
                let uri = '/api/posts';
                this.axios.get(uri).then(response => {
                this.posts = response.data.data;
                
            });
            },
            
            EditAction() {
                const path = '/barang/edit/' + this.data.id
                this.$router.push(path)
                //alert('edit' + this.data.id)
                //this.$store.commit(edit, this.data)
            },
            ViewAction() {
                alert('View' + this.data.id)
                //this.$store.commit(edit, this.data)
            },
            
        },
    props: {
        data: {
            type: Object,
            required: true,
        },
    },
};
</script>