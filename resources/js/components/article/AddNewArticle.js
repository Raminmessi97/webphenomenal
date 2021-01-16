import React ,{Component} from 'react';
import AdminActions from '../actions/AdminActions';
import AdminStore from '../store/AdminStore';
import JoditEditor from "jodit-react";
import 'jodit';
import 'jodit/build/jodit.min.css';

export default class AddNewArticle extends Component{

	constructor(props){
		super(props)

		this._getFreshArticle = this._getFreshArticle.bind(this)
		this._onChange = this._onChange.bind(this)
		this._onResponseGet = this._onResponseGet.bind(this)

		this.state = {
			article:this._getFreshArticle(),
			article_create_form_status:false,

			article_create_error_status:false,
			article_create_success_status:false,

			is_image_uploaded:false,
			content: 'content',
			category:1

		}
	}

	updateContent(value) {
        this.setState({content:value})
    }

	_onChange(){
		this.setState({
			categories:AdminStore.getCategories()
		})
	}

	_onResponseGet(){
		var response = AdminStore.getArticleCreateResponses()
		this.setState({
			response:response
		})

		if(response.errors){
			this.setState({
				article_create_errors :response.errors,
				article_create_form_status:false,
				article_create_error_status:true,
			})
			setTimeout(() => {
	             this.setState({
	                article_create_error_status : false
	             })
			}, 3000);
		}

		if(response.success){
			this.setState({
				article_create_successes :response.success,
				article_create_form_status:false,
				article_create_success_status:true
			})
			setTimeout(() => {
	             this.setState({
	                 article_create_success_status: false
	             })
			}, 3000);

			AdminActions.setInitialData();
		}


		
	}


	_getFreshArticle(){
		return{
			title:'',
			text:''
		};
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
			image_url:image_url
		})
	}

	CategoryChanger(event){
		this.setState({
			category:event.target.value
		})
	}

	ShowForm(event){
		this.setState({
			article_create_form_status:true
		})
	}
	HideForm(event){
		this.setState({
			article_create_form_status:false
		})
	}

	HideBeforeImage(){
		this.setState({
			is_image_uploaded:false,
		})
	}


	_AddNewArticle(event){
		event.preventDefault();

		var formData = new FormData()
		formData.append('title',this.state.title)
		formData.append('title_text',this.state.title_text)
		formData.append('text',this.state.content)
		formData.append('category',this.state.category)
		formData.append('file',this.state.file)


		AdminActions.addNewArticle(formData)

	}


	UNSAFE_componentWillMount(){
		AdminStore.addResponseGetListener(this._onResponseGet)
		AdminStore.addChangeCategoryListener(this._onChange)
	}

	componentDidMount(){
		AdminActions.setInitialCategories();
	}

	ComponentWillUnmount(){
		AdminStore.removeResponseGetListener(this._onResponseGet)
		AdminStore.removeChangeCategoryListener(this._onChange)
	}


	render(){
		return(
			<div className="admin_add_new_article">

			<div id="admin_add_actions">
				<ul>
				<li><a className="show_hide_art_crt" onClick={this.ShowForm.bind(this)}>Create article</a></li>
				<li><a>Other functions</a></li>
				</ul>
			</div>

			<div className={`admin_deleted_art  ${this.state.article_create_error_status?"show_block":"hide_block"}`  }>
	          {this.state.article_create_errors?this.state.article_create_errors.map((error,index) =>(
	          	<li key={index}>{error}</li>
	          )):null}
	        </div>	

	        <div className={`admin_create_article_success  ${this.state.article_create_success_status?"show_block":"hide_block"}`  }>
	        	{this.state.article_create_successes?this.state.article_create_successes.map((success,index) =>(
	          	<li key={index}>{success}</li>
	          )):null}
	        </div>	

				<div className={this.state.article_create_form_status?"admin_create_art_form show_block":"hide_block"}>
				  <div className="admin_cr_form_wrap">
				   <span onClick={this.HideForm.bind(this)} className="close">&times;</span>
				  	<form className="admin_create_form" onSubmit={this._AddNewArticle.bind(this)}>
						<input type="text" placeholder="Title" onChange={this.TitleChanger.bind(this)}/>
						<input type="text" placeholder="Title Text" onChange={this.TitleTextChanger.bind(this)}/>
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
							{this.state.is_image_uploaded?
								<div className="show_block admin_after_upload_img">
								<img alt="uploaded image" src={this.state.image_url}/>
								<span onClick={this.HideBeforeImage.bind(this)} className="close">&times;</span>
								</div>:null}

						<select onChange={this.CategoryChanger.bind(this)}>
							{this.state.categories?this.state.categories.map((category , index) =>(
							   <option key={index} value={category.id}>{category.name}</option>
							)):null}
						</select>
						<button type="submit" id="admin_create_button">Create</button>
					</form>
				  </div>
				</div>
			</div>
		)
	}


}