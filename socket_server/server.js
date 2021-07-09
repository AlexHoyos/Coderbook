const express = require('express');

const API_URL = "http://localhost:8000/"

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
//lol

var users = {}

io.on('connection', (socket) => {
    //console.log(socket.id)
    let clientdata = socket.handshake.auth

    /* USER AUTHENTICATION */
    if(clientdata.type == 'user'){
        axios.get(API_URL + 'users/'+clientdata.uid, {
          headers: {
            'Content-Type': 'application/json',
            user_id: clientdata.uid,
            api_token: clientdata.api_token
          }
        }).then(res => {
            
            socket.fullname = res.data.name + ' ' + res.data.lname
            socket.profile_pic = (res.data.profile_pic) ? res.data.profile_pic.url : 'default.png'

            if(users['user-'+clientdata.uid] == undefined){
              users['user-'+clientdata.uid] = {}
            }

            users['user-'+clientdata.uid][socket.id] = socket


            /* ON POST REACTION */
            socket.on('post_react', (data) => {
              if(users['user-'+data.user_id] != undefined){
                /*users['user-'+data.user_id].emit('post_react', {
                  body: '<b>' + socket.fullname + '</b> reaccionó a tu publicación',
                  img: socket.profile_pic,
                  reaction: data.reaction
                })*/
                userEmit(data.user_id, 'post_react', {
                  body: '<b>' + socket.fullname + '</b> reaccionó a tu publicación',
                  img: socket.profile_pic,
                  reaction: data.reaction
                })
              }

            })

            /* END POST REACTION */

            /* ON USER MESSAGE */
            socket.on('message', (msg) => {

              console.log(msg)
              let config = getAuthConfig(socket);
              // Send Message
              axios.post(API_URL + 'user/messages/'+msg.target_id,
              {message: msg.message},
              {headers: config}
              ).then(res => {
                  //socket.emit('message', res.data)

                  userEmit(clientdata.uid, 'message', res.data)
                  userEmit(msg.target_id, 'message', res.data)
                  

              }).catch(error => {
                  console.log('Error while sending message...')
                  console.log(error)
              })

            })
            /* END USER MESSAGE */

            socket.on('disconnect', () => {
              delete users['user-'+clientdata.uid][socket.id]
            })

            //console.log(users['user-'+clientdata.uid])

        }).catch((error) => {
          // Kill Connection
          console.log(error)
            socket.disconnect();
        })
    }
    /* END AUTH */
    

  });

server.listen(3000, () => {
  console.log('listening on *:3000');
});

function getAuthConfig(socket){
  let clientdata = socket.handshake.auth
  let config = {
    user_id: clientdata.uid,
    api_token: clientdata.api_token
  }
  return config
}

function userEmit(uid, name, data){
    if(users['user-'+uid] != undefined){

      let userSockets = users['user-'+uid]
      for(const socketid in userSockets){
        userSockets[socketid].emit(name, data)
      }

    }
}