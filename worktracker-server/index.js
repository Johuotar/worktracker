var express = require("express");
var mysql = require("mysql");
// const asiakas = require('./routes/asiakas')
var cors = require('cors');
var bodyParser = require('body-parser');

var connection = mysql.createConnection({
host: 'localhost',
user: 'worktrackAdmin',
password: 'WAdmin',
database: 'worktracker'
});

var app = express();
    
    app.use(cors())
    app.use(bodyParser.json())


connection.connect(
    function(err) 
    {
        if(!err) {
            console.log("DB is connected")
            } else {
            console.log("Virhe kannan yhteyden muodostamisessa")
            }
    }
);


app.post("/login", function(req, res){

    const mypassword = req.body.mypassword;
    const myusername = req.body.myusername;
    console.log(req.body)
    console.log(mypassword)
    console.log(myusername)
    // const {kayttajatunnus, salasana} = req.query;

    // const sqlLause = "SELECT kayttajaID FROM kayttaja WHERE kayttajatunnus = " + connection.escape(myusername) 
    //        + " and salasana = password(" + connection.escape(mypassword) + ");";

    const sqlLause = "SELECT b.henkiloID, b.sukunimi, b.etunimi, e.rooli, b.asiakasID, bb.nimi, bb.tyyppi"
            + " FROM kayttaja a, henkilo b, asiakas bb, henkilonRooli c, rooli e"
            + " WHERE a.kayttajatunnus = " + connection.escape(myusername) 
            + " and a.salasana = password(" + connection.escape(mypassword) + ")"
            + " and a.kayttajatunnus=b.sposti"
            + " and b.asiakasID=bb.asiakasID"
            + " and b.henkiloID=c.henkiloID"
            + " and c.rooliID=e.rooliID;"            

    connection.query(sqlLause, 
                    function(err,rows,fields)
        {    console.log(rows)
            res.json(rows);
        // if(!err) { // console.log("tulosjoukko: ", rows);
        //             // console.log("kentat: ", fields);
        //             res.json(rows);
        //         } 
        // else console.log("Kayttaja login: virhe haun yhteydessä");
    });
    }
);


app.get("/asiakas", function(req, res){
    
        connection.query('select * from asiakas;', function(err,rows,fields){
            // connection.end();
            if(!err) {console.log("tulosjoukko: ", rows);
                        // console.log("kentat: ", fields);
                        res.json(rows);
                    } 
            else console.log("Asiakas: virhe haun yhteydessä");
        });
        }
);


app.get("/projekti", function(req, res){
    connection.query('select * from projekti ;', function(err,rows,fields){
        // connection.end();
        if(!err) {console.log("tulosjoukko: ", rows);
                    // console.log("kentat: ", fields);
                    res.json(rows);
                } 
        else console.log("Projekti: virhe haun yhteydessä");
    });
    }
);

// connection.end();

app.listen(5000);