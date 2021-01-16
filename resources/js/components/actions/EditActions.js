import EditDispatcher from '../dispatcher/EditDispatcher';
import EditConstants from '../constants/EditConstants'
import axios from 'axios';


class EditActions{

	GetData(){
		axios.get('https://webphenomenal.ru/api/articles').then(response => {
			EditDispatcher.dispatch({
				actionType:EditConstants.GET_DATA,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}
	
	InputToBody(data){
		EditDispatcher.dispatch({
			actionType:EditConstants.INPUT_TO_BODY,
			payload:data
		})
	}

	ImageToBody(formData,data){
		axios.post('https://webphenomenal.ru/api/editor/imageUpload',formData).then(response => {
			EditDispatcher.dispatch({
				actionType:EditConstants.IMAGE_TO_BODY,
				payload:data
			})
		}).catch(error => {
			console.log(error)
		})
	}


	UploadAllData(data){
		axios.post('https://webphenomenal.ru/api/editor/all_data',data).then(response => {
			EditDispatcher.dispatch({
				actionType:EditConstants.GET_ALL_DATA,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

}

export default new EditActions();