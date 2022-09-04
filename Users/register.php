<?php
include("../HTML/header.php");
?>

<script src="https://cdn.tailwindcss.com"></script>
<!doctype html>
<form action="insert_user.php" method="post">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
        <div class="relative bg-white pt-10 pb-8 px-10 shadow-xl mx-auto w-96 rounded-lg">
            <div class="divide-y divide-gray-300/50 w-full">
                <div class="space-y-6 py-8 text-base  text-gray-600">

                    <?php if (isset($_GET['message'])): ?>
                        <p class="text-sm text-red-500"><?= $_GET['message']; ?></p>
                    <?php endif; ?>

                    <p class="text-xl font-medium leading-7">RextopiA Login</p>
                    <div class="space-y-4 flex flex-col">
                        <input type="text"
                               name="char_name"
                               placeholder="Chatracter Name"
                               class="border border-gray-300/50 p-1 rounded focus:outline-none"
                               required
                               />

                        <input type="password"
                               name="password"
                               placeholder="Password"
                               class="border border-gray-300/50 p-1 rounded focus:outline-none"
                               required
                               />

                        <input type="password"
                               name="password_repeat"
                               placeholder="Re-enter Password"
                               class="border border-gray-300/50 p-1 rounded focus:outline-none"
                               required
                               />
                    </div>
                </div>
                <div class="pt-8 text-base font-semibold leading-7">
                    <button type="submit" class="btn btn-outline-primary">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>