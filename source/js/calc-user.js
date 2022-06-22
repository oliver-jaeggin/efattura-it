window.addEventListener('DOMContentLoaded', () => {
  const formCreateUser = document.querySelector('#create-user');
  const uCountryCode = formCreateUser.querySelector('#user-country-code');
  const uCountry = formCreateUser.querySelector('#user-country');

  uCountryCode.addEventListener('change', (e) => {
    let inputVal = e.target.value;
    var funOutput = globalFun.splitCountryCode(inputVal);
    uCountry.value = funOutput[1];
  });
});