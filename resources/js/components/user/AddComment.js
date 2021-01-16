import React ,{useState,useEffect} from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import Cookies from 'js-cookie';

import UserComment from "../UserComment";


export default function AddCommment(props) {

	const [comment_text,setText] = useState("")
	const [comment_create_error,setError] = useState([])
	const [create_article_err_status,setErrorStatus] = useState(false)

	const [comment_create_success,setSuccess] = useState([])
	const [create_article_suc_status,setSuccessStatus] = useState(false)


	const submitForm =(e) => {
	   	e.preventDefault()


	   	var csrf_token = Cookies.get('csrf_token')
	   	


	   	const formdata = new FormData()
	   	formdata.append("text",comment_text)
	   	formdata.append("csrf_token",csrf_token)
	   	formdata.append("article_id",props.article_id)

	   	axios.post("https://webphenomenal.ru/api/comments/store",formdata).then(response =>{

	   		response= response.data
	   		

	   		if(response.errors){
	   			setError(response.errors)
	   			setErrorStatus(true)

		   		setTimeout(() => {
		   				setError("")
						setErrorStatus(false)
		   		},3000);
	   		}
	   		if(response.success){
	   			setSuccess(response.success)
	   			setSuccessStatus(true)
	   			setText("")

	   			UserComment.CallChanger;

	   			setTimeout(() =>{
	   				setSuccess("")
	   				setSuccessStatus(false)
	   			},3000);
	   		}







	   	}).catch(errors =>{
	   		console.log(errors)
	   	});

	}


	useEffect(() =>{

	});
   


    return (
        <div className="form_add_comment">

        	{create_article_err_status?
	        	<div className={` ${!comment_create_error?"hide_block":"show_block comment_errors"}` }>
	        		{comment_create_error?comment_create_error.map((error,index) =>{
	        			return(<li key={index}>{error}</li>)
	        		}):null}
	        	</div>
        	:null}

        	{create_article_suc_status?
	        	<div className={`${!comment_create_success?"hide_block":"show_block comment_successes"}`}>
	        		{comment_create_success?comment_create_success.map((suc,index) =>{
						return(<li key={index}>{suc}</li>)
	        		}):null}
	        	</div>
        	:null}



        	<form onSubmit={submitForm} id="form_for_comment">
        		<textarea type="text" required="required" value={comment_text}  name="comment_text" placeholder="Enter comment" onChange={(e) =>setText(e.target.value)}/>
        		<button type="submit">Add Comment</button>
       		</form>
        
        </div>

    );
  }
