const state = {
  newPosts: null,
  newPostsStatus: 'Loading',
  errorMsg: null
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
};

export default {
  state, getters, actions, mutations,
}
