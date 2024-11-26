<!DOCTYPE html>
<html lang="en" data-theme="nord">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css">
    <script src="./js/script.js"></script>
    <script src="https://kit.fontawesome.com/ef6e01e8ad.js" crossorigin="anonymous"></script>
    <link rel="icon" href="./images/logo.png" type="image/x-icon">
    <title>Los Mojito's Entertainment | About</title>
</head>

<body>
    <!-- Header Section -->
    <?php
    include './includes/header.php';
    ?>



    <!-- Content Section -->
    <!-- Features -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="relative p-6 md:p-16">
            <!-- Grid -->
            <div class="relative z-10 lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
                <div class="mb-10 lg:mb-0 lg:col-span-6 lg:col-start-8 lg:order-2">
                    <h2 class="text-2xl text-gray-800 font-bold sm:text-3xl">
                        Make your Movie Reservation much easier
                    </h2>

                    <!-- Tab Navs -->
                    <nav class="grid gap-4 mt-5 md:mt-10" aria-label="Tabs" role="tablist">
                        <button type="button" class="tab-button bg-white shadow-md text-start p-4 md:p-5 rounded-xl" data-tab="1">
                            <span class="flex gap-x-6">
                                <svg class="shrink-0 mt-2 size-6 md:size-7 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path>
                                    <path d="M8.5 16h7a4.5 4.5 0 0 1 4.5 4.5V21H4v-.5A4.5 4.5 0 0 1 8.5 16z"></path>
                                </svg>
                                <span class="grow">
                                    <span class="block text-lg font-semibold text-blue-600">User Friendly</span>
                                    <span class="block mt-1 text-gray-800">This website helps users make advanced reservations efficiently, ensuring a smooth and intuitive experience.</span>
                                </span>
                            </span>
                        </button>

                        <button type="button" class="tab-button text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl" data-tab="2">
                            <span class="flex gap-x-6">
                                <svg class="shrink-0 mt-2 size-6 md:size-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 1v6h-8" />
                                    <path d="M20.49 9A9 9 0 1 1 12 3h1" />
                                </svg>
                                <span class="grow">
                                    <span class="block text-lg font-semibold text-gray-800">Real-Time Updates</span>
                                    <span class="block mt-1 text-gray-800">Stay informed with the latest movie schedules and seat availability.</span>
                                </span>
                            </span>
                        </button>


                        <button type="button" class="tab-button text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl" data-tab="3">
                            <span class="flex gap-x-6">
                                <svg class="shrink-0 mt-2 size-6 md:size-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="5" width="20" height="14" rx="2" ry="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                    <line x1="6" y1="15" x2="10" y2="15" />
                                </svg>
                                <span class="grow">
                                    <span class="block text-lg font-semibold text-gray-800">Multiple Payment Options</span>
                                    <span class="block mt-1 text-gray-800">Pay with ease using various secure payment methods.</span>
                                </span>
                            </span>
                        </button>

                    </nav>
                    <!-- End Tab Navs -->
                </div>

                <div class="lg:col-span-6">
                    <div class="relative">
                        <!-- Tab Content -->
                        <div>
                            <div id="tab-1" class="tab-content">
                                <img class="shadow-xl shadow-gray-200 rounded-xl" src="/api/placeholder/560/720" alt="Features Image">
                            </div>

                            <div id="tab-2" class="tab-content hidden">
                                <img class="shadow-xl shadow-gray-200 rounded-xl" src="/api/placeholder/560/720" alt="Features Image">
                            </div>

                            <div id="tab-3" class="tab-content hidden">
                                <img class="shadow-xl shadow-gray-200 rounded-xl" src="/api/placeholder/560/720" alt="Features Image">
                            </div>
                        </div>

                        <!-- SVG Element -->
                        <div class="hidden absolute top-0 end-0 translate-x-20 md:block lg:translate-x-20">
                            <svg class="w-16 h-auto text-red-500" width="121" height="135" viewBox="0 0 121 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor" stroke-width="10" stroke-linecap="round" />
                                <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor" stroke-width="10" stroke-linecap="round" />
                                <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor" stroke-width="10" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Color -->
            <div class="absolute inset-0 grid grid-cols-12 size-full">
                <div class="col-span-full lg:col-span-7 lg:col-start-6 bg-gray-100 w-full h-5/6 rounded-xl sm:h-3/4 lg:h-full"></div>
            </div>
        </div>
    </div>



    <!-- Footer Section -->
    <?php
    include './includes/footer.php';
    ?>

    <script>
        // Get all tab buttons and content
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        // Add click event to each tab button
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabNumber = button.getAttribute('data-tab');

                // Remove active classes from all buttons and contents
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-white', 'shadow-md');
                    btn.classList.add('hover:bg-gray-200');
                    const svg = btn.querySelector('svg');
                    const title = btn.querySelector('.font-semibold');
                    svg.classList.remove('text-blue-600');
                    svg.classList.add('text-gray-800');
                    title.classList.remove('text-blue-600');
                    title.classList.add('text-gray-800');
                });

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Add active classes to clicked button and corresponding content
                button.classList.add('bg-white', 'shadow-md');
                button.classList.remove('hover:bg-gray-200');
                const activeSvg = button.querySelector('svg');
                const activeTitle = button.querySelector('.font-semibold');
                activeSvg.classList.add('text-blue-600');
                activeSvg.classList.remove('text-gray-800');
                activeTitle.classList.add('text-blue-600');
                activeTitle.classList.remove('text-gray-800');

                document.getElementById(`tab-${tabNumber}`).classList.remove('hidden');
            });
        });

        // Set first tab as active by default
        tabButtons[0].click();
    </script>

</body>

</html>