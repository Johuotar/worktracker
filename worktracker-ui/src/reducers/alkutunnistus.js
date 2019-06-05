import {LOG_IN} from '../constants/action-types'

const initialState = {
    kayttajanTiedot: []
}

function loginReducer(state = initialState, action) {
    if (action.type === LOG_IN)
    {
        console.log("Login REDUCER IN ACTION")
        return Object.assign({},state, {
            kayttajanTiedot: state.kayttajanTiedot.concat(action.payload)
        });
    }

    console.log("Login REDUCER FAILED");
    return state;
};

export default loginReducer;
