const state = {
  user: null,
  userStatus: null,
};

const getters = {
  user(state) {
    return state.user;
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
    return axios.get('/api/users/' + userId)
      .then(res => {
        commit('setUser', res.data);
        commit('setUserStatus', 'Success');
      })
      .catch(error => {
        commit('setUserStatus', 'Error');
      })
  },

  sendFriendRequest({commit, state}, friendId) {
    axios.post('/api/friend-request', { 'friend_id': friendId })
      .then(res => {
        commit('setUserFriendship', res.data);
      })
      .catch(() => {

      });
  },

  acceptFriendRequest({commit, state}, userId) {
    axios.post('/api/friend-request-response', { 'user_id': userId })
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
  setUserStatus(state, status) {
    state.userStatus = status;
  },
  setUserFriendship(state, friendship) {
    state.user.data.attributes.friendship = friendship;
  },
};

export default {
  state, getters, actions, mutations,
}