import {ADD_ARTICLE} from '../constants/action-types'

export default function addArticle(payload) {
    console.log("adding article");
    console.log(payload);
    return {type: ADD_ARTICLE, payload}
};
