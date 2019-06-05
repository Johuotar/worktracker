const express = require('express')

const router = express.Router()

router.get("/asiakas", function(req, res){
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


module.exports = router