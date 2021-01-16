import AdminDispatcher from '../dispatcher/AdminDispatcher';
import AdminConstants from '../constants/AdminConstants'
import axios from 'axios';


class AdminActions{


	setInitialData(){
		axios.get('https://webphenomenal.ru/api/articles').then(response => {
			AdminDispatcher.dispatch({
				actionType:AdminConstants.GET_ALL_ARTICLES,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	setInitialCategories(){
		axios.get('https://webphenomenal.ru/api/categories').then(response => {
			AdminDispatcher.dispatch({
				actionType:AdminConstants.GET_ALL_CATEGORIES,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	addNewArticle(formdata){
		axios.post('https://webphenomenal.ru/api/articles/store',formdata).then(response => {
			AdminDispatcher.dispatch({
				actionType:AdminConstants.ADD_NEW_ARTICLE,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	removeArticle(article_id){
		axios.delete('https://webphenomenal.ru/api/articles/'+article_id).then(response => {
			AdminDispatcher.dispatch({
				actionType:AdminConstants.REMOVE_ARTICLE,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	updateArticle(id,formData){
		axios.post('https://webphenomenal.ru/api/articles/update/'+id,formData).then(response => {
			AdminDispatcher.dispatch({
				actionType:AdminConstants.UPDATE_ARTICLE,
				payload:response.data
				})
			}).catch(error => {
				console.log(error)
			})
	}

	getUpdatedArticle(id){
		axios.get('https://webphenomenal.ru/api/articles/'+id).then(response => {
    		AdminDispatcher.dispatch({
				actionType:AdminConstants.GET_UPDATED_DATA,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}

	getUpdatedCats(){
		 axios.get('https://webphenomenal.ru/api/categories').then(response => {
    		AdminDispatcher.dispatch({
				actionType:AdminConstants.GET_UPDATED_CATS,
				payload:response.data
			})
		}).catch(error => {
			console.log(error)
		})
	}


}

export default new AdminActions();