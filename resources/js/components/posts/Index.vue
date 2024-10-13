<template>
  <div class="container">
    <div class="d-flex justify-content-between">
      <router-link :to="{ name: 'PostCreate' }" class="btn btn-primary">Add Post</router-link>

      <div class="float-end col-4 d-flex" @keyup="searchPost" style="margin-right: 200px;">
        <button class="btn btn-primary me-3" @click="importFile">Import</button>
        <a :href="url" class="btn btn-dark me-3" @click="download">Download</a>
        <input type="search" class="form-control search" v-model="search" placeholder="Search Title ... ">
      </div> 
    </div>
    <table class="table mt-5">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
      <tr v-for="post in posts" :key="post.id">
        <td>{{ post.id }}</td>
        <td>{{ post.title }}</td>
        <td>{{ post.description }}</td>
        <td>
          <img :src="post.image" alt="" width="70" height="70">
        </td>
        <td>
          <router-link :to="'/posts/edit/'+post.id" class="btn btn-sm btn-secondary text-dark">Edit</router-link>
          <button class="btn btn-sm btn-danger text-dark ms-1" @click="destroy(post.id)">Delete</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  data(){
    return {
      posts: [],
      search: '',
      post: {
        id: '',
        title: '',
        description: '',
        image: ''
      },
      url: '',
    }
  },
  created(){
    this.getPost()
  },
  methods: {
    searchPost(){
      axios.get('/api/posts/?search='+ this.search)
      .then(response => this.posts = response.data)
    },

    importFile(){
      Swal.fire({
        title: 'Import File',
        html: `
        <form enctype="multipart/form-data" id="postCsv">
          <input type="file" name="import" class="form-control">
        </form>
        `,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Import'
      }).then((result) => {
        if (result.isConfirmed) {
          let postCsv = document.getElementById('postCsv');
          let formData = new FormData(postCsv);
          axios.post('/api/import', formData)
          .then(response =>{
            this.$router.push({ name: "PostIndex" });
            this.posts = response.data
          })
          Toast.fire({ icon: 'success', title: 'Import successfully'})
        }
      })
    },
    
    download(){
      this.url = "/api/export";
    },

    getPost(){
      axios.get('/api/posts')
        .then(response => this.posts = response.data)
    },
    destroy(id){
      Swal.fire({
      title: 'Are you sure to Delete?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete('/api/posts/'+ id)
        .then(response =>{
          this.getPost()
          Swal.fire({ title: 'Deleted', icon: 'success' })
          Toast.fire({ icon: 'success', title: 'Deleted successfully'})
        })
      }
    })
      
    },
    edit(id){
      axios.get('/api/posts/'+ id)
          .then(response => {
            this.post = response.data
            this.$router.push({name: 'PostEdit'})
          })
    },
  },
  
}
</script>

<style>
  /* .float-end {
    margin-right: 145px;
  } */
  .swal2-styled{
    font-size: 14px!important;
  }
</style>
