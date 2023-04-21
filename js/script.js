

function ready(fn) {
    if (document.readyState !== 'loading') {
        fn();
        return;
    }
    document.addEventListener('DOMContentLoaded', fn);
}



ready(() => {

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    })

    document.getElementById('form').addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        if (!validateForm()) {
            return;
        }

        // Send a POST request to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "php/index.php?endpoint=attendant");
        xhr.onload = function () {
            // Handle the server response
            console.log(xhr.responseText);
        };

        xhr.send(formData);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 201) {
                    // AJAX request successful
                    console.log(xhr.responseText);

                    var successModal = new bootstrap.Modal(document.getElementById('success-modal'));
                    successModal.show();
                    getAttendants();

                } else {
                    // AJAX request failed
                    console.log(xhr.responseText);
                    // Show error modal
                    var errorModal = new bootstrap.Modal(document.getElementById('error-modal'));
                    let errorText = JSON.parse(xhr.responseText).message;
                    document.getElementById('error-body').innerText = errorText;
                    errorModal.show();
                }
            }
        };
    })

    getAttendants();

});

function validateForm() {
    const name = document.getElementsByName('name')[0].value;
    const email = document.getElementsByName('email')[0].value;
    const age = document.getElementsByName('age')[0].value;
    const gender = document.getElementsByName('gender')[0].value;
    const nationality = document.getElementsByName('nationality')[0].value;
    const ticketType = document.getElementsByName('ticketType')[0].value;

    let errors = [];

    if (!name) {
        errors.push('Name is required');
    }

    if (!email) {
        errors.push('Email is required');
    } else if (!/\S+@\S+\.\S+/.test(email)) {
        errors.push('Email is invalid');
    }

    if (!age) {
        errors.push('Age is required');
    } else if (age < 0) {
        errors.push('Age must be a positive number');
    }

    if (!gender) {
        errors.push('Gender is required');
    }

    if (!nationality) {
        errors.push('Nationality is required');
    }

    if (!ticketType) {
        errors.push('Ticket type is required');
    }

    if (errors.length > 0) {

        // Show error modal
        var errorModal = new bootstrap.Modal(document.getElementById('error-modal'));
        document.getElementById('error-body').innerText = errors.join('\n');
        errorModal.show();

        return false;
    }

    return true;
}

function getAttendants() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/index.php?endpoint=attendant');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const attendants = JSON.parse(xhr.responseText);
            fillTable(attendants);
        }
    };

    xhr.send();
}

function fillTable(attendants) {
    const tableBody = document.querySelector('table tbody');
    tableBody.innerHTML = '';

    // Loop through each attendant and add it to the table
    attendants.forEach((attendant) => {
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${attendant.name}</td>
        <td>${attendant.email}</td>
        <td>${attendant.age}</td>
        <td>${attendant.gender}</td>
        <td>${attendant.nationality}</td>
        <td>${attendant.ticket_type}</td>
      `;
        tableBody.appendChild(row);
    });
}



