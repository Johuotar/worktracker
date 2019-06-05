import React from 'react';
import {BrowserRouter as Router, Switch, Route} from 'react-router-dom'

import Login from './LoginAlkup'
import Home from './Home'

import PPView from './PPView'
import TTView from './TTView'
import ASView from './ASView'

function App() 
{ 

  return (
          <Router>
          <div className="App">
            
            <Switch>
              <Route exact path='/' component={Login} /* onEnter={requareAuth} */ />

              <Route exact path='/home' component={Home}/>

              <Route exact path='/ppview' component={PPView}/>

              <Route exact path='/ttview' component={TTView}/>

              <Route exact path='/asview' component={ASView}/>

            </Switch>
    
          </div> 
          </Router> 
          );
}

export default App;
