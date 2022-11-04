window.addEventListener('DOMContentLoaded', () => {
  const formCreateClient = document.querySelector('#create-client');
  const clCompanyName = formCreateClient.querySelector('#company_name');
  const clName = formCreateClient.querySelector('#name');
  const clSurname = formCreateClient.querySelector('#surname');
  const clDisplayName = formCreateClient.querySelector('#display_name');
  const clCountrySelect = formCreateClient.querySelector('#country_select');
  const clCountryCode = formCreateClient.querySelector('#country_code');
  const clCountry = formCreateClient.querySelector('#country');
  const clState = formCreateClient.querySelector('#state');
  const clCf = formCreateClient.querySelector('#cf');
  const clPec = formCreateClient.querySelector('#pec');
  
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
  function toggleFieldsItalyOnly() {
    if(clCountryCode.value == 'IT') {
      clState.parentElement.setAttribute('data-state', 'is-opened');
      clCf.parentElement.setAttribute('data-state', 'is-opened');
      clPec.parentElement.setAttribute('data-state', 'is-opened');
    }
    else {
      clState.parentElement.setAttribute('data-state', 'is-closed');
      clCf.parentElement.setAttribute('data-state', 'is-closed');
      clPec.parentElement.setAttribute('data-state', 'is-closed');
    }
  }
  window.splitCountryCode(clCountrySelect.value, clCountryCode, clCountry);
  toggleFieldsItalyOnly();
  clCountrySelect.addEventListener('change', (e) => {
    let inputVal = e.target.value;
    window.splitCountryCode(inputVal, clCountryCode, clCountry);
    toggleFieldsItalyOnly();
  });

});