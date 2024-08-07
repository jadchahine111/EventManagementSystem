<?php
session_start();

if (empty($_GET['lang'])) {
    $_SESSION['lang'] = "en"; // Important default language
} else {
    switch ($_GET['lang']) {
        case "sp":
            $_SESSION['lang'] = "sp";
            break;
        case "en":
            $_SESSION['lang'] = "en";
            break;
        case "fr":
            $_SESSION['lang'] = "fr";
            break;
        default:
            $_SESSION['lang'] = "en"; // Important default language
            break;
    }
}

switch ($_SESSION['lang']) {
    case "sp":
        $fichier_langage = "lang/sp.php"; // link to language file
        break;
    case "en":
        $fichier_langage = "lang/en.php"; // link to language file
        break;
    case "fr":
        $fichier_langage = "lang/fr.php"; // link to language file
        break;
}

include($fichier_langage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventLU</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Poppins Medium from Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">

</head>
<style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .team-card {
        width: 250px; /* Adjust the width as needed */
        height: 350px; /* Adjust the height as needed */
        }


</style>
<body>


    
<!--NAVBAR-->
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse font-poppins">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><path fill="blue" d="M32.25 6H29v2h3v22H4V8h3V6H3.75A1.78 1.78 0 0 0 2 7.81v22.38A1.78 1.78 0 0 0 3.75 32h28.5A1.78 1.78 0 0 0 34 30.19V7.81A1.78 1.78 0 0 0 32.25 6Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="blue" d="M8 14h2v2H8z" class="clr-i-outline clr-i-outline-path-2"/><path fill="blue" d="M14 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-3"/><path fill="blue" d="M20 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-4"/><path fill="blue" d="M26 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-5"/><path fill="blue" d="M8 19h2v2H8z" class="clr-i-outline clr-i-outline-path-6"/><path fill="blue" d="M14 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-7"/><path fill="blue" d="M20 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-8"/><path fill="blue" d="M26 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-9"/><path fill="blue" d="M8 24h2v2H8z" class="clr-i-outline clr-i-outline-path-10"/><path fill="blue" d="M14 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-11"/><path fill="blue" d="M20 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-12"/><path fill="blue" d="M26 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-13"/><path fill="blue" d="M10 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" class="clr-i-outline clr-i-outline-path-14"/><path fill="blue" d="M26 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" class="clr-i-outline clr-i-outline-path-15"/><path fill="blue" d="M13 6h10v2H13z" class="clr-i-outline clr-i-outline-path-16"/><path fill="none" d="M0 0h36v36H0z"/></svg>
            <span class= "md:self-center text-2xl font-bold whitespace-nowrap  dark:text-white">EvLU</span>
        </a>
        <div class="flex items-center gap-0 md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        


            



            <a href="../src/login-user.php" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center">
                <span><?php echo $GetStarted ?></span>
            </a>            
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page"><?php echo $home ?></a>
                </li>
                <li>
                    <a href="#about" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><?php echo $about ?></a>
                </li>
                <li>
                    <a href="#team" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><?php echo $team ?></a>
                </li>
                <li>
                    <a href="#contact" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><?php echo $contact ?></a>
                </li>
                <li>
                <!--LANGUAGE SELECTOR-->
                <div class="relative">
                    <button
                        class="flex items-center space-x-1 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300"
                        id="language-selector"
                    >
                        <span class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><?php echo $Language?> </span>
                        <i class="ri-arrow-drop-down-fill"></i>
                    </button>
                
                    <div
                        class="absolute hidden mt-2 space-y-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-lg"
                        id="language-dropdown"
                    >
                    <a href="./index.php?lang=en" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><?php echo $English ?></a>
                    <a href="./index.php?lang=fr" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><?php echo $French ?></a>
                    <a href="./index.php?lang=sp" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><?php echo $Spanish ?></a>

                    </div>
                </div>
                </li>
            </ul>
        </div>
    </div>
</nav>



<!--HOME SECTION-->
<section class="home-section bg-gray-100 py-24 mt-14">
    <div class="container mx-auto flex items-center justify-between px-6 lg:px-24">
        <div class="content max-w-md">
            <h1 class="text-3xl md:text-4xl font-bold lg:text-5xl mb-9"><?php echo $welcome ?></h1>
            <p class="text-lg"><?php echo $explore ?></p>
        </div>
        <div class="max-w-lg h-[500px]"> <!-- Adjust height based on your preference -->
            <img src="your-event-image.jpg" alt="Event Management System" class="rounded-lg h-full w-full object-cover">
        </div>
    </div>
</section>



<!-- ABOUT SECTION -->
<section id="about" class="about-section bg-white py-24">
    <div class="container mx-auto px-6 lg:px-24">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-8"><?php echo $aboutT ?></h2>
            <p class="text-lg text-gray-700">
            <?php echo $about1 ?>
            </p>
            <p class="text-lg mt-4 text-gray-700">
            <?php echo $about2 ?>
            </p>
        </div>
    </div>
</section>

<!-- TEAM SECTION -->
<section id="team" class="team-section bg-gray-100 py-24">
    <div class="container mx-auto px-6 lg:px-24">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-12"><?php echo $meetT ?></h2>

        <!-- Team Cards Container -->
        <div class="flex flex-wrap justify-center gap-10">

            <!-- Team Card 1 -->
            <div class="team-card max-w-md bg-white rounded-lg overflow-hidden shadow-lg mb-8 flex flex-col justify-center items-center">
                <img src="jad-chahine.jpg" alt="Jad Chahine" class="w-full h-32 object-cover object-center mb-4">
                <div class="p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Jad Chahine</h3>
                    <p class="text-gray-600 text-sm mb-2"><?php echo $thirdCS ?></p>
                    <button class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-transform duration-300">
                    <?php echo $Portfolio ?>
                    </button>
                </div>
            </div>



            <!-- Add more team cards as needed -->

        </div>
    </div>
</section>

<!--CONTACT-->
<section class="bg-white dark:bg-gray-900" id="contact">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white"><?php echo $ContactUs ?></h2>
        <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl"><?php echo $ContactUs1 ?></p>

        <form method="post" id="contactForm" class="space-y-8">
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $emails ?></label>
                <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="name@ul.edu.lb" required name="email">
            </div>
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $names ?></label>
                <input type="text" id="name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="name" required name="name">
            </div>
            <div>
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $subjects ?></label>
                <input type="text" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="Let us know how we can help you" required name="subject">
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400"><?php echo $messages ?></label>
                <textarea id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Leave a comment..." name="message"></textarea>
            </div>
            <button type="submit" id="submitButton" class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-700 sm:w-fit hover:bg-blue-800" id="successButton" data-modal-target="successModal" data-modal-toggle="successModal"><?php echo $SendMessage ?></button>
        </form>
    </div>
</section>



<!--SUCCESS MODAL-->
<div id="successModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="successModal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 p-2 flex items-center justify-center mx-auto mb-3.5">
                <svg aria-hidden="true" class="w-8 h-8 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Success</span>
            </div>
            <p class="mb-4 text-lg font-semibold text-gray-900 dark:text-white"><?php echo $EmailSuccess ?></p>
            <button data-modal-toggle="successModal" type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-900">
            <?php echo $Continue ?>    
            </button>

        </div>
    </div>
</div>




<!-- FOOTER SECTION -->
<footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto flex flex-col items-center">
        <p class="mb-4 text-lg"><?php echo $rights ?></p>
        <div class="flex space-x-4">
            <a href="#" class="hover:text-gray-300"><?php echo $PrivacyPolicy ?></a>
            <a href="#" class="hover:text-gray-300"><?php echo $TermsofService ?></a>
            <a href="#" class="hover:text-gray-300"><?php echo $ContactUs ?></a>
        </div>
        <div class="mt-4 flex space-x-4">
            <!-- Social media icons from Tailwind CSS -->
            <a href="#" class="text-white hover:text-gray-300">
                <ion-icon name="logo-instagram"></ion-icon>
            </a>
            <a href="#" class="text-white hover:text-gray-300">
                <ion-icon name="logo-linkedin"></ion-icon>
            </a>
            <a href="#" class="text-white hover:text-gray-300">
                <ion-icon name="logo-facebook"></ion-icon>
            </a>
            <a href="#" class="text-white hover:text-gray-300">
                <ion-icon name="logo-github"></ion-icon>
            </a>
            <a href="#" class="text-white hover:text-gray-300">
                <ion-icon name="logo-twitter"></ion-icon>
            </a>
            <!-- Add more social media links as needed -->
        </div>
    </div>
</footer>








<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const languageSelector = document.getElementById('language-selector');
    const languageDropdown = document.getElementById('language-dropdown');
    const languageTitle = languageSelector.querySelector('span');

    languageSelector.addEventListener('click', () => {
        languageDropdown.classList.toggle('hidden');
    });

    // Set default language to English
    languageTitle.textContent = '<?php echo $Language ?>';

    // Close the dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!languageSelector.contains(event.target)) {
            languageDropdown.classList.add('hidden');
        }
    });

    // Update button text and close the dropdown when a language is selected
    languageDropdown.addEventListener('click', (event) => {
        if (event.target.tagName === 'A') {
            const selectedLanguage = event.target.textContent;
            languageTitle.textContent = selectedLanguage;
            languageDropdown.classList.add('hidden');

            // Redirect to the selected language page
            window.location.href = event.target.getAttribute('href');
        }
    });
});
</script>

<script>

    //FETCH API
    document.addEventListener('DOMContentLoaded', function () {
        const contactForm = document.getElementById('contactForm');
        const submitButton = document.getElementById('submitButton');

        // Function to toggle the success modal
        function toggleSuccessModal() {
            const successModal = document.getElementById('successModal');
            successModal.classList.toggle('hidden');
        }

        contactForm.addEventListener('submit', function (event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Your logic for handling the form submission using AJAX
            const formData = new FormData(contactForm);

            // Example using fetch API
            fetch('contact.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json()) // Assuming the response is in JSON format
            .then(data => {
                // Handle the response, show success modal, etc.
                console.log(data);
                toggleSuccessModal();
            })
            .catch(error => {
                // Handle errors, show error message, etc.
                console.error(error);
            });
        });

        // Your existing script for the language selector
        // ...
    });
</script>




</body>
</html>



