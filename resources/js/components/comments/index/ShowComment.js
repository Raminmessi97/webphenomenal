import React, { Component, PropTypes } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import CommentStore from "../store/CommentStore";
import CommentActions from "../actions/CommentActions";

class ShowComment extends Component {

    constructor(props) {
        super(props);
        this.state = {
        	comments:[],
        	article_id:0
        }

        this._onChange = this._onChange.bind(this)
    }

    _onChange(){
		this.setState({
	      comments: CommentStore.getComments()
	    });
	}

	UNSAFE_componentWillMount(){
		console.log('before-render')
		CommentStore.addChangeListener(this._onChange)

		var current_url = window.location.href;
		var arr = current_url.split("/")
		var len = arr.length -1
		var id = arr[len]
		this.setState({
			article_id:id
		})
	}

	componentDidMount(){
		CommentActions.getAllComments(this.state.article_id)
	}


	ComponentWillUnmount(){
			console.log('after unmount')
			CommentStore.removeChangeListener(this._onChange)
	}


    render() {
    	console.log('render')
        return (
        	<div className="all_comments">
	            <h1>Comments</h1>
	            	{this.state.comments?this.state.comments.map((item,index) =>(
		        	 		<div key={index} className="one_commment">
		        	 			<div className="comment_header">
		        	 				<p>{item.author_name}</p>
		        	 				<span>{item.date}</span>
		        	 			</div>

		        	 			<div className="comment_body">
		        	 				<p>{item.text}</p>
		        	 			</div>
		        	 		</div>
	        		)):"Нет комментариев"}
        	</div>
        );
    }
}

export default ShowComment;

if(document.getElementById("show-comment")){
	ReactDOM.render(<ShowComment/>,document.getElementById("show-comment"));
}