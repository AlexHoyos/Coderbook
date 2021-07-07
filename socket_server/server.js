const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const axios = require('axios')
const io = require("socket.io")(server, {
  cors: {
    origin: "http://localhost",
    methods: ["GET", "POST"]
  }
});
//const io = new Server(server);

var users = {}

io.on('connection', (socket) => {
    console.log(socket.handshake.auth)
    let clientdata = socket.handshake.auth

    /* USER AUTHENTICATION */
    if(clientdata.type == 'user'){
        axios.get('http://localhost:8000/users/'+clientdata.uid, {
          headers: {
            'Content-Type': 'application/json',
            user_id: clientdata.uid,
            api_token: clientdata.api_token
          }
        }).then(res => {
            console.log(res.status)
            socket.fullname = res.data.name + ' ' + res.data.lname
            socket.profile_pic = res.data.profile_pic.url
            if(users['user-'+clientdata.uid] != undefined && users['user-'+clientdata.uid] != socket){
              //console.log('other user');
                users['user-'+clientdata.uid].emit('session_end', {message:'Se ha iniciado sesión en otro dispositivo'})
                users['user-'+clientdata.uid].disconnect();
                users['user-'+clientdata.uid] = socket
            } else {
                users['user-'+clientdata.uid] = socket
            }


            /* ON POST REACTION */
            socket.on('post_react', (data) => {
              if(users['user-'+data.user_id] != undefined){
                users['user-'+data.user_id].emit('post_react', {
                  body: '<b>' + socket.fullname + '</b> reaccionó a tu publicación',
                  img: socket.profile_pic,
                  reaction: data.reaction
                })
              }

            })

            /* END POST REACTION */

            socket.on('message', (msg) => {
              console.log(msg)
            })

            socket.on('disconnect', () => {
              users['user-'+clientdata.uid] = undefined
            })

            //console.log(users['user-'+clientdata.uid])

        }).catch((error) => {
          // Kill Connection
            socket.disconnect();
        })
    }
    /* END AUTH */
    

  });

server.listen(3000, () => {
  console.log('listening on *:3000');
});