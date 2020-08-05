const state = {
  isModalOpen: false
};

const getters = {
  isModalOpen(state) {
    return state.isModalOpen;
  }
};

const actions = {

};

const mutations = {
  setModalState(state, condition) {
    state.isModalOpen = condition;
  }
};

export default {
  state, getters, actions, mutations,
}
