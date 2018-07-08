<template>
    <div class=" row blog">
        <div class="col-12">
          <h2 class="bg-info p-2 text-center">Welcome to Our Blog Demo</h2>
        </div>
        <div class="col-4">
          <form class="col-3" @submit.prevent="saveMethod()" style="position:fixed;">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" required="required" placeholder="" v-model="post.title">
            </div>
            <div class="form-group">
              <label for="post-content">Content</label>
              <textarea class="form-control" required="required" rows="10" v-model="post.content"></textarea>
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-info">Save</button>
            </div>
          </form>
        </div>  
        <div class="col-8">
          <div  v-if="posts.length == 0" class="alert alert-primary mt-3" role="alert">
            No Posts Yet !
          </div>
            <div class="card-body" v-else>
                <ul class="list-group">
                    <li class="list-group-item mb-2" v-for="post in posts" v-bind:key="post.id">
                        <h3> {{post.title}} </h3>
                        <p>{{post.content}}</p>
                        <div>
                            <button class="btn btn-success float-left" @click="edit(post)">edit</button>
                            <button class="btn btn-danger float-right" @click="del(post.id)">delete</button>
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
                },
                 editAction: false,
                 post_id:"",
            }
        },
        methods: {
              create() {
                window.axios.post('api/post', this.post) 
          .then(() => {
            console.log("created");
             this.emptyAction();
          //  this.posts.push(this.post);
           this.read();

          })

              },

              read() {
                window.axios.get('api/posts')
                .then(({ data }) => {
                   // console.log(data.data);
                    this.posts = data.data;
                });
              },

              saveMethod() {
                if(this.editAction === false) {
                  this.create();
                }
                else {
                  this.update();
                }
              },
              edit(post) {
                this.emptyAction();

                this.editAction = true;
                this.post.title = post.title;
                this.post.content = post.content;
                console.log("id post"+post.id);
                this.post_id = post.id;

              },

              update() {
                  console.log("updated", this.post_id);
                
                window.axios.put('api/post/'+this.post_id, this.post 
                ).then(() => {
                  console.log("updated");
                  this.read();
                  this.emptyAction();
                  this.editAction = false;
                });

              },
              del(id) {
          
                window.axios.delete(`api/post/del/${id}`).then(() => {
                  let index = this.posts.findIndex(post => post.id === id);
                  this.posts.splice(index, 1);
                  console.log("remvoed");
                });
              },

              emptyAction() {
                this.post.title = "";
                this.post.content = "";
              },
        }
    }
</script>
