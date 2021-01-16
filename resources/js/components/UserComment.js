import React ,{useState,useEffect} from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";

import AddComment from './user/AddComment';
import ShowComment from './user/ShowComment';


export default function UserComment() {

	const [count,setCount] = useState(0)
	const [url,setUrl] = useState(0)


	useEffect(() =>{
		var current_url = window.location.href;
		var arr = current_url.split("/")
		var len = arr.length -1
		var article_id = arr[len]

		setUrl(article_id)
	});
   

    return (
        <div>
            <h2>Comments</h2>
        	<AddComment article_id={url}/>
        	<ShowComment article_id={url}/>
        </div>

    );
  }




if(document.getElementById("user-add-comment")){
	ReactDOM.render(<UserComment/>,document.getElementById("user-add-comment"));
}