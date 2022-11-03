window.addEventListener('DOMContentLoaded', () => {
  const formCreateUser = document.querySelector('#create-user');
  const CountrySelect = formCreateUser.querySelector('#country_select');
  const CountryCode = formCreateUser.querySelector('#country_code');
  const Country = formCreateUser.querySelector('#country');

  // split country code
  function setCountryCode(selectedCountry) {
    var funOutput = window.splitCountryCode(selectedCountry);
    CountryCode.value = funOutput[0];
    Country.value = funOutput[1];
  }
  setCountryCode(CountrySelect.value);
  CountrySelect.addEventListener('change', (e) => {
    let inputVal = e.target.value;
    setCountryCode(inputVal);
  });
});