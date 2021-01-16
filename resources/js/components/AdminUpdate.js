import React ,{Component} from 'react';
import ReactDOM from 'react-dom';
import JoditEditor from "jodit-react";
import axios from 'axios';

import AdminActions from '../components/actions/AdminActions';
import AdminStore from '../components/store/AdminStore';

export default class AdminUpdate extends Component{

	constructor(props){
		super(props)

		this.state = {
			content: '',
			id:0,
			title:'',
			title_text:'',
			isChanges:false,
			show_title_image:true,
		}
		this._onResponseGet = this._onResponseGet.bind(this)
		this._onGetUpdatedData = this._onGetUpdatedData.bind(this)
	}


	updateContent(value) {
        this.setState({content:value})
    }

	TitleChanger(event){
		this.setState({
			title:event.target.value
		})
	}

	TitleTextChanger(event){
		this.setState({
			title_text : event.target.value
		})
	}

	FileChanger(event){
		var image_url = "https://webphenomenal.ru/resources/images/"+event.target.files[0].name

		this.setState({
			is_image_uploaded:true,
			file:event.target.files[0],
			image_url:image_url,
			show_title_image:false
		})
	}

	CategoryChanger(event){
		this.setState({
			category:event.target.value
		})
	}

	HideBeforeImage(){
		this.setState({
			show_title_image:false,
		})
	}


	_UpdateArticle(event){
		event.preventDefault();

		var formData = new FormData()

		var isChanges = false;
		var id = this.state.id

		if(this.state.title!=this.state.old_title){
			isChanges=true;
			formData.append('title',this.state.title)
		}
		if(this.state.title_text!=this.state.old_title_text){
			isChanges=true;
			formData.append('title_text',this.state.title_text)
		}
	
		if(this.state.content!=this.state.old_content){
			isChanges=true;
			formData.append('text',this.state.content)
		}

		if(this.state.file!=this.state.old_file){
			isChanges=true;
			formData.append('file',this.state.file)
		}

		if(this.state.category!=this.state.old_category_id){
			isChanges=true;
			formData.append('category_id',this.state.category)
		}

		if(isChanges==true){
			AdminActions.updateArticle(id,formData)
		}

		// console.log(this.state.title)
		// console.log(this.state.categories)
		// console.log(this.state.response)


	}

	_onResponseGet(){
		var response = AdminStore.getArticleUpdatedResponses();
		this.setState({
				show_title_image:true
		})
		if(response){
			if(response.errors){
				this.setState({
					errors:response.errors
				})
				setTimeout(() => {
		             this.setState({
		                errors : false
		             })
				}, 4000);
			}

			if(response.success){
				this.setState({
					successes:response.success
				})
				setTimeout(() => {
		             this.setState({
		                 successes: false
		             })
				}, 4000);

			}
		}

	}

	_onGetUpdatedData(){
		var data = AdminStore.getUpdatedArticle();
		if(data){
    		this.setState({
    			title: data.title,
    			old_title: data.title,
    			title_text:data.title_text,
    			old_title_text: data.title_text,
    			content: data.text,
    			old_content: data.text,
    			file: data.image,
    			old_file: data.image,
    			image_url: data.image,
    			category: data.category_id,
    			old_category_id: data.category_id,
    		})
    	}

    	var cats = AdminStore.getUpdatetCategories()
	    	if(cats){
		    	this.setState({
		    			categories:cats
		    	})
		    }
	}



	UNSAFE_componentWillMount(){
		AdminStore.addUpdateDataResponseListener(this._onResponseGet)
		AdminStore.addGetUpdatedDataListener(this._onGetUpdatedData)
	}

	componentDidMount(){
		//get id url
		  var current_url = window.location.pathname.toString()
	      if(current_url.match(/([0-9]+)/)){
	        var matches = current_url.match(/([0-9]+)/)
	        var id = matches[0]
	        this.setState({
	        	id:id
	        })
	      }
    // 

    	AdminActions.getUpdatedArticle(id)
    	AdminActions.getUpdatedCats()

	}

	ComponentWillUnmount(){
		AdminStore.removeUpdateDataResponseListener(this._onResponseGet)
		AdminStore.removeGetUpdatedDataListener(this._onGetUpdatedData)
	}



	render(){


		return(
			<div className="admin_update_article">

			<div className={this.state.isChanges?"is_changes_false show_block":"hide_block"}>
				<p>Нет изменений</p>
			</div>

				<div className={`errors_show  ${this.state.errors?"show_block":"hide_block"}`  }>
		          {this.state.errors?this.state.errors.map((error,index) =>(
		          	<li key={index}>{error}</li>
		          )):null}
		        </div>	

		        <div className={`successes_show  ${this.state.successes?"show_block":"hide_block"}`  }>
		        	{this.state.successes?this.state.successes.map((success,index) =>(
		          	<li key={index}>{success}</li>
		          )):null}
		        </div>	

			  	<form className="admin_create_form" onSubmit={this._UpdateArticle.bind(this)}>
					<input type="text" placeholder="Title" value={this.state.title} onChange={this.TitleChanger.bind(this)}/>
					<input type="text" placeholder="Title Text" value={this.state.title_text}  onChange={this.TitleTextChanger.bind(this)}/>

					<div className="texteditor_place">
						<JoditEditor
			            	editorRef={this.setRef}
			                value={this.state.content}
			                config={this.config}
			                onChange={this.updateContent.bind(this)}
			            />
		            </div>

					<label htmlFor="form_admin_image">Upload article's image</label>
					<input type="file" id="form_admin_image" onChange={this.FileChanger.bind(this)}/>
						{this.state.show_title_image?
							<div className="show_block admin_after_upload_img">
							<img alt="uploaded image" src={this.state.image_url}/>
							<span onClick={this.HideBeforeImage.bind(this)} className="close">&times;</span>
							</div>:null}

					<select onChange={this.CategoryChanger.bind(this)}>
						{this.state.categories?this.state.categories.map((category , index) =>(
						   <option key={index} value={category.id}>{category.name}</option>
						)):null}
					</select>
					<button type="submit" id="admin_create_button">Update</button>
				</form>
			</div>
		)
	}


}

if(document.getElementById("admin_update_article")){
	ReactDOM.render(<AdminUpdate/>,document.getElementById("admin_update_article"));
}