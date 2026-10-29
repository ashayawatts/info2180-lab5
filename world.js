
document.addEventListener('DOMContentLoaded', function () {
    const lookupButton = document.getElementById('lookup');
    const citiesButton = document.getElementById('lookup-cities');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    lookupButton.addEventListener('click', function () {
        const country = countryInput.value;

        fetch('world.php?country=' + encodeURIComponent(country))
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                resultDiv.innerHTML = data;
            })
            .catch(function (error) {
                resultDiv.textContent = 'Error: ' + error.message;
            });
    });

    citiesButton.addEventListener('click', function () {
        const country = countryInput.value;

        fetch('world.php?lookup=cities&country=' + encodeURIComponent(country))
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                resultDiv.innerHTML = data;
            })
            .catch(function (error) {
                resultDiv.textContent = 'Error: ' + error.message;
            });
    });
});
