import React, { Component, PropTypes } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Cookies from 'js-cookie';

import CommentStore from "../store/CommentStore";
import CommentActions from "../actions/CommentActions";

class AddComment extends Component {

    constructor(props) {
        super(props);

        this.state ={
        	comment_text:"",
        	create_comment_err_status:false,
        	create_comment_suc_status:false,
        }
       
        this._onResponseGet = this._onResponseGet.bind(this)
     
    }

    _onResponseGet(){
	    var responses =  CommentStore.getResponses()
	    console.log(responses);

	    if(responses.errors){
	    	console.log('errors')
   			this.setState({
   				comment_create_error:responses.errors,
   				create_comment_err_status:true,
   				comment_text:"",
   			})

	   		setTimeout(() => {
	   			this.setState({
   					comment_create_error:"",
   					create_comment_err_status:false
   				})
	   		},3000);
   		}
   		if(responses.success){
   			console.log('success')
   			CommentActions.getAllComments(this.state.article_id)
   			this.setState({
   				comment_create_success:responses.success,
   				create_comment_suc_status:true,
   				comment_text:"",
   			})

	   		setTimeout(() => {
	   			this.setState({
   					comment_create_success:"",
   					create_comment_suc_status:false
   				})
	   		},3000);
   		}
	}


	_submitForm(event){
	   	event.preventDefault();
	   	var csrf_token = Cookies.get('csrf_token')
	   	
	   	const formdata = new FormData()
	   	formdata.append("text",this.state.comment_text)
	   	formdata.append("csrf_token",csrf_token)
	   	formdata.append("article_id",this.state.article_id)

	   	// console.log(formdata);

	   	CommentActions.AddComment(formdata)
	}

	UNSAFE_componentWillMount(){
		CommentStore.addCommentAddListener(this._onResponseGet)

		var current_url = window.location.href;
		var arr = current_url.split("/")
		var len = arr.length -1
		var id = arr[len]
		this.setState({
			article_id:id
		})
	}

	componentDidMount(){

	}



    render() {
        return (
        	<div className="form_add_comment">

	        	{this.state.create_comment_err_status?
		        	<div className={` ${this.state.comment_create_error?"hide_block":"show_block comment_errors"}` }>
		        		{this.state.comment_create_error?this.state.comment_create_error.map((error,index) =>(
		        			<li key={index}>{error}</li>
		        		)):"new erroroe"}
		        	</div>
	        	:null}

	        	{this.state.create_comment_suc_status?
		        	<div className={`${this.comment_create_success?"hide_block":"show_block comment_successes"}`}>
		        		{this.state.comment_create_success?this.state.comment_create_success.map((suc,index) =>(
							<li key={index}>{suc}</li>
		        		)):"net succeses"}
		        	</div>
	        	:null}



	        	<form onSubmit={this._submitForm.bind(this)} id="form_for_comment">
	        		<textarea type="text" required="required" value={this.state.comment_text}  name="comment_text" 
	        		placeholder="Enter comment" onChange={(e) =>this.setState({comment_text:e.target.value})}/>
	        		<button type="submit">Add Comment</button>
	       		</form>
        
       		 </div>


        );
    }
}

export default AddComment;
