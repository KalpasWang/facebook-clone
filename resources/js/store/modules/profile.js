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
    
    if(getters.friendship.data.attributes.confirmed_at === null) {
      return 'Pending';
    }
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
        // dispatch('fetchFriendBtn');
      })
      .catch(error => {
        commit('setUserStatus', 'Error');
      })
  },
  // fetchFriendBtn({commit, getters, rootGetters}) {
  //   // if(getters.user.data.user_id === rootGetters['user/authUser'].data.user_id){
  //   //   commit('setFriendBtnText', '');
  //   //   return;
  //   // }

  //   if(getters.friendship === null) {
  //     commit('setFriendBtnText', 'Add Friend');
  //   } else if(getters.friendship.data.attributes.confirmed_at === null) {
  //     commit('setFriendBtnText', 'Pending');
  //   }
  // },
  sendFriendRequest({commit, state}, friendId) {
    // commit('setFriendBtnText', 'Loading');
    axios.post('/api/friend-request', { 'friend_id': friendId })
      .then(res => {
        commit('setUserFriendship', res.data);
      })
      .catch(() => {

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
  // setFriendBtnText(state, text) {
  //   state.friendBtnText = text;
  // }
  setUserFriendship(state, friendship) {
    state.user.data.attributes.friendship = friendship;
  },
};

export default {
  state, getters, actions, mutations,
}