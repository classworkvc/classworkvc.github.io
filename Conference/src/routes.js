const path = require('path')
const express = require('express')

module.exports = (app) => {

    // redirect http traffic to https traffic
    app.use('https://secure-journey-67043.herokuapp.com/', (req, res, next) => {
        if(!req.socket.encrypted){
            console.log('unsecure connection: redirecting..')
            res.redirect('https://' + req.headers.host + req.path)
        } else {
            next()
        }
    })

    app.use(express.static(path.join(__dirname, '..','public')))
    app.use(express.static(path.join(__dirname, '..','node_modules')))
}