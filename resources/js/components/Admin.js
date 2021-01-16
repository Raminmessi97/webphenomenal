import React from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";

import AddNewArticle from './article/AddNewArticle'
import ArticleList from './article/ArticleList'




export default class Admin extends React.Component {


 	constructor(){
 		super();
 		this.state = {

 		}
        
 	}

   

    render(){
    return (
        <div className="inner_admin_panel">
        	 <ArticleList/>
            <AddNewArticle/>
        </div>

    );
  }
}




if(document.getElementById("admin_panel")){
	ReactDOM.render(<Admin/>,document.getElementById("admin_panel"));
}