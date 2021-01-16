import React,{useState,useEffect} from 'react';
import ReactDOM from 'react-dom'

function Tests(){
	const [count,setCount] = useState(0)

	useEffect(() =>{
		document.title = `Вы нажали ${count} раз`
	})

	return(
		<div>
			<p>You click {count} times</p>
			<button onClick={() =>setCount(count+1)}>Click</button>
		</div>
	);
}

if(document.getElementById('test')){
	ReactDOM.render(<Tests/>,document.getElementById('test'));
}