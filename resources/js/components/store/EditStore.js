import { EventEmitter } from 'events';
import EditDispatcher from '../dispatcher/EditDispatcher';
import EditConstants from '../constants/EditConstants';


    const CHANGE = "CHANGE";
    const IMAGE_CHANGE="IMAGE_CHANGE";

    var _data = [];
    var _inputData = [];

    function setData(data){
       _data = data
    }

    function setInputData(data){
    	_inputData = data
    }

    function setImageData(data){
    	_inputData = data;
    }

    function getAllData(data){
    	console.log(data)
    }




class EditStore extends EventEmitter{

    constructor(){
        super();
        EditDispatcher.register(this._registerToAction.bind(this));
    }

    _registerToAction(action){
        switch (action.actionType) {
            case EditConstants.GET_DATA:
            setData(action.payload);
            break;
          
            case EditConstants.INPUT_TO_BODY:
           	 setInputData(action.payload);
            this.emit(CHANGE)
            break;
            
            case EditConstants.GET_ALL_DATA:
            	getAllData(action.payload)
            break;

            case EditConstants.IMAGE_TO_BODY:
           	 setImageData(action.payload);
            this.emit(CHANGE)
            break;

            default:
                return true;
                break;
        }

        
    }

    getData () {
        return _data;
    }

    getInputData () {
        return _inputData;
    }

    // getImageData () {
    //     return _inputData;
    // }



    addChangeListener(callback){
        this.on(CHANGE,callback)
    }

    removeChangeListener(callback){
        this.removeListener(CHANGE,callback)
    }

    addImageChangerListener(callback){
        this.on(IMAGE_CHANGE,callback)
    }

    removeImageChangerListener(callback){
        this.removeListener(IMAGE_CHANGE,callback)
    }
	


}

export default new EditStore();