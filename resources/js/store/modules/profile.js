const state = {
  user: null,
  userStatus: null,
  friendBtnText: null
};

const getters = {
  user(state) {
    return state.user;
  },
  friendBtnText(state) {
    return state.friendBtnText;
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
        dispatch('fetchFriendBtn');
      })
      .catch(error => {
        commit('setUserStatus', 'Error');
      })
  },
  fetchFriendBtn({commit, getters}) {
    if(getters.user.data.user_id === this.$route.params.userId){
      commit('setFriendBtnText', '');
      return;
    }

    if(getters.friendship === null) {
      commit('setFriendBtnText', 'Add Friend');
    } else if(getters.friendship.data.attributes.confirmed_at === null) {
      commit('setFriendBtnText', 'Pending');
    }
  },
  sendFriendRequest({commit, state}, friendId) {
    commit('setFriendBtnText', 'Loading');
    axios.post('/api/friend-request', { 'friend_id': friendId })
      .then(() => {
        commit('setFriendBtnText', 'Pending');
      })
      .catch(() => {
        commit('setFriendBtnText', 'Add Friend');
      });
  }
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setUserStatus(state, status) {
    state.userStatus = status;
  },
  setFriendBtnText(state, text) {
    state.friendBtnText = text;
  }
};

export default {
  state, getters, actions, mutations,
}