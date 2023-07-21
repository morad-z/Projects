function validateForm() {
    var country = document.forms["reservationForm"]["country"].value;
    var city = document.forms["reservationForm"]["city"].value;
    var streetNumber = document.forms["reservationForm"]["streetNumber"].value;
    var size = document.forms["reservationForm"]["size"].value;
    var howToGetIn = document.forms["reservationForm"]["howToGetIn"].value;
    var date = document.forms["reservationForm"]["date"].value;
    var startHour = document.forms["reservationForm"]["startHour"].value;
    var endHour = document.forms["reservationForm"]["endHour"].value;

    if (country == "") {
      alert("Please enter the country.");
      return false;
    }

    if (city == "") {
      alert("Please enter the city.");
      return false;
    }

    if (streetNumber == "") {
      alert("Please enter the street number.");
      return false;
    }

    if (size == "") {
      alert("Please enter the size.");
      return false;
    }

    if (howToGetIn == "") {
      alert("Please enter the instructions on how to get in.");
      return false;
    }

    if (date == "") {
      alert("Please enter the date.");
      return false;
    }

    if (startHour == "") {
      alert("Please enter the start hour.");
      return false;
    }

    if (endHour == "") {
      alert("Please enter the end hour.");
      return false;
    }
    return true;
  }