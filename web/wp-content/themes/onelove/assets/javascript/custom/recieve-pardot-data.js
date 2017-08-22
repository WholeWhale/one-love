window.addEventListener('message',function(event){
  if(event.origin !== 'https://go.pardot.com') return;
  var first_name = event.data.toString().indexOf('first_name');
  var last_name  = event.data.toString().indexOf('last_name');
  if ( first_name > -1 ) {
    document.querySelectorAll('.membership-card-firstName')[0].innerHTML = event.data.substr(event.data.indexOf(":") + 1);
  } else if (last_name > -1) {
    document.querySelectorAll('.membership-card-lastName')[0].innerHTML = event.data.substr(event.data.indexOf(":") + 1);
  }
},true);
