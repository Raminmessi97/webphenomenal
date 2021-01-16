import React, { Component } from 'react';
import AdminStore from '../store/AdminStore'
import AdminActions from '../actions/AdminActions'

class ArticleList extends React.Component{
	
	constructor(props){
		super(props);

		this.state = {
			articles: [],
			art_delete_suc_state:false
		}


		this._onChange = this._onChange.bind(this)
		this._onDelete = this._onDelete.bind(this)
	}

	_deleteArticle(article){
		AdminActions.removeArticle(article.id)
	}


	_onChange(){
		this.setState({
	      articles: AdminStore.getArticles()
	    });
	}

	_onDelete(){
		this.setState({
			article_delete_response: AdminStore.getArticleDeleteResponses(),
			art_delete_suc_state: true
		})

        setTimeout(() => {
         this.setState({
             art_delete_suc_state: false
         })
         AdminActions.setInitialData();
        }, 2500);

	}

	UNSAFE_componentWillMount(){
		AdminStore.addChangeListener(this._onChange)
		AdminStore.addArticlDeleteListener(this._onDelete)
	}

	componentDidMount(){
		AdminActions.setInitialData();
	}

	ComponentWillUnmount(){
		AdminStore.removeChangeListener(this._onChange)
		AdminStore.removeArticlDeleteListener(this._onDelete)
	}



	render(){

		let Emptymessage;
		if(!this.state.articles.length)
			Emptymessage = "Нет статей"

		return(
			<div className="admin_articles_list">
				<div className={`admin_deleted_art  ${this.state.art_delete_suc_state?"show_block":"hide_block"}`  }>
		            <p>{this.state.article_delete_response?this.state.article_delete_response:null}</p>
		         </div>

            <table id="table_articles">
                <thead>
                	<tr>
                		<th>ID</th>
                		<th>TITLE</th>
                		<th>DELETE</th>
                        <th>UPDATE</th>
                	</tr>
                </thead>

                <tbody>
    	        	 {this.state.articles?this.state.articles.map((article, index) => (
    	        	 	<tr key={index}>
    		        	 	<th>{article.id}</th>
    		        	 	<th>{article.title}</th>
    		        	 	<th>
    		        	 	<a href="#" id="delete_article" onClick={this._deleteArticle.bind(this,article)}>Delete</a>
    		        	 	</th>
                            <th>
                            <a href={`articles/${article.id}`} id="update_article">Update</a>
                            </th>
    	        	 	</tr>
                    )):null}
    	       </tbody>

	      	</table>
	      </div>
			)
	}


}
export default ArticleList;