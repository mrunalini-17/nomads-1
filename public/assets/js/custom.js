
document.addEventListener('DOMContentLoaded', function() {
    var countrySelect = document.getElementById('country_id');
    var stateSelect = document.getElementById('state_id');
    var citySelect = document.getElementById('city_id');

    countrySelect.addEventListener('change', function() {
        var countryId = this.value;

        // Clear current state and city options
        stateSelect.innerHTML = '<option value="">Select State</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (countryId) {
            // Fetch states based on the selected country
            fetch('/get-states/' + countryId)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    // Populate state dropdown with fetched states
                    data.forEach(function(state) {
                        var option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name;
                        stateSelect.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error('There was a problem with fetch operation:', error);
                });
        }
    });

    stateSelect.addEventListener('change', function() {
        var stateId = this.value;

        // Clear current city options
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (stateId) {
            // Fetch cities based on the selected state
            fetch('/get-cities/' + stateId)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    // Populate city dropdown with fetched cities
                    data.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error('There was a problem with fetch operation:', error);
                });
        }
    });
});

