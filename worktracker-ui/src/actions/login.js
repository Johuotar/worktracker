import {LOG_IN} from '../constants/action-types'

export default function logIn(payload) {
    console.log("TEHDÄÄN KIRJAUTUMINEN");
    console.log(payload);
    return {type: LOG_IN, payload}
};