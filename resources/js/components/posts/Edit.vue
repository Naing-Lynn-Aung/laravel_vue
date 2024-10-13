<template>
  <div class="container">
    <h3 class="text-center">Edit Post</h3>
    <form @submit.prevent="update()" enctype="multipart/form-data">
      <div class="col-4 m-auto">
        <div class="form-group">
          <label>Title : </label>
          <input type="text" v-model="post.title" class="form-control" />
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.title" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label>Description : </label>
          <textarea v-model="post.description" class="form-control"></textarea>
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.description" :key="error" >{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label>Image :</label>
          <input type="file" class="form-control mb-3" @change="onChange" name="image" accept="image/*" />
          <img :src="imagePreview" width="100" height="100" />
        </div>
        <button class="btn btn-primary mt-3" type="submit">Update</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
    data() {
        return {
            post: {
                id: "",
                title: "",
                description: "",
                image: "",
            },
            errorMessage: false,
            errors: [],
            imagePreview: null,
        };
    },
    methods: {
        update() {
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };
            let formData = new FormData();
            formData.append("id", this.post.id);
            formData.append("title", this.post.title);
            formData.append("description", this.post.description);
            formData.append("image", this.post.image);

            axios.post(`/api/post-update/${this.post.id}`, formData, config)
                .then((response) => {
                    this.$router.push({ name: "PostIndex" });
                    this.errorMessage = false;
                    Toast.fire({ icon: 'success', title: 'Updated successfully'})
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.errorMessage = true;
                });
        },

        onChange(e) {
            this.post.image = e.target.files[0];
            let reader = new FileReader();
            reader.addEventListener("load",
                function () {
                    this.imagePreview = reader.result;
                }.bind(this),false);
            if (this.post.image) {
                reader.readAsDataURL(this.post.image);
            }
        },
    },
    created() {
        this.post.id = this.$route.params.id;
        axios.get("/api/posts/" + this.post.id).then((response) => {
            this.post = response.data;
            this.imagePreview = this.post.image;
        });
    },
};
</script>

<style>
</style>
