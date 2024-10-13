<template>
  <div class="container">
    <h3 class="text-center">Create Post</h3>
    <form @submit.prevent="store()" enctype="multipart/form-data">
      <div class="col-4 m-auto">
        <div class="form-group">
          <label for="">Title : </label>
          <input type="text" v-model="post.title" class="form-control">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.title" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label for="">Description : </label>
          <textarea v-model="post.description" class="form-control"></textarea>
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.description" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label>Image : </label>
          <input type="file" class="form-control mb-3" @change="onChange">
          <img :src="imagePreview" width="100" height="100" v-show="showPreview"/> 
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
      post: {
        id: '',
        title: '',
        description: '',
        image: ''
      },
      errorMessage: false,
      errors: [],
      imagePreview: null,
      showPreview: false,
    }
  },
  methods: {
    store(){
      let formData = new FormData();
      formData.append('id', this.post.id);
      formData.append('title', this.post.title);
      formData.append('description', this.post.description);
      formData.append('image', this.post.image);
      
      axios.post('/api/posts', formData)
        .then(response => {
            this.$router.push({ name: 'PostIndex' })
            this.errorMessage = false
            Toast.fire({ icon: 'success', title: 'Created successfully'})
        })
        .catch(error => {
            this.errors = error.response.data.errors
            this.errorMessage = true
        })
    },
    onChange(e){
      this.post.image = e.target.files[0];
      let reader = new FileReader();
      reader.addEventListener('load', function(){
        this.showPreview = true;
        this.imagePreview = reader.result;
      }.bind(this), false)
      if(this.post.image){
        reader.readAsDataURL(this.post.image);
      }
    }
  }
}
</script>

<style>

</style>
