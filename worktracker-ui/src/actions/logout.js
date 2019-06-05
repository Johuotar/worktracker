import {LOG_OUT} from '../constants/action-types'

export default function logIn(payload) {
    console.log("ULOSKIRJAUTUMINEN");
    console.log(payload);
    return {type: LOG_OUT, payload}
};