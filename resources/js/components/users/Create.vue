<template>
  <div class="container">
    
    <form @submit.prevent="store()" enctype="multipart/form-data">
      <div class="col-4 m-auto">
        <div class="d-flex justify-content-center">
          <img :src="imagePreview" width="100" height="100" alt="Profile">
        </div>
        <input type="hidden" v-model="user.created_user_id">
        <div class="form-group">
          <label for="">Name</label>
          <input type="text" class="form-control" v-model="user.name">
          <div v-if="errorMessage">
            <p v-for="error in errors.name" :key="error" class="alert alert-danger">{{ error }}</p>
          </div>
        </div>
        <div class="form-group">
          <label for="">Email</label>
          <input type="email" class="form-control" v-model="user.email">
          <div v-if="errorMessage">
            <p v-for="error in errors.email" :key="error" class="alert alert-danger">{{ error }}</p>
          </div>
        </div>
        <div class="form-group">
          <label for="">User Type</label>
          <select v-model="user.user_type" class="form-control">
            <option value="" disabled>Please Select User Type</option>
            <option value="User" selected>User</option>
            <option value="Admin">Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Password</label>
          <input type="password" class="form-control" v-model="user.password">
          <div v-if="errorMessage">
            <p v-for="error in errors.password" :key="error" class="alert alert-danger">{{ error }}</p>
          </div>
        </div>
        <div class="form-group">
          <label for="">Confirm Password</label>
          <input type="password" class="form-control" v-model="user.confirm_password">
          <div v-if="errorMessage">
            <p v-for="error in errors.confirm_password" :key="error" class="alert alert-danger">{{ error }}</p>
          </div>
        </div>
        <div class="form-group">
          <label for="">Profile</label>
          <input type="file" class="form-control" @change="onChange" name="image"> 
        </div>
        <button class="btn btn-primary mt-3" type="submit">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data(){
    return {
      user: {
        id: '',
        name: '',
        email: '',
        image: '',
        password: '',
        confirm_password: '',
        created_user_id: '',
        user_type: ''
      },
      errors: [],
      errorMessage: false,
      imagePreview: '/images/profile.png'
    }
  },
  methods: {
    store(){
      let formData = new FormData();
      formData.append('id', this.user.id)
      formData.append('name', this.user.name)
      formData.append('email', this.user.email)
      formData.append('password', this.user.password)
      formData.append('confirm_password', this.user.confirm_password)
      formData.append('image', this.user.image)
      formData.append('created_user_id', this.user.created_user_id)
      formData.append('user_type', this.user.user_type)
      axios.post('/api/users', formData)
      .then(response => {
        this.$router.push({name: 'UserIndex'})
        this.errorMessage = false
        Toast.fire({ icon: 'success', title: 'Created successfully'})
      })
      .catch(error => {
       this.errors = error.response.data.errors;
       this.errorMessage = true
      })
    },
    onChange(e){
      this.user.image = e.target.files[0];
      let reader = new FileReader();
      reader.addEventListener('load', function(){
        this.showPreview = true
        this.imagePreview = reader.result
      }.bind(this), false)
      if(this.user.image){
        reader.readAsDataURL(this.user.image)
      }
    }
  },
  mounted(){
    axios.get('/api/user_id')
    .then(response => {
      this.user.created_user_id = response.data
      })
  }
}
</script>

<style>

</style>
