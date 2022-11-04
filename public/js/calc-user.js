window.addEventListener('DOMContentLoaded', () => {
  const formCreateUser = document.querySelector('#create-user');
  const CountrySelect = formCreateUser.querySelector('#country_select');
  const CountryCode = formCreateUser.querySelector('#country_code');
  const Country = formCreateUser.querySelector('#country');

  // split country code
  window.splitCountryCode(CountrySelect.value, CountryCode, Country);
  CountrySelect.addEventListener('change', (e) => {
    let inputVal = e.target.value;
    window.splitCountryCode(inputVal, CountryCode, Country);
  });
});