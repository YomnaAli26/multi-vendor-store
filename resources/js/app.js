import './bootstrap';
import './cart.js'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


var channel = Echo.private(`App.Models.User.${userID}`);
channel.notification( function(data) {
    console.log(data);
    alert(JSON.stringify(data));
});
