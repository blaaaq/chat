import { SET_USER } from '../actions/user';
import { AUTH_VIEW_TYPE } from '../actions/user';



export default (state = {user: 'undefined'}, action) => {
    switch (action.type) {
        case SET_USER:
            return { ...state, user: action.user, session: action.session };
        case AUTH_VIEW_TYPE:
            return { ...state, authViewType: action.authViewType };
        default:
            return state;
    }
};
