
const logout = () => {
    document.getElementById('logout_link').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        fetch('./php/logout.php')
            .then(response => {
                if (response.ok) {
                    // Optionally, handle successful logout (e.g., redirect to home)
                    window.location.href = './index.php'; // Redirect to the home page or login page
                } else {
                    // Handle errors if needed
                    alert('Logout failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
    });
}
const addEventToLink = () => {
    let home = document.getElementById('home_link');
    let login = document.getElementById('login_link');
    let registration = document.getElementById('registrierung_link');

    home.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        showHide(event);
    });

    login.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        showHide(event);
    });

    registration.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        showHide(event);
    });
}

const showHide = (event) => {
    let addTask = document.getElementById('addTask');
    let loginForm = document.getElementById('login');
    let registrationForm = document.getElementById('registration');

    switch (event.target.id) {
        case "home_link":
            addTask.style = "display: block;";
            loginForm.style = "display: none;";
            registrationForm.style = "display: none;";
            break;

        case "login_link":
            addTask.style = "display: none;";
            loginForm.style = "display: block;";
            registrationForm.style = "display: none;";
            break;

        case "registrierung_link":
            addTask.style = "display: none;";
            loginForm.style = "display: none;";
            registrationForm.style = "display: block;";
            break;

        default:
            addTask.style = "display: none;";
            loginForm.style = "display: none;";
            registrationForm.style = "display: none;";
            break;
    }
}
const applyFilter = () => {
    let filter = document.getElementById('filter').value;
    let sort = document.getElementById('sort').value;

    // Check if there are any filter and sort options in the URL query string
    if (window.location.href.search(/[?&]/g) != -1) {
        const values = window.location.href.split('?')[1].split('&');
        const filterValue = values[0].split('=')[1];
        const sortValue = values[1].split('=')[1];

        if (filterValue !== 'none' && filter === 'none')
            filter = filterValue;
        if (sortValue !== 'none' && sort === 'none')
            sort = sortValue;
    }

    // Redirect to the same page with the selected filter and sort options
    window.location.href = `./index.php?filter=${filter}&sort=${sort}`;
}

const init = () => {
    logout();
    addEventToLink();
}

// Call the init function when the document is fully loaded
init();