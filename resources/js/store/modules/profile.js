const state = {
  user: null,
  userStatus: null,
  posts: null,
  postsStatus: null
};

const getters = {
  user(state) {
    return state.user;
  },

  posts(state) {
    return state.posts;
  },

  status(state) {
    return {
      user: state.userStatus,
      posts: state.postsStatus,
    }
  },

  friendBtnText(state, getters, rootState) {
    if(state.user !== null && rootState.User.user.data.user_id === state.user.data.user_id) {
      return '';
    }

    if(getters.friendship === null) {
      return 'Add Friend';
    }

    if(getters.friendship.data.attributes.confirmed_at === null &&
      getters.friendship.data.attributes.friend_id !== rootState.User.user.data.user_id) {
      return 'Pending';
    }

    if(getters.friendship.data.attributes.confirmed_at !== null) {
      return '';
    }

    return 'Accept';
  },

  friendship(state) {
    return state.user.data.attributes.friendship;
  }
};

const actions = {
  fetchUser({commit, dispatch}, userId) {
    commit('setUserStatus', 'Loading');
    axios.get('/api/users/' + userId)
      .then(res => {
        commit('setUser', res.data);
        commit('setUserStatus', 'Success');
      })
      .catch(error => {
        commit('setUserStatus', 'Error');
      })
  },

  fetchUserPosts({commit, dispatch}, userId) {
    commit('setPostsStatus', 'Loading');
    axios.get('/api/users/' + userId + '/posts')
      .then(res => {
        commit('setPosts', res.data);
        commit('setPostsStatus', 'Success');
      })
      .catch(error => {
        commit('setPostsStatus', 'Error');
      });
  },

  sendFriendRequest({commit, getters}, friendId) {
    if(getters.friendBtnText !== 'Add Friend') return;
    axios.post('/api/friend-request', { 'friend_id': friendId })
      .then(res => {
        commit('setUserFriendship', res.data);
      })
      .catch(() => {

      });
  },

  acceptFriendRequest({commit, state}, userId) {
    axios.post('/api/friend-request-response', { 'user_id': userId, 'status': 1 })
      .then(res => {
        commit('setUserFriendship', res.data);
      })
      .catch(() => {

      });
  },

  ignoreFriendRequest({commit, state}, userId) {
    axios.delete('/api/friend-request-response/delete', {data: { 'user_id': userId }})
      .then(res => {
        commit('setUserFriendship', null);
      })
      .catch(() => {

      });
  },
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setPosts(state, posts) {
    state.posts = posts;
  },
  setUserStatus(state, status) {
    state.userStatus = status;
  },
  setPostsStatus(state, status) {
    state.postsStatus = status;
  },
  setUserFriendship(state, friendship) {
    state.user.data.attributes.friendship = friendship;
  },
};

export default {
  state, getters, actions, mutations,
}
