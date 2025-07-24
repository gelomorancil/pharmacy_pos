// var socket = io.connect('http://' + window.location.hostname + ':1000');
// // socket.on('connectToRoom',function(data) {
// //     console.log(data);
// // });
// socket.on('connectToRoom',function(data) {
//     console.log(data);
//  });


// const socket = io('http://' + window.location.hostname + ':1000');
// let username = 'admin';
// let room = 'room_' + session.city_id;
// Join chatroom
// socket.emit('joinRoom', { username, room });

// Get room and users
// socket.on('roomUsers', ({ room, users }) => {
    //   outputRoomName(room);
    //   outputUsers(users);
// });

// function update_notiflist(data) {
    // var notif_html = '<li class="list-group-item cyan-50 lt box-shadow-z0 b" >'+
    //                   '<a class="notif"  data-notif-id="'+data.notif.id+'">'+
    //                     '<span class="clear block">'+
    //                       '<label style="font-weight: bold;"> '+data.sender.info.name+' '+'</label> <br>'+
    //                       '<small class="text-muted">'+data.person.name+' </small>'+
    //                     '</span>'+
    //                   '</a>'+
    //                 '</li>';
//     var notif_html = '<li class="list-group-item green-100 lt box-shadow-z0 b">' +
//         '<a class="notif" data-prname="'+ data.person.name +'" data-praddress="'+ data.sender.info.name +'" data-notif-id="' + data.notif.id + '">' +
//         '<span class="clear block">' +
//         '<label style="font-weight: bold;"> </label> <b>' + data.sender.info.name + ' ' + data.sender.info.branch + '</b> <br>' +
//         '</span>' +
//         '<small>' + data.person.name + '</small>' +
//         '</a>' +
//         '</li>';
//     $('#notif-lists').prepend(notif_html);
//     update_grids(data);
//     playSound("notif");

// }

function update_grids(data) {
    var row_html = '<tr class="tb" data-id="' + data.notif.id + '">' +
        '<td>' + data.sender.info.name + ' ' + data.sender.info.branch + '</td>' +
        '<td>' + data.sender.info.address + '</td>' +
        '<td>' + data.person.name + '</td>' +
        '<td>' + data.person.status + '</td>' +
        '<td><i class="fa fa-times" style="color:red"></i></td>' +
        '<td><button class="btn btn-primary btn-md clicked-reply" data-id="' + data.notif.id + '" data-personid="' + data.person.ID + '" data-estabid="' + data.sender.info.id + '" data-toggle="modal" data-target="#reply_modal">REPLY</button></td>' +
        '</tr>';
    $('#load-notification-list').prepend(row_html);
       
}
// Message from server
let notifications = [];
// Message from server
// socket.on('message', message => {
//     if (message.text.sender.from === 'establishment') {
//         notifications.push(message.text);
//         update_notiflist(message.text);
//         $('#notif-count').show();
//         $('#notif-count').text(notifications.length);      
//         personName =  message.text.person.name;
//         estabName = message.text.sender.info.name;        
//     }
    
// });