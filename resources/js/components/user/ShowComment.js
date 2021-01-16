import React ,{useState,useEffect} from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";

export default function ShowComment(props) {


	const [data,setAllData] = useState('');
	const current_url = "https://webphenomenal.ru/";

	useEffect(() =>{
		var current_url = window.location.href;
		var arr = current_url.split("/")
		var len = arr.length -1
		var article_id = arr[len]

		getAllCommment(article_id);
	},[]);


	const getAllCommment = (id) => {
		axios.get(`${current_url}api/comments/get/`+id).then(response =>{
			const comment = response.data;
			setAllData(comment)
		}).catch(error =>{
			console.log(error)
		})
	}

	const displayComment = () =>{
		if(data.length>0){
			return(
				data.map((item,index) =>{
	        	 	return(
	        	 		<div key={index} className="one_commment">
	        	 			<div className="comment_header">
	        	 				<p>{item.author_name}</p>
	        	 				<span>{item.date}</span>
	        	 			</div>

	        	 			<div className="comment_body">
	        	 				<p>{item.text}</p>
	        	 			</div>
	        	 		</div>
	        	 	)	
        		})
			)
		}else{
			return (<h3>Пока нет комментариев</h3>)
		}
	}
  

    return (
        <div>
        	<h2>All Comments</h2>

        	<div className="all_comments">
        		{displayComment()}
        	</div>

        </div>

    );
  }
