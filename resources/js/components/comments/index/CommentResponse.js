import React, { Component, PropTypes } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import CommentStore from "../store/CommentStore";
import CommentActions from "../actions/CommentActions";

class CommentResponse extends Component {

    constructor(props) {
        super(props);
        this.state = {
        	comment_id:props.comment_id,
        	author_id:props.author_id,
        	form_status:false,
        }

        this.onChanger= this.onChanger.bind(this)

    }

    


    show_block(){
    	this.setState({
    		form_status:!this.state.form_status
    	})
    }

    textChanger(event){
    	this.setState({
    		text:event.target.value
    	})
    }

    SubmitForm(e){
    	e.preventDefault();

    	var formdata = new FormData()
    	formdata.append("text",this.state.text);
    	formdata.append("author_id",this.state.author_id)
    	formdata.append("comment_id",this.state.comment_id)

    	CommentActions.AddCommentResponse(formdata)

    }

    onChanger(){
    	this.setState({
    		form_status:false,
    		text:"",
    	})

    }

    componentDidMount(){
      CommentStore.addNwChanger(this.onChanger)
    }





    render() {
        return (
        	<div className="response_div">

        		<button onClick={this.show_block.bind(this)} className="response_button">Responde</button>
        			{this.state.form_status?
        			<div className={`${this.state.form_status?"show_block response_form":"hide_block"}`}>
        				<form onSubmit={this.SubmitForm.bind(this)}>
        					<textarea name="text" required="required" className="response_text" onChange={this.textChanger.bind(this)}/>
        					<input type="submit" value="send" id="send_response"/>
        				</form>
        			</div>
        			:null}
        	</div>
        );
    }
}

export default CommentResponse;