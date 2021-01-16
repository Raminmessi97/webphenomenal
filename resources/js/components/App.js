import React, { Component,useState, useRef } from 'react';
import ReactDOM from 'react-dom';

import axios from 'axios';

import JoditEditor from "jodit-react";


const App = ({}) => {
    const editor = useRef(null)
    const [content, setContent] = useState('')
    const [text, setText] = useState('')
    const config = {
        readonly: false // all options from https://xdsoft.net/jodit/doc/
    }

   function SendData(){

        var newFormData =  new FormData()
        newFormData.append("data",content)
        newFormData.append("text",text)

        axios.post('/php_projs/phenomenon/api/editor/imageUpload',newFormData).then(response => {
            console.log(response.data)
        }).catch(error => {
            console.log(error)
        })
    }
    
    return (
         <div>
            <JoditEditor
                ref={editor}
                value={content}
                config={config}
                tabIndex={2} // tabIndex of textarea
                onBlur={(newContent) => setContent(newContent.target.innerHTML)} // preferred to use only this option to update the content for performance reasons
                onChange={newContent => {}}
            />
            <input type="text" name="title" id="title" onChange={(text) => setText(event.target.value)}/>
            <button onClick={SendData}>Send</button>
        </div>
        );
}

if(document.getElementById("my_editor")){
    ReactDOM.render(<App/>,document.getElementById("my_editor"));
}
