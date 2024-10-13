<template>
  <div class="container">
    <form @submit.prevent="update()" enctype="multipart/form-data">
     <div class="col-4 m-auto">
        <div class="d-flex justify-content-center">
          <img :src="imagePreview" width="100" height="100" alt="Profile">
        </div>
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
          <select class="form-control" name="user_type" v-model="user_type">
            <option value="" disabled>Please Select User Type</option>
            <option value="Admin">Admin</option>
            <option value="User">User</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Profile</label>
          <input type="file" class="form-control" @change="onChange"> 
        </div>
        <button class="btn btn-primary mt-3" type="submit">Update</button>
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
      },
      user_type: '',
      imagePreview: null,
      errors: [],
      errorMessage: false
    }
  },

  methods: {
    onChange(e){
      this.user.image = e.target.files[0]
      let reader = new FileReader
      reader.addEventListener('load', function(){
        this.imagePreview = reader.result
      }.bind(this), false)
      if(this.user.image){
        reader.readAsDataURL(this.user.image)
      }
    },
    update(){
      let formData = new FormData();
      formData.append('id', this.user.id)
      formData.append('name', this.user.name)
      formData.append('email', this.user.email)
      formData.append('image', this.user.image)
      formData.append('user_type', this.user_type)
      axios.post(`/api/user-update/${this.user.id}`, formData)
      .then(response => {
        this.$router.push({name: 'UserIndex'})
        this.errorMessage = false
        Toast.fire({ icon: 'success', title: 'Updated successfully'})
      })
      .catch(error => { 
        this.errors = error.response.data.errors
        this.errorMessage = true
      })
    }
  },

  created(){
    this.user.id = this.$route.params.id
    axios.get(`/api/users/${this.user.id}`)
    .then(response => {
      this.user = response.data
      this.imagePreview = this.user.image
    })
    .catch(error => console.log(error))
  }
}
</script>

<style>

</style>
