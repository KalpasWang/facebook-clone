<template>
  <div class="bg-white rounded shadow w-full max-w-md mt-6">
    <div class="flex flex-col p-2">
      <div class="flex items-center">
        <div>
          <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="user image" class="w-10 h-10 object-cover rounded-full align-middle mr-2">
        </div>
        <div>
          <div class="text-sm font-bold">{{ post.data.attributes.posted_by.data.attributes.name }}</div>
          <div class="text-xs text-gray-600">{{ post.data.attributes.posted_at }}</div>
        </div>
      </div>
      <div class="mt-4">
        {{ post.data.attributes.body }}
      </div>
    </div>

    <div v-if="post.data.attributes.image" class="w-full">
      <img :src="post.data.attributes.image" alt="post image" class="w-full">
    </div>

    <div class="px-2 pt-2 flex justify-between text-gray-700 text-sm">
      <div>
        <div v-if="post.data.attributes.likes.likes_count > 0" class="flex">
          <svg width="18" height="18" xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 16 16'><defs><linearGradient id='a' x1='50%' x2='50%' y1='0%' y2='100%'><stop offset='0%' stop-color='#18AFFF'/><stop offset='100%' stop-color='#0062DF'/></linearGradient><filter id='c' width='118.8%' height='118.8%' x='-9.4%' y='-9.4%' filterUnits='objectBoundingBox'><feGaussianBlur in='SourceAlpha' result='shadowBlurInner1' stdDeviation='1'/><feOffset dy='-1' in='shadowBlurInner1' result='shadowOffsetInner1'/><feComposite in='shadowOffsetInner1' in2='SourceAlpha' k2='-1' k3='1' operator='arithmetic' result='shadowInnerInner1'/><feColorMatrix in='shadowInnerInner1' values='0 0 0 0 0 0 0 0 0 0.299356041 0 0 0 0 0.681187726 0 0 0 0.3495684 0'/></filter><path id='b' d='M8 0a8 8 0 00-8 8 8 8 0 1016 0 8 8 0 00-8-8z'/></defs><g fill='none'><use fill='url(#a)' xlink:href='#b'/><use fill='black' filter='url(#c)' xlink:href='#b'/><path fill='white' d='M12.162 7.338c.176.123.338.245.338.674 0 .43-.229.604-.474.725a.73.73 0 01.089.546c-.077.344-.392.611-.672.69.121.194.159.385.015.62-.185.295-.346.407-1.058.407H7.5c-.988 0-1.5-.546-1.5-1V7.665c0-1.23 1.467-2.275 1.467-3.13L7.361 3.47c-.005-.065.008-.224.058-.27.08-.079.301-.2.635-.2.218 0 .363.041.534.123.581.277.732.978.732 1.542 0 .271-.414 1.083-.47 1.364 0 0 .867-.192 1.879-.199 1.061-.006 1.749.19 1.749.842 0 .261-.219.523-.316.666zM3.6 7h.8a.6.6 0 01.6.6v3.8a.6.6 0 01-.6.6h-.8a.6.6 0 01-.6-.6V7.6a.6.6 0 01.6-.6z'/></g></svg>
          <p class="ml-2">{{ post.data.attributes.likes.likes_count }}</p>
        </div>
      </div>
      <div>
          <p v-if="post.data.attributes.comments.comments_count > 0" 
             class="cursor-pointer hover:underline" @click="showComments"
           >
            {{ post.data.attributes.comments.comments_count }} 則留言
          </p>
      </div>
    </div>

    <div class="flex justify-between pt-1 m-2 border-t border-gray-400">
      <button class="flex justify-center py-1 rounded-lg text-sm text-gray-700 w-full hover:bg-gray-200 focus:outline-none" @click="clickLikeBtn">
        <i v-if="toggleUserLikes" class="fas fa-thumbs-up text-blue-500 w-5 h-5 text-xl"></i>
        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5"><path d="M20.8 15.6c.4-.5.6-1.1.6-1.7 0-.6-.3-1.1-.5-1.4.3-.7.4-1.7-.5-2.6-.7-.6-1.8-.9-3.4-.8-1.1.1-2 .3-2.1.3-.2 0-.4.1-.7.1 0-.3 0-.9.5-2.4.6-1.8.6-3.1-.1-4.1-.7-1-1.8-1-2.1-1-.3 0-.6.1-.8.4-.5.5-.4 1.5-.4 2-.4 1.5-2 5.1-3.3 6.1l-.1.1c-.4.4-.6.8-.8 1.2-.2-.1-.5-.2-.8-.2H3.7c-1 0-1.7.8-1.7 1.7v6.8c0 1 .8 1.7 1.7 1.7h2.5c.4 0 .7-.1 1-.3l1 .1c.2 0 2.8.4 5.6.3.5 0 1 .1 1.4.1.7 0 1.4-.1 1.9-.2 1.3-.3 2.2-.8 2.6-1.6.3-.6.3-1.2.3-1.6.8-.8 1-1.6.9-2.2.1-.3 0-.6-.1-.8zM3.7 20.7c-.3 0-.6-.3-.6-.6v-6.8c0-.3.3-.6.6-.6h2.5c.3 0 .6.3.6.6v6.8c0 .3-.3.6-.6.6H3.7zm16.1-5.6c-.2.2-.2.5-.1.7 0 0 .2.3.2.7 0 .5-.2 1-.8 1.4-.2.2-.3.4-.2.6 0 0 .2.6-.1 1.1-.3.5-.9.9-1.8 1.1-.8.2-1.8.2-3 .1h-.1c-2.7.1-5.4-.3-5.4-.3H8v-7.2c0-.2 0-.4-.1-.5.1-.3.3-.9.8-1.4 1.9-1.5 3.7-6.5 3.8-6.7v-.3c-.1-.5 0-1 .1-1.2.2 0 .8.1 1.2.6.4.6.4 1.6-.1 3-.7 2.1-.7 3.2-.2 3.7.3.2.6.3.9.2.3-.1.5-.1.7-.1h.1c1.3-.3 3.6-.5 4.4.3.7.6.2 1.4.1 1.5-.2.2-.1.5.1.7 0 0 .4.4.5 1 0 .3-.2.6-.5 1z"/></svg>
        <p :class="['ml-2', { 'text-blue-500': toggleUserLikes }]">讚</p>
      </button>
      <button class="flex justify-center py-1 rounded-lg text-sm text-gray-700 w-full hover:bg-gray-200 focus:outline-none" @click="showComments">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5"><path d="M20.3 2H3.7C2 2 .6 3.4.6 5.2v10.1c0 1.7 1.4 3.1 3.1 3.1V23l6.6-4.6h9.9c1.7 0 3.1-1.4 3.1-3.1V5.2c.1-1.8-1.3-3.2-3-3.2zm1.8 13.3c0 1-.8 1.8-1.8 1.8H9.9L5 20.4V17H3.7c-1 0-1.8-.8-1.8-1.8v-10c0-1 .8-1.8 1.8-1.8h16.5c1 0 1.8.8 1.8 1.8v10.1zM6.7 6.7h10.6V8H6.7V6.7zm0 2.9h10.6v1.3H6.7V9.6zm0 2.8h10.6v1.3H6.7v-1.3z"/></svg>
        <p class="ml-2">留言</p>
      </button>
    </div>

    <div v-if="isShowComments" class="border-t border-gray-400 my-1 mx-2">
      <div class="my-2 flex items-start">
        <div class="w-8 mr-2">
          <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="user image" class="w-8 h-8 object-cover rounded-full align-middle">
        </div>
        <textarea ref="newComment" rows="1" class="resize-none text-sm bg-gray-200 rounded-lg px-4 py-2 w-full focus:outline-none" placeholder="留言…" @keydown="handleNewComment"></textarea>
      </div>
      <div class="flex my-2 items-start" v-for="comment in commentsData" :key="comment.comment_id">
        <div class="w-8 mr-2">
          <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="user image" class="w-8 h-8 object-cover rounded-full align-middle">
        </div>
        <div class="w-full flex-initial rounded-lg bg-gray-200 p-2">
          <p class="text-sm font-bold">{{ comment.data.attributes.commented_by.data.attributes.name }}</p>
          <p class="text-sm whitespace-pre-line">{{ comment.data.attributes.body }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: "Post",
  data() {
    return {
      toggleUserLikes: false,
      isShowComments: false,
    }
  },
  props: ['post'],
  computed: {
    ...mapGetters(['authUser']),
    isUserLikes() {
      return this.post.data.attributes.likes.user_likes_post;
    }, 
    commentsData() {
      return this.post.data.attributes.comments.data;
    }
  },
  methods: {
    clickLikeBtn() {
      this.toggleUserLikes = !this.toggleUserLikes;
      this.$store.dispatch('userClickLikeBtn', { postId: this.post.data.post_id, postKey: this.$vnode.key });
    },
    showComments() {
      this.isShowComments = !this.isShowComments;
    },
    handleNewComment(e) {
      let rows  = +e.target.rows,
          value = e.target.value;
      console.log(e)
      if(e.keyCode === 13 && e.shiftKey) {
        e.preventDefault();
        e.target.value += '\n';
        e.target.rows = rows + 1;
      } else if(e.keyCode === 13) {
        e.preventDefault()
        this.$store.dispatch('addCommentToPost', { 
          body: value, 
          postId: this.post.data.post_id, 
          postKey: this.$vnode.key 
        }); 
        e.target.value = '';
      } else if(e.keyCode === 8) {
        if(rows > 1 && value[value.length - 1] === '\n') {
           e.target.rows = rows - 1;
        }
      }
    }
  },
  mounted() {
    this.toggleUserLikes = this.isUserLikes;
  },
  updated() {
    if(this.isShowComments)
      this.$refs.newComment.focus();
  }
}
</script>

<style>

</style>