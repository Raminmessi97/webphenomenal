import React, { Component, PropTypes } from 'react';
import EditStore from '../store/EditStore'
import EditActions from '../actions/EditActions'


class Editor_Body extends Component {

    constructor(props) {
        super(props);

        this.state = {
          data:[]
        }
        this._onChange = this._onChange.bind(this)
        this._onChangeImage = this._onChangeImage.bind(this)
    }

    _onChange(){
      this.setState({
        data:[...this.state.data,EditStore.getInputData()]
      })
    }
    _onChangeImage(){
      this.setState({
        data:[...this.state.data,EditStore.getImageData()]
      })
    }

    UNSAFE_componentWillMount(){
      EditStore.addChangeListener(this._onChange)
      EditStore.addImageChangerListener(this._onChangeImage)
    }

    ComponetWillUnmount(){
      EditStore.removeChangeListener(this._onChange)
      EditStore.removeImageChangerListener(this._onChangeImage)
    }

    UploadAllData(){
      var formData = new FormData()
      
      this.state.data.forEach((data2) => {
        console.log(data2)
      })

      // EditActions.InputToBody(this.state.data)
    }


    render() {
      console.log(this.state.data)
        return (
          	<div className="editor_body">
              {this.state.data? this.state.data.map((data2,index) =>{
                 <div>{data2.html}</div> 
              }):null}
               {this.state.data.length?<button onClick={this.UploadAllData.bind(this)}>Upload</button>:null}
          	</div>
        );
    }
}

export default Editor_Body;
