window.addEventListener('message',function(event){
  if(event.origin !== 'https://go.pardot.com') return;

  displayResult('first_name','.membership-card-firstName');
  displayResult('last_name','.membership-card-lastName');
  getFormSubmit();

  function displayResult(s,t) {
    var eventData = event.data.info;
    if (typeof eventData !== 'undefined') {
      var name = eventData.toString().indexOf(s);
      if (name > -1) {
        document.activeElement.parentNode.parentNode.querySelectorAll(t)[0].innerHTML = event.data.info.substr(event.data.info.indexOf(":") + 1);
      }
    }
  }

  function getFormSubmit() {
    var formSubmission = event.data.submit;
    if (typeof formSubmission !== 'undefined') {
      dataLayer.push({
        'submit': 'pardot form'
      });
    }
  }

},true);
