<template>
    <div class="blog">
<form class="" @submit.prevent="create">
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title"  placeholder="text goes here" v-model="post.title">
  </div>

  <div class="form-group">
    <label for="post-content">Content</label>
    <textarea class="form-control" id="post-content" rows="3" v-model="post.content"></textarea>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-info">Add</button>
  </div>
</form>

        <hr>
        <div class="card-header">Blog Component</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item" v-for="post in posts" v-bind:key="post.id">
                        <h3> {{post.title}} </h3>
                        <p>{{post.content}}</p>
                        <div>
                            <span class="float-left">edit</span>
                            <span class="float-right" @click="del(post.id)">delete</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('BlogComponent mounted.');
           this.read();
        },
        data() {
            return {
                posts : [],
                post : {
                    id :'',
                    title:'',
                    content:''
                }
            }
        },
        methods: {
              create() {
                window.axios.post('api/post', this.post) 
          .then(() => {
            console.log("added");
            
          //  this.posts.push(this.post);

           this.read();

          })

              },
              read() {
                window.axios.get('api/posts')
                .then(({ data }) => {
                    console.log(data.data);
                    this.posts = data.data;
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
                var datass        = {
                  '__method': "delete",
                  '_token': window.Laravel.csrfToken
                }; 


                window.axios.delete(`api/post/del/${id}`).then(() => {
                  let index = this.posts.findIndex(post => post.id === id);
                  this.posts.splice(index, 1);
                  console.log("remvoed");
                });
              },
        }
    }
</script>
