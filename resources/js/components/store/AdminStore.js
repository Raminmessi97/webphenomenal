import { EventEmitter } from 'events';
import AdminDispatcher from '../dispatcher/AdminDispatcher';
import AdminConstants from '../constants/AdminConstants';


    const CHANGE = "CHANGE";
    const CAT_CHANGE = "CAT_CHANGE";
    const REMOVE = "REMOVE";
    const RESPONSE_GET = "RESPONSE_GET";
    const UPDATE = "UPDATE"
    const GET_UPDATE = "GET_UPDATE"

    var _data = [];
    var _categories = [];
    var _responses = [];
    var _article_delete_response = [];
    var _article_updated_response = [];
    var _updated_article ;
    var _updated_categories =[];

    function setArticles(articles){
       _data = articles
    }

    function setCategories(categories){
       _categories = categories
    }

    function addNewArticle(responses){
       _responses = responses
    }

    function deleteArticle(response){
       _article_delete_response = response
    }

    function updateArticle(response){
         // console.log("data1")
          // console.log(response)
        _article_updated_response = response
    }

    function setUpdatedArticle(response){
        _updated_article = response
    }

    function setUpdatedCategories(response){
        _updated_categories = response
    }

class AdminStore extends EventEmitter{

    constructor(){
        super();
        AdminDispatcher.register(this._registerToAction.bind(this));
    }

    _registerToAction(action){
        switch (action.actionType) {
              case AdminConstants.GET_ALL_ARTICLES:
                setArticles(action.payload);
                this.emit(CHANGE)
                break;

              case AdminConstants.GET_ALL_CATEGORIES:
                setCategories(action.payload)
                this.emit(CAT_CHANGE)
                break;

              case AdminConstants.ADD_NEW_ARTICLE:
                addNewArticle(action.payload)
                this.emit(RESPONSE_GET)
                break;

              case AdminConstants.REMOVE_ARTICLE:
               deleteArticle(action.payload)
               this.emit(REMOVE)
                break;

               case AdminConstants.UPDATE_ARTICLE:
                updateArticle(action.payload)
                this.emit(UPDATE)
                break;

                case AdminConstants.GET_UPDATED_DATA:
                setUpdatedArticle(action.payload)
                this.emit(GET_UPDATE)
                break;

                case AdminConstants.GET_UPDATED_CATS:
                setUpdatedCategories(action.payload)
                this.emit(GET_UPDATE)
                break;


            default:
                return true;
                break;
        }

        
    }

    getArticles () {
        return _data;
    }
    getCategories () {
        return _categories;
    }

    getArticleCreateResponses(){
        return _responses;
    }

    getArticleDeleteResponses(){
        return _article_delete_response;
    }
    getArticleUpdatedResponses(){
        return _article_updated_response;
    }

    getUpdatedArticle(){
        return _updated_article;
    }

    getUpdatetCategories(){
        return _updated_categories;
    }

    



    addChangeListener(callback){
        this.on(CHANGE,callback)
    }

    removeChangeListener(callback){
        this.removeListener(CHANGE,callback)
    }

    addChangeCategoryListener(callback){
        this.on(CAT_CHANGE,callback)
    }

    removeChangeCategoryListener(callback){
        this.removeListener(CAT_CHANGE,callback)
    }

    addResponseGetListener(callback){
        this.on(RESPONSE_GET,callback)
    }

    removeResponseGetListener(callback){
        this.removeListener(RESPONSE_GET,callback)
    }

    addArticlDeleteListener(callback){
        this.on(REMOVE,callback)
    }

    removeArticlDeleteListener(callback){
        this.removeListener(REMOVE,callback)
    }

    addUpdateDataResponseListener(callback){
        this.on(UPDATE,callback)
    }

    removeResponseGetListener(callback){
        this.removeListener(UPDATE,callback)
    }

    addGetUpdatedDataListener(callback){
        this.on(GET_UPDATE,callback)
    }
    removeGetUpdatedDataListener(callback){
        this.removeListener(GET_UPDATE,callback)
    }

}

export default new AdminStore();