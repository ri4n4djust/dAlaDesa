<template>
    <div >
        <button class="btn btn-outline-primary" @click="DetailAction('editMenu')" >
            <i class="fa fa-edit"></i>
        </button>
    </div>
</template>
<script>
export default {
    name: "ActionButtons",
    data() {
            return {
                posts: [],
                //pem: [],
                showModalDetail: false,
                //data: this.posts,
                qtyGudang: '',
                keterangan: '',
                tglOpname: new Date().toJSON().slice(0,10).replace(/-/g,'/'),
            }

        },
    created() {
            this.loadData()
            //this.something()
            //this.loadDetailStok()
            //this.DetailAction()
        },
    methods: {

            loadData:function() {
            let uri = '/api/menu';
            this.axios.get(uri).then(response => {
                this.posts = response.data.data;
            });
            },

            DetailAction() {
                const path = '/menu/edit/' + this.data.kdMenu;
                this.$router.push(path)
                //alert('edit' + this.data.id)
                //this.$store.commit(edit, this.data)
            },
            
            PostStokOpname:function(){
                let uri = '/api/posthasilopname/';
                this.axios.post(uri, {
                    kdBarang: this.data.kdBarang,
                    tglOpname: this.tglOpname
                }).then((response) => {
                    this.loadDetailStok()
                    alert('input Opname Berhasil')

                });
            }
            
            
        },
    props: {
        data: {
            type: Object,
            required: true,
        },
    },
};
</script>