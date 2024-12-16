<header class="bg-white shadow-lg">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex-1 md:flex md:items-center md:gap-12">
                <a class="block text-teal-600" href="#">
                    <span class="sr-only">Home</span>
                    <img src="../images/logo-black.png" class="h-28">
                </a>
            </div>

            <div class="md:flex md:items-center md:gap-12">
                <nav aria-label="Global" class="hidden md:block">
                    <ul class="flex items-center gap-6 text-sm">
                        <li>
                            <a class="text-gray-500 transition hover:text-black font-poppins" href="../now_showing.php"> Now Showing</a>
                        </li>
                        <li>
                            <a class="text-gray-500 transition hover:text-black font-poppins" href="../about.php"> About </a>
                        </li>
                        <li>
                            <a class="text-gray-500 transition hover:text-black font-poppins" href="../our_team.php"> Our Team </a>
                        </li>
                        <li>
                            <a class="text-gray-500 transition hover:text-black font-poppins" href="../contact_us.php"> Contact Us </a>
                        </li>
                    </ul>
                </nav>

                <div class="flex items-center gap-4">
                    <?php
                    if (isset($_SESSION['uemail'])) {
                    ?>
                        <div class="sm:flex sm:gap-4">
                            <div class="relative group">
                                <a
                                    class="rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white shadow font-poppins font-bold"
                                    href="#">
                                    My Profile
                                </a>
                                <ul class="absolute hidden group-hover:block bg-white border border-gray-200 rounded-md shadow-lg mt-2 py-2 w-48 z-50">
                                    <li>
                                        <a
                                            href="../profile.php"
                                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition">
                                            View Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="../logout.php"
                                            class="block px-4 py-2 text-red-600 hover:bg-gray-100 transition">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php
                    } else { ?>
                        <div class="sm:flex sm:gap-4">
                            <a
                                class="rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white shadow font-poppins font-bold"
                                href="../login.php">
                                Login
                            </a>

                            <div class="hidden sm:flex">
                                <a
                                    class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 font-poppins font-bold"
                                    href="../register.php">
                                    Register
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="block md:hidden">
                        <button class="rounded bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="size-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>