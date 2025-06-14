
<section id="login" class="mb-8 ">
    <h2 class="text-xl font-bold mb-4 text-orange-600 uppercase border-b border-gray-400">Login</h2>
    <h3 class="text-lg font-semibold mb-2">How to Log In</h3>
    <ol class="list-decimal pl-5 space-y-2">
        <li class="py-2">Open your web browser and go to <strong>ozamiz.deped.gov.ph/fms</strong>. You will be automatically redirected to the login page.
        <img src="<?= base_url('public/documentation/login_1.png') ?>" class="">
        </li>
        <li class="py-2">Enter your <strong>DAWN</strong> username and password and click the <strong>Login</strong> button.
        <img src="<?= base_url('public/documentation/login_2.png') ?>" class="">
        </li>
        <li class="py-2">If your credentials are correct, you will be redirected to the dashboard.
        <img src="<?= base_url('public/documentation/dashboard.png') ?>" class="">
        </li>
    </ol>

    <h3 class="text-xl font-semibold mt-8 mb-2">Role-Based Access</h3>
    <p class="mb-4">The File Management System provides role-based access control to ensure users have the appropriate permissions. The available roles include:</p>

    <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 shadow-md">
    <thead class="bg-orange-600 text-white">
        <tr>
        <th class="py-3 px-4 border-b text-left">Role</th>
        <th class="py-3 px-4 border-b text-left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr class="hover:bg-gray-100">
            <td class="py-3 px-4 border-b font-semibold">System Admin</td>
            <td class="py-3 px-4 border-b">Has full access to all files and folders, including the ability to create, upload, delete, rename, share, and download them.</td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="py-3 px-4 border-b font-semibold">Admin Officer / Division / School</td>
            <td class="py-3 px-4 border-b">Has similar access to System Admins, except they cannot delete files and folders.</td>
        </tr>
        <tr class="hover:bg-gray-100">
            <td class="py-3 px-4 border-b font-semibold">Personnel</td>
            <td class="py-3 px-4 border-b">Has read-only access, allowing them to view public and shared files and folders, as well as download them.</td>
        </tr>
    </tbody>

    </table>

    </div>

</section>