window.addEventListener('DOMContentLoaded', () => {
  const formCreateClient = document.querySelector('#create-client');
  const clCompanyName = formCreateClient.querySelector('#client-company-name');
  const clName = formCreateClient.querySelector('#client-name');
  const clSurname = formCreateClient.querySelector('#client-surname');
  const clDisplayName = formCreateClient.querySelector('#client-display-name');
  const clCountryCode = formCreateClient.querySelector('#client-country-code');
  const clCountry = formCreateClient.querySelector('#client-country');
  const clState = formCreateClient.querySelector('#client-state');
  const clCf = formCreateClient.querySelector('#client-cf');
  const clPec = formCreateClient.querySelector('#client-pec');
  var clCountryCodeVal = '';
  
  // create display name
  formCreateClient.querySelectorAll('.input-client-name').forEach(inputField => {
    inputField.addEventListener('change', () => {
      var curInput = inputField.value;
      if(clCompanyName.value > '') {
        clDisplayName.value = clCompanyName.value;
      }
      else if(clName.value > '' || clSurname.value > '') {
        clDisplayName.value = clName.value + ' ' + clSurname.value;
      }
      else {
        clDisplayName.value = '';
      }
    });
  });

  // set default values for countries outside Italy
  clCountryCode.addEventListener('change', (e) => {
    let inputVal = e.target.value;
    var funOutput = globalFun.splitCountryCode(inputVal);
    var clCountryCodeVal = funOutput[0];
    clCountry.value = funOutput[1];

    if(clCountryCodeVal == 'IT') {
      clState.parentElement.setAttribute('data-state', 'is-opened');
      clCf.parentElement.setAttribute('data-state', 'is-opened');
      clPec.parentElement.setAttribute('data-state', 'is-opened');
    }
    else {
      clState.parentElement.setAttribute('data-state', 'is-closed');
      clCf.parentElement.setAttribute('data-state', 'is-closed');
      clPec.parentElement.setAttribute('data-state', 'is-closed');
    }
  });

});