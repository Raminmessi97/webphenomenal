import Dispatcher from '../dispatcher/Dispatcher';
import Constants from '../constants/Constants';
import axios from 'axios';


class CommentActions{


	getAllComments(article_id){
		axios.get('https://webphenomenal.ru/api/comments/get/'+article_id).then(response => {
			Dispatcher.dispatch({
				actionType:Constants.GET_ALL_COMMENTS,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	AddComment(formdata){
		axios.post("https://webphenomenal.ru/api/comments/store",formdata).then(response => {
			Dispatcher.dispatch({
				actionType:Constants.ADD_NEW_COMMENT,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	

}

export default new CommentActions();