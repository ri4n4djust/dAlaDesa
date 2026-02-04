<template>
    <div class="mt-3">

        
       <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><img v-bind:src="image_src" class="img-fluid img-thumbnail" width="200"></p>
   
    <p class="login-box-msg">Sign in to start your session </p>

    <form @submit.prevent="postLogin">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" v-model="post.username" placeholder="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" v-model="post.password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
 
    
    </div>

    </div>   
  
  
</template>


<script>
//import foto1 from '../image/logo.png';
  export default {
        data() {
            return {
                username: '',
                password: '',
                post: {},
                image_src: '/image/logo.png',

            }
        },

       watch: {
          post: function() {
            this.$emit('input', this.post);
          }
        },
        //props: ['value'],
        props: ['optionLabel', 'value'],

        methods: {
            postLogin(){
                let uri = '/api/login';
                this.axios.post(uri, this.post).then(response => {
                  if (response.data.success === true ) {
                    this.$session.start()
                    this.$session.set('user', response.data.data.name)
                    this.$session.set('userId', response.data.data.id)
                    this.$session.set('roleID', response.data.data.role)
                    //Vue.http.headers.common['Authorization'] = 'Bearer ' + response.body.token
                    // this.$swal('suskes Login');

                    this.$swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Successfuly Login',
                      showConfirmButton: false,
                      timer: 1500
                    })
                    // alert('suskes Login')
                    //if (response.data.role == 'Admin' ) {
                      //router.push({ name: 'barang' });
                      //window.location.href = "/barang"
                    //}else if (response.data.role == 'Kasir' ){
                      //router.push({ name: 'meja' });
                      //window.location.href = "/meja"
                    //}else if (response.data.role == 'Operator' ){
                      //router.push({ name: 'barang' });
                      //window.location.href = "/barang"
                    //}
                    window.location.href = "/dashboard"
                  } else {
                    alert('username Atau Password Salah')
                  }
                
            }).catch(error => {
                    alert('username Atau Password Salah');
                });
            },
            
        },
        
    }
</script>
