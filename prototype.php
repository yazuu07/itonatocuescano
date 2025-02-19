<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users Table</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
      <div>
        <h2 class="text-xl font-semibold text-gray-800">Users</h2>
        <p class="text-gray-600">A list of all the users in your account including their name, title, email and role.</p>
      </div>
      <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add user</button>
    </div>
    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="border-b">
          <th class="py-2 px-4 text-gray-700">Name</th>
          <th class="py-2 px-4 text-gray-700">Title</th>
          <th class="py-2 px-4 text-gray-700">Email</th>
          <th class="py-2 px-4 text-gray-700">Role</th>
          <th class="py-2 px-4"></th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-b hover:bg-gray-50">
          <td class="py-2 px-4">
            <a href="gallery.php" class="hover:underline">Lindsay Walton</a>
          </td>
          <td class="py-2 px-4">Front-end Developer</td>
          <td class="py-2 px-4">lindsay.walton@example.com</td>
          <td class="py-2 px-4">Member</td>
          <td class="py-2 px-4 text-blue-500 hover:underline cursor-pointer">Edit</td>
        </tr>
        <tr class="border-b hover:bg-gray-50">
          <td class="py-2 px-4">
            <a href="gallery.php" class="hover:underline">Courtney Henry</a>
          </td>
          <td class="py-2 px-4">Designer</td>
          <td class="py-2 px-4">courtney.henry@example.com</td>
          <td class="py-2 px-4">Admin</td>
          <td class="py-2 px-4 text-blue-500 hover:underline cursor-pointer">Edit</td>
        </tr>
        <tr class="border-b hover:bg-gray-50">
          <td class="py-2 px-4">
            <a href="gallery.php" class="hover:underline">Tom Cook</a>
          </td>
          <td class="py-2 px-4">Director of Product</td>
          <td class="py-2 px-4">tom.cook@example.com</td>
          <td class="py-2 px-4">Member</td>
          <td class="py-2 px-4 text-blue-500 hover:underline cursor-pointer">Edit</td>
        </tr>
        <tr class="border-b hover:bg-gray-50">
          <td class="py-2 px-4">
            <a href="gallery.php" class="hover:underline">Whitney Francis</a>
          </td>
          <td class="py-2 px-4">Copywriter</td>
          <td class="py-2 px-4">whitney.francis@example.com</td>
          <td class="py-2 px-4">Admin</td>
          <td class="py-2 px-4 text-blue-500 hover:underline cursor-pointer">Edit</td>
        </tr>
        <tr class="border-b hover:bg-gray-50">
          <td class="py-2 px-4">
            <a href="gallery.php" class="hover:underline">Leonard Krasner</a>
          </td>
          <td class="py-2 px-4">Senior Designer</td>
          <td class="py-2 px-4">leonard.krasner@example.com</td>
          <td class="py-2 px-4">Owner</td>
          <td class="py-2 px-4 text-blue-500 hover:underline cursor-pointer">Edit</td>
        </tr>
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4">
            <a href="gallery.php" class="text-blue-500 hover:underline">Floyd Miles</a>
          </td>
          <td class="py-2 px-4">Principal Designer</td>
          <td class="py-2 px-4">floyd.miles@example.com</td>
          <td class="py-2 px-4">Member</td>
          <td class="py-2 px-4 text-blue-500 hover:underline cursor-pointer">Edit</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
