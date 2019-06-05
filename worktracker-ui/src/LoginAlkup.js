import React, { Component } from 'react';
import axios from 'axios'
// import {BrowserRouter, Switch, Route} from 'react-router-dom'
import * as Constants from './constants/vakiot'
import {Redirect} from 'react-router'
import {BrowserRouter} from 'react-router-dom'
// import index2 from './index2'

class Login extends Component {
  constructor() {
    super();
    this.state = {
      email: '',
      password: '',
      henkiloID: '',
      asiakasID: '',
      tyyppi: '',
      rooli: '',
      sukunimi: '',
      etunimi: '',
      nimi: '',

      redirect: false,

      err: {}
    };

  }



  onSubmit(e) {
    e.preventDefault();

    const userData = {
      myusername: this.state.email,
      mypassword: this.state.password
    };

    const kirjautunutKayttaja = {
      henkiloID: this.state.henkiloID,
      asiakasID: this.state.asiakasID,
      tyyppi: this.state.tyyppi,
      rooli: this.state.rooli,
      sukunimi: this.state.sukunimi,
      etunimi: this.state.etunimi,
      yrityksenNimi: this.state.nimi  
    };    

    axios.post('http://localhost:5000/login', userData)
    .then(res =>{
                // console.log(res.status);
                if (res.status == 200) 
                  { 
                    console.log(res.data);
                    // console.log(res.data[0].henkiloID);
                    this.setState({henkiloID: res.data[0].henkiloID,
                                  asiakasID: res.data[0].asiakasID,
                                  tyyppi: res.data[0].tyyppi,
                                  rooli: res.data[0].rooli,
                                  sukunimi: res.data[0].sukunimi,
                                  etunimi: res.data[0].etunimi,
                                  nimi: res.data[0].nimi,
                                  redirect: true
                                })
                    console.log(this.state) ;

                    kirjautunutKayttaja.henkiloID=this.state.henkiloID
                    kirjautunutKayttaja.asiakasID= this.state.asiakasID
                    kirjautunutKayttaja.tyyppi= this.state.tyyppi
                    kirjautunutKayttaja.rooli= this.state.rooli
                    kirjautunutKayttaja.sukunimi= this.state.sukunimi
                    kirjautunutKayttaja.etunimi= this.state.etunimi
                    kirjautunutKayttaja.yrityksenNimi= this.state.nimi 


                    
                    console.log(kirjautunutKayttaja);
                  
                    // // tarkistetaan roolitus ja tehdään Redirect vastaavaan sivuun
                    // if (this.state.rooli == Constants.PROJEKTIPAALLIKKO) 
                    // {
                    //   // mennään PPView.js
                    // }
                    // if (this.state.rooli == Constants.TYONTEKIJA) 
                    // {
                    //   // mennään TTView.js

                    // }                    
                    // if (this.state.rooli == Constants.ASIAKAS) 
                    // {
                    //   // mennään ASView.js
                    // }  

                  }
                }
            )
    .catch(err=> console.log(err))
  }


  onChange(e) {
    this.setState({ [e.target.name]: e.target.value });
  }

  render() {
    // if (this.state.redirect) {return (<BrowserRouter> <Redirect to={index2} />  </BrowserRouter>  ) }
    return (
      <section id="login">
      <div className="container">
         
          <hr className="star-dark mb-5"/>
              <div className="row">
                  <div className="col-lg-8 mx-auto">
                  <h1 className="display-4 text-center">Login</h1>
                  <p className="lead text-center">
                      Login your account
                  </p>
                  <form noValidate onSubmit={this.onSubmit.bind(this)}>
                                <div className="control-group">
                                    <div className="form-group floating-label-form-group controls mb-0 pb-2">
                                    <label>Email Address</label>
                                    <input className="form-control"  type="email" 
                                        value={this.state.email}
                                        onChange={this.onChange.bind(this)} 
                                        placeholder="Email Address" 
                                        name="email"/>
        
                                    </div>
                                </div>
                                <div className="control-group">
                                    <div className="form-group floating-label-form-group controls mb-0 pb-2">
                                    <label>Password</label>
                                    <input className="form-control"   type="password" 
                                        value={this.state.password}
                                        onChange={this.onChange.bind(this)} 
                                        placeholder="Password" 
                                        name="password"
                                        />
                                   
                                    </div>
                                </div>
                           
                              
                                <br/>
                                <div className="form-group">
                                    <button type="submit" className="btn btn-primary btn-xl">Login</button>
                                </div>
                                </form>
                  </div>
              </div>
  </div>
</section>
    );
  }
}


export default Login;