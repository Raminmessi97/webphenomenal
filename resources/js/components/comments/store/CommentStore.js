import { EventEmitter } from 'events';
import Dispatcher from '../dispatcher/Dispatcher';
import Constants from '../constants/Constants';

    const GET = "GET"
    const CHANGE = "CHANGE";

    var _comments = [];
    var _responses = [];

    function setComments(comments){
       _comments = comments
    }

    function addNewComment(responses){
       _responses = responses
    }


class CommentStore extends EventEmitter{

    constructor(){
        super();
        Dispatcher.register(this._registerToAction.bind(this));
    }

    _registerToAction(action){
        switch (action.actionType) {
              case Constants.GET_ALL_COMMENTS:
                setComments(action.payload);
                this.emit(GET)
                break;

              case Constants.ADD_NEW_COMMENT:
                addNewComment(action.payload)
                this.emit(CHANGE)
                this.emit(GET)
                break;


            default:
                return true;
                break;
        }

        
    }

    getComments() {
        return _comments;
    }

    getResponses(){
        return _responses;
    }
    
    addChangeListener(callback){
        this.on(GET,callback)
    }

    removeChangeListener(callback){
        this.removeListener(GET,callback)
    }

    addCommentAddListener(callback){
        this.on(CHANGE,callback)
    }

    


}

export default new CommentStore();