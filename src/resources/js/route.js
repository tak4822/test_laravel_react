import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter,
    Route,
    Routes,
  } from 'react-router-dom';
import Register from './pages/Register';
import Home from './pages/Home';
import Login from './pages/Login';

  function App() {
    return (
        <div>
            <Routes>
                <Route path='/' exact element={<Home />} />
                <Route path='/register' element={<Register />} />
                <Route path='/login' element={<Login />} />
            </Routes>
        </div>
    );
}

ReactDOM.render((
    <BrowserRouter>
        <App />
    </BrowserRouter>
), document.getElementById('app'))