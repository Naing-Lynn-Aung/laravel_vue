<template>
  <div class="container" v-if="user.user_type == 0">
    <router-link :to="{ name: 'UserCreate' }" class="btn btn-primary">Create User</router-link>
    <table class="table mt-5">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>User Type</th>
        <th>Profile</th>
        <th>Action</th>
      </tr>
      <tr v-for="user in users" :key="user.id">
        <td>{{ user.id }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.user_type == 0 ? 'Admin' : 'User' }}</td>
        <td>
          <img :src="user.image" width="70" height="70" alt="Profile">
        </td>
        <td>
          <router-link :to="'/users/edit/'+user.id" class="btn btn-sm btn-secondary text-dark">Edit</router-link>
          <button class="btn btn-sm btn-danger text-dark ms-1" @click="destroy(user.id)">Delete</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  data(){
    return {
      users: [],
      user: {
        id: '',
        name: '',
        email: '',
        image: '',
        user_type: ''
      },
    }
  },
  created(){
    this.getUser()
  },
  mounted(){
    this.user.user_type = window.user_type
    if(this.user.user_type != 0){
      this.$router.push('/error')
    }
  },
  methods: {
    getUser(){
      axios.get('/api/users')
      .then(response => {
        this.users = response.data
      })
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
          axios.delete('/api/users/'+ id)
          .then(response =>{
            this.getUser()
            Swal.fire({ title: 'Deleted', icon: 'success' })
            Toast.fire({ icon: 'success', title: 'Deleted successfully'})
          })
        }
      })
    }
  }
}
</script>

<style>

</style>
