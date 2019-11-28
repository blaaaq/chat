import { SET_MESSAGES } from '../actions/messages';

import * as _ from 'lodash';

export default (state = {}, action) => {
    switch (action.type) {
        case SET_MESSAGES:
            const result = _.values(_.merge(
                _.keyBy(state.messages, 'id'),
                _.keyBy(action.messages, 'id')
            ));
            return { ...state, messages: _.reverse(result)};

        default:
            return state;
    }
};

