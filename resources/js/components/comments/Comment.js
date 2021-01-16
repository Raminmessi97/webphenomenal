import React from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";

import AddComment from './index/AddComment';
import ShowComment from './index/ShowComment';


export default class Comment extends React.Component {

	constructor(props){
		super(props)

		this.state = {
			article_id:0,
		}
	}

	UNSAFE_componentWillMount(){
		var current_url = window.location.href;
		var arr = current_url.split("/")
		var len = arr.length -1
		var id = arr[len]
		this.setState({
			article_id:id
		})
	}

	render(){
		return(
			<div>
				<AddComment id={this.state.article_id}/>
				{/*<ShowComment id={this.state.article_id}/>*/}
			</div>
		)	
	}


  
}


if(document.getElementById("user-add-comment")){
	ReactDOM.render(<Comment/>,document.getElementById("user-add-comment"));
}