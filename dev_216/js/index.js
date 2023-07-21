// JavaScript code
$(document).ready(function () {
  const darkModeSwitch = $("#darkModeSwitch");
  const darkModeKey = "darkModeState";

  // Retrieve the dark mode state from Local Storage on page load
  const savedDarkModeState = localStorage.getItem(darkModeKey);
  if (savedDarkModeState === "true") {
    enableDarkMode();
    darkModeSwitch.prop("checked", true);
  }

  darkModeSwitch.click(function () {
    // Toggle the dark mode class
    $("body, footer, header, div, main").toggleClass("dark-mode");

    // Save the dark mode state to Local Storage
    const isDarkModeEnabled = $("body").hasClass("dark-mode");
    localStorage.setItem(darkModeKey, isDarkModeEnabled);
  });

  function enableDarkMode() {
    $("body, footer, header, div, main").addClass("dark-mode");
  }
  // Fetch the list of cities from city.json file using AJAX
  $.getJSON('city.json', function(data) {
    const cities = data.Israel;

    // Function to filter cities based on the user's search input
    function filterCities(searchText) {
      $('.parkingSection').each(function() {
        const sectionName = $(this).find('.SectionName').text().trim();
        const display = sectionName.toLowerCase().includes(searchText.toLowerCase()) ? 'block' : 'none';
        $(this).css('display', display);
      });
    }

    // Event listener for the search input field
    $('#search-input').on('input', function() {
      const searchText = $(this).val();
      filterCities(searchText);
    });

    // Initial display of cities (show all)
    filterCities(''); // Empty search text displays all cities initially
  });
});



// Use jQuery to handle the signout link click event
$('#signout-link').click(function(event) {
  event.preventDefault();
  var confirmation = confirm('Are you sure you want to sign out?');
  if (confirmation) {
    $('#signout-form').submit();
  }
});
function submitRating(radio) {
  var rating = radio.value;

  // Send an AJAX request to save the rating to the database
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          // Rating saved successfully
          console.log("Rating saved successfully");
          location.reload(); // Refresh the page to update the ratings display
      }
  };
  xhttp.open("POST", "", true); // Submit the rating to the same page (mainObject.php)
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("rate=" + rating);
}

function switchCard() {
  const loginCard = document.querySelector('.container .card:nth-child(1)');
  const registerCard = document.querySelector('.container .card:nth-child(2)');

  if (loginCard.style.display === 'none') {
    loginCard.style.display = 'block';
    registerCard.style.display = 'none';
  } else {
    loginCard.style.display = 'none';
    registerCard.style.display = 'block';
  }
}

function clearSearch() {
  document.getElementsByName("city")[0].value = "";
}

  function toggleUserDetails() {
        const userDetails = document.querySelector('.user-details');
        userDetails.style.display = userDetails.style.display === 'none' ? 'block' : 'none';
    }

    // Add click event listener to the profile image
    const profileImage = document.querySelector('.profileImage');
    profileImage.addEventListener('click', toggleUserDetails);

    const searchFocus = document.getElementById('search-focus');
const keys = [
  { keyCode: 'AltLeft', isTriggered: false },
  { keyCode: 'ControlLeft', isTriggered: false },
];

window.addEventListener('keydown', (e) => {
  keys.forEach((obj) => {
    if (obj.keyCode === e.code) {
      obj.isTriggered = true;
    }
  });

  const shortcutTriggered = keys.filter((obj) => obj.isTriggered).length === keys.length;

  if (shortcutTriggered) {
    searchFocus.focus();
  }
});

window.addEventListener('keyup', (e) => {
  keys.forEach((obj) => {
    if (obj.keyCode === e.code) {
      obj.isTriggered = false;
    }
  });
});