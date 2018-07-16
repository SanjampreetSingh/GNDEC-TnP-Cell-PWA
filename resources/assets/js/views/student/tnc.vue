<template>
	<div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Terms and Conditions</h3>
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/task">Post</router-link></li>
                    <li class="breadcrumb-item active">Edit Post</li>
                </ol> -->
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Terms and Conditions</h4>
                        <!-- <post-form :id="id"></post-form> -->
                        <form method="post"  @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="checkbox" name="terms" required="required"> I Agree to the terms and conditions given above 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>
<script>
export default {
    methods:{
        submit(){
            axios.post(loginURL, this.loginForm).then(response => {
                        if (response.status == "200") {
                            // window.location = "/dashboard";
                            this.token = response.data.data.access_token;
                            axios.defaults.headers.common['Authorization'] = 'Bearer' + this.token;

                            toastr['success'](response.data.message);
                            this.authenticated = true;
                            // console.log(this.authenticated);
                            // this.$router.push('/login');
                            // this.$router.push('/home')

                        }
                    }).catch(error => {
                        console.log(error.response)
                        var obj = JSON.parse(error.response.request.responseText);
                        if (error.response.status == "401") {
                            toastr['error'](obj['message']);
                        }

                        if (error.response.status == "422") {
                            if (obj['errors'].hasOwnProperty('username')) {
                                toastr['error'](obj['errors']['username']);
                            }
                            if (obj['errors'].hasOwnProperty('password')) {
                                toastr['error'](obj['errors']['password']);
                            }
                        }
                    });
        }
    }
}
</script>
<style scoped>

</style>
