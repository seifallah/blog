<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Blog Component</div>

                    <div class="card-body">
                    </div>
                </div>

                <button @click="create()">Add</button>
            </div>
        </div>
    </div>
</template>

<script>

  function Post({ id, title, content}) {
    this.id = id;
    this.title = title;
    this.content = content;
  }
  import BlogComponent from './BlogComponent.vue';


    export default {
        mounted() {
            console.log('MainComponent mounted.');
            this.posts = this.read();
        },
        data() {
            return {
                posts : []
            }
        },
        methods: {
              create() {
                window.axios.post('api/post').then(({ data }) => {
                  this.posts.push(new Post(data));
                });
              },
              read() {
                window.axios.get('api/posts').then(({ data }) => {
                    console.log(data)
                });
              },
              update(id) {
                window.axios.put(`api/post/${id}`, 
                    { }
                ).then(() => {
                  // Once AJAX resolves we can update the Crud with the new color
                  //this.posts.find(post => post.id === id).color = color;
                });

              },
              del(id) {
                window.axios.delete(`api/post/${id}`).then(() => {
                  let index = this.posts.findIndex(post => post.id === id);
                  this.posts.splice(index, 1);
                });
              },
        },
        components: {
          BlogComponent
        }
    }
</script>
