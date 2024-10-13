<template>
    <div class="container">
      <nav class="navbar navbar-expand-lg bg-light mb-5" v-show="token">
        <div class="container-fluid">
          <h1>Laravel + VueJs</h1>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
              <li class="nav-item">
                <router-link :to="{ name: 'PostIndex' }" class="">Post List</router-link>
              </li>
              <li class="nav-item" v-if="user.user_type == '0'">
                <router-link :to="{ name: 'UserIndex' }" class="">User List</router-link>
              </li>
             
            </ul>
          </div>
          
          <router-link :to="'/users/edit/'+user.id" class="me-3 p-0 rounded-pill">
          <img :src="user.image" alt="" width="45" height="45" class="rounded-circle">
          {{ user.email }}</router-link>
          <button class="btn btn-danger" @click="logout">Logout</button>
        </div>
      </nav>
      <router-view />

    </div>
</template>

<script>

export default {
  data(){
    return {
      token: localStorage.getItem('token'),
      user: {
        id: '',
        name: '',
        email: '',
        image: '',
        user_type: ''
      }
    }
  },
  methods: {
    logout(){
      axios.post('/api/logout')
      .then(response => {
        window.location.reload()
        localStorage.clear()
        this.$router.push({ name: 'Login' })
      })
      .catch(error => console.log(error))
    },
  },
  mounted(){
    axios.get('/api/user')
    .then(response => {
      this.user = response.data
      })
  }
  
}
</script>

<style>

</style>
