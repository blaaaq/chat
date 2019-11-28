import { CHANGE_NOTIFICATION } from '../actions/notification';



export default (state = {}, action) => {
    switch (action.type) {
        case CHANGE_NOTIFICATION:
            return { ...state, text: action.text };
        default:
            return state;
    }
};
