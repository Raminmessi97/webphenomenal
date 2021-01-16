import React, { Component, PropTypes } from 'react';
import EditStore from '../store/EditStore'
import EditActions from '../actions/EditActions'

class Editor_Header extends Component {

    constructor(props) {
        super(props);

        this.state = {
          query:1,
          queryForImage:1
        }

    }

    UNSAFE_componentWillMount(){
    	
    }

    componentDidMount(){

    }


    addText(event){
    	var html = <div contentEditable="true" className="editor_textarea_blocks">
    		<p>This is an editable paragraph</p>
		</div>

    	const data = {
    		html:html,
    		query:this.state.query
    	}

    	EditActions.InputToBody(data)
    	this.setState({
    		query:this.state.query+1
    	})
    }


    addImage(event){
		var image_url = "http://localhost/php_projs/phenomenon/resources/images/editor_images/"+event.target.files[0].name;

		var html = <img alt="uploaded image" src={image_url}/>

		var formData= new FormData()
		formData.append("image",event.target.files[0])

		const data = {
    		html:html,
    		query:this.state.queryForImage
    	}

    	EditActions.ImageToBody(formData,data)
    	this.setState({
    		queryForImage:this.state.queryForImage+1
    	})

    }

    TextAreaChanger(event){
    	this.setState({
    		textData:event.target.value
    	})
    }

    MakeBolder(){
    	var text = window.getSelection().toString();
    	text = text.bold()
    	
    }
    MakeItalick(){
    	var text = window.getSelection().toString();
    }




    render() {

        return (
          	<div className="editor_header">
          		<button onClick={this.addText.bind(this)}>Add Text</button>
          		<button onClick={this.MakeBolder.bind(this)}>B</button>
          		<button onClick={this.MakeItalick.bind(this)}>I</button>
          		<label htmlFor="editor_image">UploadImage</label>
          		<input type="file" id="editor_image" name="editor_image" onChange={this.addImage.bind(this)}/>
          	</div>
        );
    }
}

export default Editor_Header;
