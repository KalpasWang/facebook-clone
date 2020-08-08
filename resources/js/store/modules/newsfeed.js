const state = {
  newPosts: null,
  newPostsStatus: 'Loading',
  errorMsg: null,
  createNewPostStatus: null
};

const getters = {
  newPosts(state) {
    return state.newPosts;
  },

  newPostsStatus(state) {
    return state.newPostsStatus;
  },

  errorMsg(state) {
    return state.errorMsg;
  },

  createNewPostStatus(state) {
    return state.createNewPostStatus;
  }
};

const actions = {
  fetchNewsFeed({ commit, state }) {
    axios.get('/api/posts')
    .then(res => {
      commit('setPosts', res.data);
      commit('setPostsStatus', 'Success');
    })
    .catch(error => {
      commit('setPostsStatus', 'Error');
      commit('setError', error);
    })
  },

  createNewPost({commit, state}, postMsg) {
    commit('setCreateNewPostStatus', 'Loading');
    axios.post('/api/posts', { 'body': postMsg })
      .then(res => {
        commit('addToNewsFeed', res.data);
        commit('setCreateNewPostStatus', 'Success');
      })
      .catch(error => {
        console.log(error);
      })
  }
};

const mutations = {
  setPosts(state, posts) {
    state.newPosts = posts;
  },

  setPostsStatus(state, status) {
    state.newPostsStatus = status;
  },

  setError(state, error) {
    state.errorMsg = error;
  },

  addToNewsFeed(state, newPost) {
    state.newPosts.data.unshift(newPost);
  },

  setCreateNewPostStatus(state, status) {
    state.createNewPostStatus = status;
  }
};

export default {
  state, getters, actions, mutations,
}
