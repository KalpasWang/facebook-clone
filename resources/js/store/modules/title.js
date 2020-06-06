const state = {
  title: 'Fakebook'
};

const getters = {
  getTitle(state) {
    return state.title;
  }
};

const actions = {
  fetchPageTitle({commit, state}, title) {
    commit('setTitle', title);
  }
};

const mutations = {
  setTitle(state, newTitle) {
    if(newTitle) {
      state.title = newTitle + ' | Fakebook';
    } else {
      state.title = 'Fakebook';
    }

    document.title = state.title;
  }
};

export default {
  state, getters, actions, mutations,
}