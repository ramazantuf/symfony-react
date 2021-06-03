import {CssBaseline} from '@material-ui/core';
import React from 'react';
import ReactDom from 'react-dom';
import TodoTable from './components/TodoTable';
import TodoContextProvider from './contexts/TodoContext';

class App extends React.Component
{
	render(){
		return(
			<TodoContextProvider>
				<CssBaseline>
					<TodoTable/>
				</CssBaseline>
			</TodoContextProvider>
		);
	}
}
ReactDom.render(<App/>,document.getElementById('root'));